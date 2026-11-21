<?php
/**
 * Launch checklist: tracks information that is Pending Client Confirmation
 * before the website can be treated as final.
 *
 * @package SecPlusCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Manually confirmed items (from the content blueprint's owner decisions and evidence requirements).
 *
 * @return array<string, array{0:string,1:string}>
 */
function secplus_core_manual_items() {
	return array(
		'history'      => array( __( 'Company story: founding date, leadership and approved company history for the About page.', 'secplus-core' ), 'about' ),
		'values'       => array( __( 'Confirm the values on the About page (Clarity, Integrity, Responsiveness, Confidentiality, Professional responsibility) reflect the firm.', 'secplus-core' ), 'about' ),
		'credentials'  => array( __( 'Professional qualifications, registrations and memberships (including the details behind "Certified Secretaries (Kenya)") verified for publication.', 'secplus-core' ), 'our-people' ),
		'team'         => array( __( 'Team profiles with written consent to publish, then publish the Our People & Credentials page and add it to the About menu.', 'secplus-core' ), 'our-people' ),
		'scope'        => array( __( 'Exact service scope confirmed, including registered office, local director/representative services, loans and employee share schemes, governance reviews, board evaluation and regulatory liaison.', 'secplus-core' ), 'services' ),
		'remote'       => array( __( 'Confirm which services can be completed or coordinated for clients abroad (International Investors page).', 'secplus-core' ), 'international-investors' ),
		'testimonials' => array( __( 'Approved testimonials or anonymized case studies with client consent, then publish the Client Experiences page.', 'secplus-core' ), 'client-experiences' ),
		'logos'        => array( __( 'Written permission from each organization shown in the homepage client logo strip (17 logos). Remove any logo without permission: select it in the Home page editor and delete the image block.', 'secplus-core' ), 'home' ),
		'chat'         => array( __( 'Review the chat assistant answers (SecPlus → Chat answers) so the tone and facts match how SecPlus advises clients.', 'secplus-core' ), '' ),
		'enquiries'    => array( __( 'Decide who receives website enquiries and a realistic response standard (then add it in Site settings).', 'secplus-core' ), '' ),
		'legal'        => array( __( 'Legal review of the Privacy Policy, Terms of Use and Cookie Notice, including the registered legal entity name.', 'secplus-core' ), 'privacy-policy' ),
		'photography'  => array( __( 'Approve the AI-generated photos on the homepage and every page hero (Higgsfield) or replace them with your own photography. The people shown are not SecPlus staff, so never caption or present them as the team.', 'secplus-core' ), 'home' ),
		'logo'         => array( __( 'High-resolution or SVG version of the original SecPlus logo for sharp display on high-density screens.', 'secplus-core' ), '' ),
		'social'       => array( __( 'Verified social media profiles (add in Site settings; none are shown until then).', 'secplus-core' ), '' ),
		'seo'          => array( __( 'Keyword validation for page titles and meta descriptions, and redirects from any existing website URLs.', 'secplus-core' ), '' ),
	);
}

/**
 * Builds the full checklist with live status.
 *
 * @return array<int, array{key:string,label:string,done:bool,auto:bool,link:string}>
 */
function secplus_core_checklist_items() {
	$items    = array();
	$settings = admin_url( 'admin.php?page=secplus-settings' );

	$auto = array(
		'legal_name'        => __( 'Registered business name', 'secplus-core' ),
		'phone'             => __( 'Verified telephone number', 'secplus-core' ),
		'email'             => __( 'Public enquiries email address', 'secplus-core' ),
		'address'           => __( 'Verified office address', 'secplus-core' ),
		'enquiry_recipient' => __( 'Enquiry notification recipient', 'secplus-core' ),
		'whatsapp'          => __( 'WhatsApp number for the chat assistant hand-over', 'secplus-core' ),
	);
	foreach ( $auto as $key => $label ) {
		$items[] = array( 'key' => $key, 'label' => $label, 'done' => '' !== secplus_core_get( $key ), 'auto' => true, 'link' => $settings );
	}

	$review = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => array( 'publish', 'pending', 'draft' ),
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery
				'relation' => 'OR',
				array( 'key' => 'secplus_reviewer', 'compare' => 'NOT EXISTS' ),
				array( 'key' => 'secplus_reviewer', 'value' => '' ),
			),
		)
	);
	$items[] = array(
		'key'   => 'articles',
		/* translators: %d: number of guides */
		'label' => $review ? sprintf( _n( '%d insight guide needs professional review (add the reviewer and review date in the "SEO & review" panel, then publish).', '%d insight guides need professional review (add the reviewer and review date in the "SEO & review" panel, then publish).', count( $review ), 'secplus-core' ), count( $review ) ) : __( 'All insight guides have a recorded professional reviewer.', 'secplus-core' ),
		'done'  => ! $review,
		'auto'  => true,
		'link'  => admin_url( 'edit.php?post_type=post' ),
	);

	$items[] = array( 'key' => 'site_logo', 'label' => __( 'Original SecPlus logo set as the Site Logo', 'secplus-core' ), 'done' => (bool) get_option( 'site_logo' ), 'auto' => true, 'link' => admin_url( 'site-editor.php' ) );

	$confirmed = (array) get_option( 'secplus_checklist', array() );
	foreach ( secplus_core_manual_items() as $key => $item ) {
		$page    = $item[1] ? get_page_by_path( 'about/' . $item[1] ) : null;
		$page    = $page ? $page : ( $item[1] ? get_page_by_path( $item[1] ) : null );
		$page    = $page ? $page : ( $item[1] ? get_page_by_path( 'services/' . $item[1] ) : null );
		$page    = $page ? $page : ( $item[1] ? get_page_by_path( 'who-we-help/' . $item[1] ) : null );
		$items[] = array(
			'key'   => $key,
			'label' => $item[0],
			'done'  => in_array( $key, $confirmed, true ),
			'auto'  => false,
			'link'  => $page ? get_edit_post_link( $page->ID, 'raw' ) : '',
		);
	}
	return $items;
}

