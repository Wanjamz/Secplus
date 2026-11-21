<?php
/**
 * Content importer: creates the SecPlus pages, insight guides, categories,
 * front page, logo and permalink settings from the bundled content files.
 *
 * @package SecPlusCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Insight categories (kept in sync with the theme's topic cards).
 *
 * @return array<string, array{0:string,1:string}>
 */
function secplus_core_categories() {
	return array(
		'starting-a-business'          => array( 'Starting a Business in Kenya', 'Entity options, registration steps and what to do after incorporation.' ),
		'international-investment'     => array( 'International Investment & Market Entry', 'Establishing a Kenyan presence from abroad, branches and subsidiaries.' ),
		'corporate-compliance'         => array( 'Corporate Compliance', 'Annual returns, statutory records and company changes.' ),
		'company-secretarial-practice' => array( 'Company Secretarial Practice', 'The company secretary role, registers, resolutions and meetings.' ),
		'governance-and-boards'        => array( 'Governance & Boards', 'Board processes, governance documents and effective oversight.' ),
	);
}

/**
 * Replaces content tokens.
 *
 * @param string $content Raw content.
 * @return string
 */
function secplus_core_prepare_content( $content ) {
	return str_replace(
		array( '{{home}}', '{{theme}}' ),
		array( untrailingslashit( home_url() ), untrailingslashit( get_template_directory_uri() ) ),
		$content
	);
}

/**
 * Reads a JSON manifest.
 *
 * @param string $type pages|posts.
 * @return array
 */
