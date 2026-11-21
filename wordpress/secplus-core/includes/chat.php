<?php
/**
 * SecPlus chat assistant: a WhatsApp-style FAQ chat on the website that answers
 * common questions instantly and hands the conversation to an adviser on
 * WhatsApp (or the enquiry form when no WhatsApp number is set).
 *
 * Answers are editable under SecPlus → Chat answers. Nothing typed in the chat
 * is stored or sent anywhere; text only leaves the page when the visitor taps
 * the WhatsApp button themselves.
 *
 * @package SecPlusCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the editable "Chat answers" content type.
 */
function secplus_core_register_chat_type() {
	register_post_type(
		'secplus_chat',
		array(
			'labels'          => array(
				'name'          => __( 'Chat answers', 'secplus-core' ),
				'singular_name' => __( 'Chat answer', 'secplus-core' ),
				'menu_name'     => __( 'Chat answers', 'secplus-core' ),
				'all_items'     => __( 'Chat answers', 'secplus-core' ),
				'add_new_item'  => __( 'Add chat answer', 'secplus-core' ),
				'edit_item'     => __( 'Edit chat answer', 'secplus-core' ),
				'new_item'      => __( 'New chat answer', 'secplus-core' ),
				'search_items'  => __( 'Search chat answers', 'secplus-core' ),
				'not_found'     => __( 'No chat answers yet.', 'secplus-core' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => 'secplus',
			'show_in_rest'    => false,
			'supports'        => array( 'title', 'page-attributes' ),
			'capability_type' => 'page',
			'map_meta_cap'    => true,
			'rewrite'         => false,
			'query_var'       => false,
		)
	);
}
add_action( 'init', 'secplus_core_register_chat_type' );

/**
 * Imports the starter answers once (or again when explicitly requested).
 *
 * @param bool $force Re-create even if answers already exist.
 * @return int Number of answers created.
 */
function secplus_core_seed_chat( $force = false ) {
	if ( ! $force && get_option( 'secplus_chat_seeded' ) ) {
		return 0;
	}
	$existing = get_posts( array( 'post_type' => 'secplus_chat', 'post_status' => 'any', 'posts_per_page' => 1, 'fields' => 'ids' ) );
	if ( $existing && ! $force ) {
		update_option( 'secplus_chat_seeded', 1, false );
		return 0;
	}
	$created = 0;
	foreach ( (array) require SECPLUS_CORE_DIR . 'includes/chat-defaults.php' as $i => $entry ) {
		$id = wp_insert_post(
			array(
				'post_type'   => 'secplus_chat',
				'post_status' => 'publish',
				'post_title'  => $entry['title'],
				'menu_order'  => $i,
			),
			true
		);
		if ( is_wp_error( $id ) ) {
			continue;
		}
		update_post_meta( $id, '_spc_answer', $entry['answer'] );
		update_post_meta( $id, '_spc_keywords', $entry['keywords'] );
		update_post_meta( $id, '_spc_quick', $entry['quick'] ? '1' : '' );
		update_post_meta( $id, '_spc_service', $entry['service'] );
		update_post_meta( $id, '_spc_link_url', $entry['link'][0] );
		update_post_meta( $id, '_spc_link_label', $entry['link'][1] );
		++$created;
	}
	update_option( 'secplus_chat_seeded', 1, false );
	return $created;
}
add_action(
	'admin_init',
	function () {
		if ( current_user_can( 'edit_pages' ) ) {
			secplus_core_seed_chat();
		}
	}
);

/**
 * Editor meta box for an answer.
 */
function secplus_core_chat_meta_boxes() {
	add_meta_box( 'secplus-chat', __( 'Chat answer', 'secplus-core' ), 'secplus_core_render_chat_box', 'secplus_chat', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'secplus_core_chat_meta_boxes' );

/**
 * Renders the answer fields.
 *
 * @param WP_Post $post Post.
 */
function secplus_core_render_chat_box( $post ) {
	$m = function ( $k ) use ( $post ) {
		return (string) get_post_meta( $post->ID, '_spc_' . $k, true );
	};
	wp_nonce_field( 'secplus_chat_save', 'secplus_chat_nonce' );
	$services = secplus_core_enquiry_options()['services'];
	?>
	<p class="description"><?php esc_html_e( 'The title above is the question as a visitor might ask it. It also appears on the topic button.', 'secplus-core' ); ?></p>
	<p>
		<label for="spc-answer"><strong><?php esc_html_e( 'Answer', 'secplus-core' ); ?></strong></label><br>
		<textarea id="spc-answer" name="spc_answer" rows="9" class="large-text"><?php echo esc_textarea( $m( 'answer' ) ); ?></textarea>
		<span class="description"><?php esc_html_e( 'Write the way you would reply on WhatsApp: warm, short and plain. Leave a blank line to start a new chat bubble. Avoid prices, timelines or guarantees you have not confirmed.', 'secplus-core' ); ?></span>
	</p>
	<p>
		<label for="spc-keywords"><strong><?php esc_html_e( 'Keywords', 'secplus-core' ); ?></strong></label><br>
		<input id="spc-keywords" name="spc_keywords" type="text" class="large-text" value="<?php echo esc_attr( $m( 'keywords' ) ); ?>">
		<span class="description"><?php esc_html_e( 'Comma-separated words and phrases a visitor might type, e.g. "annual return, filing, overdue".', 'secplus-core' ); ?></span>
	</p>
	<p>
		<label><input type="checkbox" name="spc_quick" value="1" <?php checked( '1', $m( 'quick' ) ); ?>> <?php esc_html_e( 'Show as a starter topic button when the chat opens', 'secplus-core' ); ?></label>
	</p>
	<p>
		<label for="spc-service"><strong><?php esc_html_e( 'Related service', 'secplus-core' ); ?></strong></label><br>
		<select id="spc-service" name="spc_service">
			<?php foreach ( $services as $slug => $label ) : ?>
				<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $m( 'service' ), $slug ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
		</select>
		<span class="description"><?php esc_html_e( 'Preselected on the enquiry form when there is no WhatsApp number.', 'secplus-core' ); ?></span>
	</p>
	<p>
		<label for="spc-link-url"><strong><?php esc_html_e( 'Helpful link (optional)', 'secplus-core' ); ?></strong></label><br>
		<input id="spc-link-url" name="spc_link_url" type="text" class="regular-text" placeholder="/services/company-registration/" value="<?php echo esc_attr( $m( 'link_url' ) ); ?>">
		<input name="spc_link_label" type="text" class="regular-text" placeholder="<?php esc_attr_e( 'Link text', 'secplus-core' ); ?>" value="<?php echo esc_attr( $m( 'link_label' ) ); ?>">
	</p>
	<?php
}

/**
 * Saves answer fields.
 *
 * @param int $post_id Post.
 */
function secplus_core_save_chat( $post_id ) {
	if ( ! isset( $_POST['secplus_chat_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['secplus_chat_nonce'] ), 'secplus_chat_save' ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$raw = wp_unslash( $_POST );
	update_post_meta( $post_id, '_spc_answer', sanitize_textarea_field( $raw['spc_answer'] ?? '' ) );
	update_post_meta( $post_id, '_spc_keywords', sanitize_text_field( $raw['spc_keywords'] ?? '' ) );
	update_post_meta( $post_id, '_spc_quick', empty( $raw['spc_quick'] ) ? '' : '1' );
	update_post_meta( $post_id, '_spc_service', sanitize_key( $raw['spc_service'] ?? 'not-sure' ) );
	update_post_meta( $post_id, '_spc_link_url', esc_url_raw( $raw['spc_link_url'] ?? '' ) );
	update_post_meta( $post_id, '_spc_link_label', sanitize_text_field( $raw['spc_link_label'] ?? '' ) );
}
add_action( 'save_post_secplus_chat', 'secplus_core_save_chat' );

/**
 * List columns.
 */
add_filter(
	'manage_secplus_chat_posts_columns',
	function ( $cols ) {
		return array(
			'cb'        => $cols['cb'],
			'title'     => __( 'Question', 'secplus-core' ),
			'spc_quick' => __( 'Starter topic', 'secplus-core' ),
			'spc_kw'    => __( 'Keywords', 'secplus-core' ),
		);
	}
);
add_action(
	'manage_secplus_chat_posts_custom_column',
	function ( $col, $post_id ) {
		if ( 'spc_quick' === $col ) {
			echo get_post_meta( $post_id, '_spc_quick', true ) ? '&#10003;' : '';
		} elseif ( 'spc_kw' === $col ) {
			echo esc_html( wp_trim_words( (string) get_post_meta( $post_id, '_spc_keywords', true ), 10 ) );
		}
	},
	10,
	2
);
add_action(
	'pre_get_posts',
	function ( $q ) {
		if ( is_admin() && $q->is_main_query() && 'secplus_chat' === $q->get( 'post_type' ) && ! $q->get( 'orderby' ) ) {
			$q->set( 'orderby', 'menu_order' );
			$q->set( 'order', 'ASC' );
		}
	}
);

/**
 * Front-end assets and data.
 */
function secplus_core_chat_assets() {
	if ( is_admin() || '0' === secplus_core_get( 'chat_enabled' ) ) {
		return;
	}
	$posts = get_posts(
		array(
			'post_type'      => 'secplus_chat',
			'post_status'    => 'publish',
			'posts_per_page' => 100,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'no_found_rows'  => true,
		)
	);
	if ( ! $posts ) {
		return;
	}
	$entries = array();
	foreach ( $posts as $p ) {
		$link = (string) get_post_meta( $p->ID, '_spc_link_url', true );
		if ( $link && 0 === strpos( $link, '/' ) ) {
			$link = home_url( $link );
		}
		$entries[] = array(
			'id'        => $p->ID,
			'q'         => html_entity_decode( get_the_title( $p ), ENT_QUOTES, 'UTF-8' ),
			'a'         => (string) get_post_meta( $p->ID, '_spc_answer', true ),
			'k'         => (string) get_post_meta( $p->ID, '_spc_keywords', true ),
			'quick'     => (bool) get_post_meta( $p->ID, '_spc_quick', true ),
			'service'   => (string) get_post_meta( $p->ID, '_spc_service', true ),
			'link'      => $link,
			'linkLabel' => (string) get_post_meta( $p->ID, '_spc_link_label', true ),
		);
	}

	$privacy = get_page_by_path( 'privacy-policy' );
	$data    = array(
		'name'     => secplus_core_get( 'chat_name' ) ? secplus_core_get( 'chat_name' ) : 'SecPlus',
		'whatsapp' => preg_replace( '/[^0-9]/', '', secplus_core_get( 'whatsapp' ) ),
		'contact'  => home_url( '/contact/' ),
		'privacy'  => $privacy ? get_permalink( $privacy ) : home_url( '/privacy-policy/' ),
		'site'     => get_bloginfo( 'name' ),
		'entries'  => $entries,
	);

	wp_enqueue_style( 'secplus-chat', SECPLUS_CORE_URL . 'assets/chat.css', array(), SECPLUS_CORE_VERSION );
	wp_enqueue_script(
		'secplus-chat',
		SECPLUS_CORE_URL . 'assets/chat.js',
		array(),
		SECPLUS_CORE_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
	wp_add_inline_script( 'secplus-chat', 'window.secplusChat = ' . wp_json_encode( $data ) . ';', 'before' );
}
add_action( 'wp_enqueue_scripts', 'secplus_core_chat_assets' );