/**
 * Number of outstanding items.
 *
 * @return int
 */
function secplus_core_pending_count() {
	return count( array_filter( secplus_core_checklist_items(), function ( $i ) {
		return ! $i['done'];
	} ) );
}

/**
 * Handles checklist form saves.
 */
function secplus_core_save_checklist() {
	if ( ! current_user_can( 'edit_pages' ) || ! check_admin_referer( 'secplus_checklist' ) ) {
		wp_die( esc_html__( 'Not allowed.', 'secplus-core' ) );
	}
	$valid     = array_keys( secplus_core_manual_items() );
	$confirmed = isset( $_POST['confirmed'] ) ? array_map( 'sanitize_key', (array) wp_unslash( $_POST['confirmed'] ) ) : array();
	update_option( 'secplus_checklist', array_values( array_intersect( $valid, $confirmed ) ), false );
	wp_safe_redirect( admin_url( 'admin.php?page=secplus&updated=1' ) );
	exit;
}
add_action( 'admin_post_secplus_checklist', 'secplus_core_save_checklist' );

/**
 * Renders the checklist page (SecPlus top-level page).
 */
function secplus_core_render_checklist_page() {
	$items   = secplus_core_checklist_items();
	$pending = count( array_filter( $items, function ( $i ) {
		return ! $i['done'];
	} ) );
	?>
	<div class="wrap secplus-checklist">
		<h1><?php esc_html_e( 'SecPlus launch checklist', 'secplus-core' ); ?></h1>
		<?php if ( isset( $_GET['updated'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Checklist saved.', 'secplus-core' ); ?></p></div>
		<?php endif; ?>
		<p style="max-width:760px"><?php esc_html_e( 'The website content follows the approved content blueprint. Information that has not been verified is not published: it is hidden on the website or kept in draft pages and is listed below as Pending Client Confirmation. Work through these items before launch.', 'secplus-core' ); ?></p>
		<p><strong>
			<?php
			/* translators: %d: count */
			echo esc_html( sprintf( _n( '%d item pending client confirmation', '%d items pending client confirmation', $pending, 'secplus-core' ), $pending ) );
			?>
		</strong></p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="secplus_checklist">
			<?php wp_nonce_field( 'secplus_checklist' ); ?>
			<table class="widefat striped" style="max-width:1000px">
				<thead><tr><th style="width:190px"><?php esc_html_e( 'Status', 'secplus-core' ); ?></th><th><?php esc_html_e( 'Item', 'secplus-core' ); ?></th><th style="width:120px"><?php esc_html_e( 'Update', 'secplus-core' ); ?></th></tr></thead>
				<tbody>
				<?php foreach ( $items as $item ) : ?>
					<tr>
						<td>
							<?php if ( $item['auto'] ) : ?>
								<span style="display:inline-block;padding:2px 10px;border-radius:99px;font-weight:600;<?php echo $item['done'] ? 'background:#E7F6EC;color:#0A5D2A' : 'background:#FFF4D6;color:#6A4A00'; ?>">
									<?php echo $item['done'] ? esc_html__( 'Confirmed', 'secplus-core' ) : esc_html__( 'Pending Client Confirmation', 'secplus-core' ); ?>
								</span>
							<?php else : ?>
								<label><input type="checkbox" name="confirmed[]" value="<?php echo esc_attr( $item['key'] ); ?>" <?php checked( $item['done'] ); ?>>
									<?php echo $item['done'] ? esc_html__( 'Confirmed', 'secplus-core' ) : esc_html__( 'Pending Client Confirmation', 'secplus-core' ); ?></label>
							<?php endif; ?>
						</td>
						<td><?php echo esc_html( $item['label'] ); ?></td>
						<td><?php if ( $item['link'] ) : ?><a href="<?php echo esc_url( $item['link'] ); ?>"><?php esc_html_e( 'Open', 'secplus-core' ); ?></a><?php endif; ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php submit_button( __( 'Save checklist', 'secplus-core' ) ); ?>
		</form>
	</div>
	<?php
}

/**
 * Dashboard reminder.
 */
function secplus_core_admin_notice() {
	$screen = get_current_screen();
	if ( ! $screen || 'dashboard' !== $screen->id || ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	$pending = secplus_core_pending_count();
	if ( ! $pending ) {
		return;
	}
	printf(
		'<div class="notice notice-warning"><p><strong>%1$s</strong> %2$s <a href="%3$s">%4$s</a></p></div>',
		esc_html__( 'SecPlus website:', 'secplus-core' ),
		/* translators: %d: count */
		esc_html( sprintf( _n( '%d item is pending client confirmation before launch.', '%d items are pending client confirmation before launch.', $pending, 'secplus-core' ), $pending ) ),
		esc_url( admin_url( 'admin.php?page=secplus' ) ),
		esc_html__( 'Open the launch checklist', 'secplus-core' )
	);
}
add_action( 'admin_notices', 'secplus_core_admin_notice' );