function secplus_core_manifest( $type ) {
	$file = SECPLUS_CORE_DIR . "content/{$type}/manifest.json";
	if ( ! file_exists( $file ) ) {
		return array();
	}
	$data = json_decode( (string) file_get_contents( $file ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	return is_array( $data ) ? $data : array();
}

/**
 * Runs the import.
 *
 * @param array $args Options: publish_guides, overwrite, trash_samples, permalinks, site_identity.
 * @return string[] Log lines.
 */
function secplus_core_run_import( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'publish_guides' => false,
			'overwrite'      => false,
			'trash_samples'  => true,
			'permalinks'     => true,
			'site_identity'  => true,
		)
	);
	$log = array();

	// Allow block markup (SVG-free) to be saved exactly as authored.
	kses_remove_filters();

	// 1. Categories.
	$cat_ids = array();
	foreach ( secplus_core_categories() as $slug => $cat ) {
		$term = get_term_by( 'slug', $slug, 'category' );
		if ( ! $term ) {
			$res = wp_insert_term( $cat[0], 'category', array( 'slug' => $slug, 'description' => $cat[1] ) );
			if ( ! is_wp_error( $res ) ) {
				$cat_ids[ $slug ] = (int) $res['term_id'];
				$log[]            = "Created category: {$cat[0]}";
			}
		} else {
			$cat_ids[ $slug ] = (int) $term->term_id;
		}
	}

	// 2. Pages.
	$page_ids = array();
	foreach ( secplus_core_manifest( 'pages' ) as $page ) {
		$file = SECPLUS_CORE_DIR . 'content/pages/' . sanitize_file_name( $page['slug'] ) . '.html';
		if ( ! file_exists( $file ) ) {
			continue;
		}
		$content   = secplus_core_prepare_content( (string) file_get_contents( $file ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		$parent_id = $page['parent'] && isset( $page_ids[ $page['parent'] ] ) ? $page_ids[ $page['parent'] ] : 0;
		$path      = $page['parent'] ? $page['parent'] . '/' . $page['slug'] : $page['slug'];
		$existing  = get_page_by_path( $path, OBJECT, 'page' );

		$default_privacy_draft = $existing && 'privacy-policy' === $page['slug'] && 'draft' === $existing->post_status && 'publish' === $page['status'];
		$postarr               = array(
			'post_type'    => 'page',
			'post_title'   => $page['title'],
			'post_name'    => $page['slug'],
			'post_status'  => $page['status'],
			'post_parent'  => $parent_id,
			'menu_order'   => (int) $page['order'],
			'post_content' => wp_slash( $content ),
			'comment_status' => 'closed',
			'ping_status'  => 'closed',
		);

		if ( $existing && ! $args['overwrite'] && ! $default_privacy_draft ) {
			$page_ids[ $page['slug'] ] = $existing->ID;
			$log[]                     = "Kept existing page: {$page['title']}";
			continue;
		}
		if ( $existing ) {
			$postarr['ID'] = $existing->ID;
			$id            = wp_update_post( $postarr, true );
			$log[]         = "Updated page: {$page['title']}";
		} else {
			$id    = wp_insert_post( $postarr, true );
			$log[] = "Created page: {$page['title']}" . ( 'publish' !== $page['status'] ? ' (draft: Pending Client Confirmation)' : '' );
		}
		if ( is_wp_error( $id ) ) {
			$log[] = 'Error: ' . $id->get_error_message();
			continue;
		}
		$page_ids[ $page['slug'] ] = $id;
		update_post_meta( $id, 'secplus_meta_description', $page['meta'] );
		if ( $page['template'] ) {
			update_post_meta( $id, '_wp_page_template', $page['template'] );
		} else {
			delete_post_meta( $id, '_wp_page_template' );
		}
		if ( ! empty( $page['front'] ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $id );
			update_option( 'page_for_posts', 0 );
		}
		if ( 'privacy-policy' === $page['slug'] ) {
			update_option( 'wp_page_for_privacy_policy', $id );
		}
	}

	// 3. Insight guides.
	$status = $args['publish_guides'] ? 'publish' : 'pending';
	foreach ( secplus_core_manifest( 'posts' ) as $i => $post ) {
		$existing = get_page_by_path( $post['slug'], OBJECT, 'post' );
		if ( $existing && ! $args['overwrite'] ) {
			$log[] = "Kept existing guide: {$post['title']}";
			continue;
		}
		$file    = SECPLUS_CORE_DIR . 'content/posts/' . sanitize_file_name( $post['slug'] ) . '.html';
		$content = secplus_core_prepare_content( (string) file_get_contents( $file ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		$postarr = array(
			'post_type'      => 'post',
			'post_title'     => $post['title'],
			'post_name'      => $post['slug'],
			'post_status'    => $existing ? $existing->post_status : $status,
			'post_excerpt'   => $post['excerpt'],
			'post_content'   => wp_slash( $content ),
			'post_category'  => isset( $cat_ids[ $post['category'] ] ) ? array( $cat_ids[ $post['category'] ] ) : array(),
			'comment_status' => 'closed',
			'ping_status'    => 'closed',
			// Stagger dates so the newest-first order matches the editorial priority.
			'post_date'      => $existing ? $existing->post_date : gmdate( 'Y-m-d H:i:s', current_time( 'timestamp' ) - ( (int) $post['order'] * HOUR_IN_SECONDS ) ),
		);
		if ( $existing ) {
			$postarr['ID'] = $existing->ID;
			$id            = wp_update_post( $postarr, true );
		} else {
			$id = wp_insert_post( $postarr, true );
		}
		if ( is_wp_error( $id ) ) {
			$log[] = 'Error: ' . $id->get_error_message();
			continue;
		}
		update_post_meta( $id, 'secplus_meta_description', $post['meta'] );
		update_post_meta( $id, 'secplus_related_service', $post['service'] );
		update_post_meta( $id, '_secplus_reader', $post['reader'] );
		$log[] = ( $existing ? 'Updated' : 'Created' ) . " guide: {$post['title']} ({$postarr['post_status']})";
	}

	kses_init_filters();

	// 4. Logo.
	if ( ! get_option( 'site_logo' ) ) {
		$logo_id = secplus_core_import_logo();
		if ( $logo_id ) {
			update_option( 'site_logo', $logo_id );
			$log[] = 'Added the original SecPlus logo to the Media Library and set it as the Site Logo.';
		}
	}

	// 5. Site identity.
	if ( $args['site_identity'] ) {
		$name = get_option( 'blogname' );
		if ( '' === $name || in_array( $name, array( 'My WordPress Website', 'My WordPress Site', 'WordPress' ), true ) ) {
			update_option( 'blogname', 'SecPlus Consulting' );
			$log[] = 'Set site title: SecPlus Consulting';
		}
		$tag = get_option( 'blogdescription' );
		if ( '' === $tag || 'Just another WordPress site' === $tag ) {
			update_option( 'blogdescription', 'Clarity in compliance. Confidence in business.' );
			$log[] = 'Set tagline: Clarity in compliance. Confidence in business.';
		}
	}

	// Chat assistant starter answers (only if none exist yet).
	$chat = secplus_core_seed_chat();
	if ( $chat ) {
		$log[] = "Added {$chat} starter answers for the chat assistant (SecPlus → Chat answers).";
	}

	// 6. Discussion defaults: comments are not used on this site.
	update_option( 'default_comment_status', 'closed' );
	update_option( 'default_ping_status', 'closed' );

	// 7. Sample content.
	if ( $args['trash_samples'] ) {
		$hello = get_page_by_path( 'hello-world', OBJECT, 'post' );
		if ( $hello && 'publish' === $hello->post_status ) {
			wp_trash_post( $hello->ID );
			$log[] = 'Moved the default "Hello world!" post to the trash.';
		}
		$sample = get_page_by_path( 'sample-page', OBJECT, 'page' );
		if ( $sample ) {
			wp_trash_post( $sample->ID );
			$log[] = 'Moved the default "Sample Page" to the trash.';
		}
	}

	// 8. Permalinks.
	if ( $args['permalinks'] ) {
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/insights/%postname%/' );
		$log[] ='Set permalinks: pages at /page-name/, guides at /insights/guide-name/.';
	}
	flush_rewrite_rules();

	update_option( 'secplus_imported', time(), false );
	return $log;
}

/**
 * Copies the bundled original logo into the Media Library.
 *
 * @return int Attachment ID or 0.
 */
function secplus_core_import_logo() {
	$src = SECPLUS_CORE_DIR . 'assets/secplus-logo.png';
	if ( ! file_exists( $src ) ) {
		return 0;
	}
	$upload = wp_upload_bits( 'secplus-logo.png', null, (string) file_get_contents( $src ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}
	$id = wp_insert_attachment(
		array(
			'post_mime_type' => 'image/png',
			'post_title'     => 'SecPlus Consulting logo',
			'post_status'    => 'inherit',
		),
		$upload['file']
	);
	if ( is_wp_error( $id ) || ! $id ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );
	update_post_meta( $id, '_wp_attachment_image_alt', 'SecPlus Consulting: Certified Secretaries (Kenya)' );
	return (int) $id;
}

/**
 * Admin sub-page.
 */
function secplus_core_import_menu() {
	add_submenu_page( 'secplus', __( 'Import content', 'secplus-core' ), __( 'Import content', 'secplus-core' ), 'manage_options', 'secplus-import', 'secplus_core_render_import_page' );
}
add_action( 'admin_menu', 'secplus_core_import_menu', 30 );

/**
 * Handles the import form.
 */
function secplus_core_handle_import() {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'secplus_import' ) ) {
		wp_die( esc_html__( 'Not allowed.', 'secplus-core' ) );
	}
	$log = secplus_core_run_import(
		array(
			'publish_guides' => ! empty( $_POST['publish_guides'] ),
			'overwrite'      => ! empty( $_POST['overwrite'] ),
			'trash_samples'  => ! empty( $_POST['trash_samples'] ),
			'permalinks'     => ! empty( $_POST['permalinks'] ),
			'site_identity'  => ! empty( $_POST['site_identity'] ),
		)
	);
	set_transient( 'secplus_import_log_' . get_current_user_id(), $log, 10 * MINUTE_IN_SECONDS );
	wp_safe_redirect( admin_url( 'admin.php?page=secplus-import&done=1' ) );
	exit;
}
add_action( 'admin_post_secplus_import', 'secplus_core_handle_import' );

/**
 * Renders the import page.
 */
function secplus_core_render_import_page() {
	$log      = get_transient( 'secplus_import_log_' . get_current_user_id() );
	$imported = get_option( 'secplus_imported' );
	$theme_ok = 'secplus' === get_template();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Import SecPlus website content', 'secplus-core' ); ?></h1>
		<?php if ( ! $theme_ok ) : ?>
			<div class="notice notice-warning"><p><?php esc_html_e( 'Activate the SecPlus Consulting theme before importing: the page layouts depend on it.', 'secplus-core' ); ?></p></div>
		<?php endif; ?>
		<?php if ( $log ) : ?>
			<div class="notice notice-success"><p><strong><?php esc_html_e( 'Import complete.', 'secplus-core' ); ?></strong> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'View the website', 'secplus-core' ); ?></a> · <a href="<?php echo esc_url( admin_url( 'admin.php?page=secplus' ) ); ?>"><?php esc_html_e( 'Open the launch checklist', 'secplus-core' ); ?></a></p>
				<details><summary><?php esc_html_e( 'Details', 'secplus-core' ); ?></summary><ul style="list-style:disc;margin-left:20px">
				<?php foreach ( $log as $line ) : ?>
					<li><?php echo esc_html( $line ); ?></li>
				<?php endforeach; ?>
				</ul></details>
			</div>
			<?php delete_transient( 'secplus_import_log_' . get_current_user_id() ); ?>
		<?php endif; ?>
		<p style="max-width:760px"><?php esc_html_e( 'Creates the complete site structure from the approved content blueprint: homepage, Who We Help and Services hubs with their detailed pages, About, How We Work, FAQs, Insights & Resources, Contact and legal pages, plus ten insight guides and their categories. Everything remains editable in the block editor afterwards.', 'secplus-core' ); ?></p>
		<?php if ( $imported ) : ?>
			<p><em>
				<?php
				/* translators: %s: date */
				echo esc_html( sprintf( __( 'Last imported: %s. Running the import again only adds missing items unless you choose to overwrite.', 'secplus-core' ), wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), (int) $imported ) ) );
				?>
			</em></p>
		<?php endif; ?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="secplus_import">
			<?php wp_nonce_field( 'secplus_import' ); ?>
			<fieldset style="display:grid;gap:10px;margin:16px 0 8px">
				<label><input type="checkbox" name="publish_guides" value="1"> <?php esc_html_e( 'Publish the insight guides immediately. Leave unticked to import them as "Pending Review" until a qualified reviewer has checked them against current official sources.', 'secplus-core' ); ?></label>
				<label><input type="checkbox" name="overwrite" value="1"> <?php esc_html_e( 'Overwrite existing pages and guides with the same address (replaces any edits made to them).', 'secplus-core' ); ?></label>
				<label><input type="checkbox" name="trash_samples" value="1" checked> <?php esc_html_e( 'Move the default WordPress "Hello world!" post and "Sample Page" to the trash.', 'secplus-core' ); ?></label>
				<label><input type="checkbox" name="permalinks" value="1" checked> <?php esc_html_e( 'Use SEO-friendly addresses (/services/company-registration/, /insights/guide-name/).', 'secplus-core' ); ?></label>
				<label><input type="checkbox" name="site_identity" value="1" checked> <?php esc_html_e( 'Set the site title and tagline if they are still the WordPress defaults.', 'secplus-core' ); ?></label>
			</fieldset>
			<?php submit_button( $imported ? __( 'Run import again', 'secplus-core' ) : __( 'Import website content', 'secplus-core' ) ); ?>
		</form>
	</div>
	<?php
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	/**
	 * Imports SecPlus content.
	 *
	 * ## OPTIONS
	 *
	 * [--publish-guides]
	 * : Publish insight guides instead of importing them as Pending Review.
	 *
	 * [--overwrite]
	 * : Overwrite existing pages and guides.
	 */
	WP_CLI::add_command(
		'secplus import',
		function ( $args, $assoc ) {
			$log = secplus_core_run_import(
				array(
					'publish_guides' => isset( $assoc['publish-guides'] ),
					'overwrite'      => isset( $assoc['overwrite'] ),
				)
			);
			foreach ( $log as $line ) {
				WP_CLI::log( $line );
			}
			WP_CLI::success( 'SecPlus content imported.' );
		}
	);
}
