<?php
/**
 * Consultation enquiries: form handling, storage, notifications and privacy tools.
 *
 * @package SecPlusCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Option lists used by the form.
 *
 * @return array{services: array<string,string>, client_types: array<string,string>, contact: array<string,string>, statuses: array<string,string>}
 */
function secplus_core_enquiry_options() {
	return array(
		'services'     => array(
			'company-registration' => __( 'Company Registration & Entity Setup', 'secplus-core' ),
			'corporate-compliance' => __( 'Corporate Compliance & Statutory Filings', 'secplus-core' ),
			'company-secretarial'  => __( 'Company Secretarial Services', 'secplus-core' ),
			'corporate-governance' => __( 'Corporate Governance & Board Support', 'secplus-core' ),
			'corporate-advisory'   => __( 'Corporate Advisory & Restructuring', 'secplus-core' ),
			'not-sure'             => __( 'Not sure yet', 'secplus-core' ),
		),
		'client_types' => array(
			'kenyan-business'        => __( 'Kenyan business or founder', 'secplus-core' ),
			'international-investor' => __( 'International investor or diaspora founder', 'secplus-core' ),
			'corporate-board'        => __( 'Corporate board or established company', 'secplus-core' ),
			'professional-partner'   => __( 'Professional adviser referring a client', 'secplus-core' ),
			'other'                  => __( 'Other', 'secplus-core' ),
		),
		'contact'      => array(
			'email'    => __( 'Email', 'secplus-core' ),
			'phone'    => __( 'Phone call', 'secplus-core' ),
			'whatsapp' => __( 'WhatsApp', 'secplus-core' ),
		),
		'statuses'     => array(
			'new'       => __( 'New', 'secplus-core' ),
			'contacted' => __( 'Contacted', 'secplus-core' ),
			'proposal'  => __( 'Proposal sent', 'secplus-core' ),
			'engaged'   => __( 'Engaged', 'secplus-core' ),
			'closed'    => __( 'Closed', 'secplus-core' ),
		),
	);
}

/**
 * Registers the private enquiry post type.
 */
function secplus_core_register_enquiry_type() {
	register_post_type(
		'secplus_enquiry',
		array(
			'labels'          => array(
				'name'          => __( 'Enquiries', 'secplus-core' ),
				'singular_name' => __( 'Enquiry', 'secplus-core' ),
				'menu_name'     => __( 'Enquiries', 'secplus-core' ),
				'all_items'     => __( 'Enquiries', 'secplus-core' ),
				'edit_item'     => __( 'Enquiry', 'secplus-core' ),
				'search_items'  => __( 'Search enquiries', 'secplus-core' ),
				'not_found'     => __( 'No enquiries yet.', 'secplus-core' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => 'secplus',
			'show_in_rest'    => false,
			'supports'        => array( 'title' ),
			'capability_type' => 'post',
			'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'    => true,
			'rewrite'         => false,
			'query_var'       => false,
		)
	);
}
add_action( 'init', 'secplus_core_register_enquiry_type' );

/**
 * Hashed visitor identifier for rate limiting (no raw IP stored).
 *
 * @return string
 */
function secplus_core_visitor_key() {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	return 'secplus_rl_' . substr( wp_hash( $ip ), 0, 20 );
}

/**
 * Handles form submissions (logged-in and logged-out).
 */
function secplus_core_handle_enquiry() {
	$opts   = secplus_core_enquiry_options();
	$errors = array();

	// phpcs:disable WordPress.Security.NonceVerification.Missing -- public, cache-friendly form protected by honeypot, signed timestamp and rate limit.
	$raw = wp_unslash( $_POST );
	// phpcs:enable

	$back = isset( $raw['sp_return'] ) ? esc_url_raw( $raw['sp_return'] ) : '';
	$back = wp_validate_redirect( $back, home_url( '/contact/' ) );
	$back = remove_query_arg( array( 'enquiry', 'ek' ), $back );

	// Spam checks: honeypot, minimum completion time, rate limit.
	$is_spam = ! empty( $raw['sp_website'] );
	$ts      = isset( $raw['sp_ts'] ) ? (string) $raw['sp_ts'] : '';
	$parts   = explode( '.', $ts );
	if ( 2 !== count( $parts ) || ! hash_equals( substr( wp_hash( 'secplus_ts' . $parts[0] ), 0, 16 ), $parts[1] ) || ( time() - (int) $parts[0] ) < 3 ) {
		$is_spam = true;
	}
	if ( $is_spam ) {
		// Respond as if successful so bots learn nothing.
		wp_safe_redirect( add_query_arg( 'enquiry', 'sent', $back ) . '#enquiry' );
		exit;
	}
	$rl_key = secplus_core_visitor_key();
	$count  = (int) get_transient( $rl_key );
	if ( $count >= 5 ) {
		$errors['form'] = __( 'We have received several enquiries from your connection recently. Please try again later or contact us directly.', 'secplus-core' );
	}

	$data = array(
		'name'         => sanitize_text_field( $raw['sp_name'] ?? '' ),
		'email'        => sanitize_email( $raw['sp_email'] ?? '' ),
		'phone'        => preg_replace( '/[^0-9+\s()-]/', '', sanitize_text_field( $raw['sp_phone'] ?? '' ) ),
		'organization' => sanitize_text_field( $raw['sp_organization'] ?? '' ),
		'location'     => sanitize_text_field( $raw['sp_location'] ?? '' ),
		'client_type'  => sanitize_key( $raw['sp_client_type'] ?? '' ),
		'service'      => sanitize_key( $raw['sp_service'] ?? '' ),
		'contact_pref' => sanitize_key( $raw['sp_contact_pref'] ?? '' ),
		'message'      => sanitize_textarea_field( $raw['sp_message'] ?? '' ),
		'consent'      => ! empty( $raw['sp_consent'] ),
	);

	if ( '' === $data['name'] ) {
		$errors['name'] = __( 'Please enter your name.', 'secplus-core' );
	}
	if ( ! is_email( $data['email'] ) ) {
		$errors['email'] = __( 'Please enter a valid email address.', 'secplus-core' );
	}
	if ( ! isset( $opts['client_types'][ $data['client_type'] ] ) ) {
		$errors['client_type'] = __( 'Please tell us which best describes you.', 'secplus-core' );
	}
	if ( ! isset( $opts['services'][ $data['service'] ] ) ) {
		$errors['service'] = __( 'Please choose the support you are interested in.', 'secplus-core' );
	}
	if ( strlen( $data['message'] ) < 10 ) {
		$errors['message'] = __( 'Please tell us briefly what you need.', 'secplus-core' );
	}
	if ( strlen( $data['message'] ) > 5000 ) {
		$errors['message'] = __( 'Please keep your message under 5,000 characters.', 'secplus-core' );
	}
	if ( ! isset( $opts['contact'][ $data['contact_pref'] ] ) ) {
		$data['contact_pref'] = 'email';
	}
	if ( ! $data['consent'] ) {
		$errors['consent'] = __( 'Please confirm that we may use your information to respond.', 'secplus-core' );
	}

	if ( $errors ) {
		$token = wp_generate_password( 12, false );
		set_transient( 'secplus_enq_' . $token, array( 'errors' => $errors, 'data' => $data ), 15 * MINUTE_IN_SECONDS );
		wp_safe_redirect( add_query_arg( array( 'enquiry' => 'error', 'ek' => $token ), $back ) . '#enquiry' );
		exit;
	}

	set_transient( $rl_key, $count + 1, HOUR_IN_SECONDS );

	$service_label = $opts['services'][ $data['service'] ];
	$post_id       = wp_insert_post(
		array(
			'post_type'   => 'secplus_enquiry',
			'post_status' => 'private',
			/* translators: 1: name, 2: service */
			'post_title'  => sprintf( __( '%1$s: %2$s', 'secplus-core' ), $data['name'], $service_label ),
		),
		true
	);

	if ( ! is_wp_error( $post_id ) ) {
		$meta = array(
			'_sp_email'        => $data['email'],
			'_sp_phone'        => $data['phone'],
			'_sp_organization' => $data['organization'],
			'_sp_location'     => $data['location'],
			'_sp_client_type'  => $data['client_type'],
			'_sp_service'      => $data['service'],
			'_sp_contact_pref' => $data['contact_pref'],
			'_sp_message'      => $data['message'],
			'_sp_consent_at'   => current_time( 'mysql' ),
			'_sp_source'       => $back,
			'_sp_status'       => 'new',
		);
		foreach ( $meta as $k => $v ) {
			update_post_meta( $post_id, $k, $v );
		}
	}

	// Notification email.
	$to = secplus_core_get( 'enquiry_recipient' );
	$to = is_email( $to ) ? $to : get_option( 'admin_email' );
	$lines = array(
		__( 'A new enquiry was submitted on the SecPlus website.', 'secplus-core' ),
		'',
		__( 'Name', 'secplus-core' ) . ': ' . $data['name'],
		__( 'Email', 'secplus-core' ) . ': ' . $data['email'],
		__( 'Phone', 'secplus-core' ) . ': ' . ( $data['phone'] ? $data['phone'] : '—' ),
		__( 'Organization', 'secplus-core' ) . ': ' . ( $data['organization'] ? $data['organization'] : '—' ),
		__( 'Location', 'secplus-core' ) . ': ' . ( $data['location'] ? $data['location'] : '—' ),
		__( 'Describes themselves as', 'secplus-core' ) . ': ' . $opts['client_types'][ $data['client_type'] ],
		__( 'Support required', 'secplus-core' ) . ': ' . $service_label,
		__( 'Preferred contact', 'secplus-core' ) . ': ' . $opts['contact'][ $data['contact_pref'] ],
		'',
		__( 'Message', 'secplus-core' ) . ':',
		$data['message'],
		'',
		! is_wp_error( $post_id ) ? __( 'View in WordPress', 'secplus-core' ) . ': ' . admin_url( 'post.php?post=' . (int) $post_id . '&action=edit' ) : '',
	);
	$reply = str_replace( array( "\r", "\n", '<', '>', '"' ), '', $data['name'] ) . ' <' . $data['email'] . '>';
	wp_mail(
		$to,
		/* translators: %s: service */
		sprintf( __( 'New website enquiry: %s', 'secplus-core' ), $service_label ),
		implode( "\n", $lines ),
		array( 'Reply-To: ' . $reply )
	);

	wp_safe_redirect( add_query_arg( 'enquiry', 'sent', $back ) . '#enquiry' );
	exit;
}
add_action( 'admin_post_nopriv_secplus_enquiry', 'secplus_core_handle_enquiry' );
add_action( 'admin_post_secplus_enquiry', 'secplus_core_handle_enquiry' );

/**
 * Renders the enquiry form (used by the secplus/enquiry-form block).
 *
 * @return string
 */
function secplus_core_render_enquiry_form() {
	$opts = secplus_core_enquiry_options();

	// phpcs:disable WordPress.Security.NonceVerification.Recommended -- read-only display state.
	$state = isset( $_GET['enquiry'] ) ? sanitize_key( wp_unslash( $_GET['enquiry'] ) ) : '';
	$token = isset( $_GET['ek'] ) ? sanitize_key( wp_unslash( $_GET['ek'] ) ) : '';
	$pre_s = isset( $_GET['service'] ) ? sanitize_key( wp_unslash( $_GET['service'] ) ) : '';
	$pre_a = isset( $_GET['audience'] ) ? sanitize_key( wp_unslash( $_GET['audience'] ) ) : '';
	// phpcs:enable

	if ( 'sent' === $state ) {
		$response = secplus_core_get( 'response_time' );
		return '<div class="sp-form__notice sp-form__notice--success" role="status" tabindex="-1">'
			. '<p><strong>' . esc_html__( 'Thank you for contacting SecPlus.', 'secplus-core' ) . '</strong></p>'
			. '<p>' . esc_html__( 'Your enquiry has been received. Our team will review the information and contact you about the appropriate next step.', 'secplus-core' ) . ( $response ? ' ' . esc_html( $response ) : '' ) . '</p>'
			. '<p>' . esc_html__( 'Please do not send confidential identity or corporate documents unless specifically requested through a secure process.', 'secplus-core' ) . '</p>'
			. '</div>';
	}

	$errors = array();
	$old    = array();
	if ( 'error' === $state && $token ) {
		$stored = get_transient( 'secplus_enq_' . $token );
		if ( is_array( $stored ) ) {
			$errors = $stored['errors'];
			$old    = $stored['data'];
		}
	}
	$val = function ( $key ) use ( $old ) {
		return isset( $old[ $key ] ) ? $old[ $key ] : '';
	};
	if ( ! $old ) {
		$old['service']     = isset( $opts['services'][ $pre_s ] ) ? $pre_s : '';
		$old['client_type'] = isset( $opts['client_types'][ $pre_a ] ) ? $pre_a : '';
	}
	$err = function ( $key ) use ( $errors ) {
		return isset( $errors[ $key ] ) ? '<span class="sp-field__error" id="sp-err-' . esc_attr( $key ) . '">' . esc_html( $errors[ $key ] ) . '</span>' : '';
	};
	$aria = function ( $key ) use ( $errors ) {
		return isset( $errors[ $key ] ) ? ' aria-invalid="true" aria-describedby="sp-err-' . esc_attr( $key ) . '"' : '';
	};
	$select = function ( $name, $key, $choices, $placeholder ) use ( $old, $aria ) {
		$html = '<select id="sp-' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" required' . $aria( $key ) . '><option value="">' . esc_html( $placeholder ) . '</option>';
		foreach ( $choices as $v => $label ) {
			$html .= '<option value="' . esc_attr( $v ) . '"' . selected( $old[ $key ] ?? '', $v, false ) . '>' . esc_html( $label ) . '</option>';
		}
		return $html . '</select>';
	};

	$ts      = time();
	$ts_sig  = $ts . '.' . substr( wp_hash( 'secplus_ts' . $ts ), 0, 16 );
	$return  = set_url_scheme( ( is_ssl() ? 'https://' : 'http://' ) . ( isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '' ) . ( isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '' ) );
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		$return = home_url( '/contact/' );
	}
	$privacy = get_page_by_path( 'privacy-policy' );
	$privacy = $privacy ? get_permalink( $privacy ) : home_url( '/privacy-policy/' );

	ob_start();
	?>
	<form class="sp-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
		<?php if ( $errors ) : ?>
			<div class="sp-form__notice sp-form__notice--error" role="alert">
				<p><strong><?php esc_html_e( 'Please check the highlighted fields.', 'secplus-core' ); ?></strong></p>
				<?php if ( isset( $errors['form'] ) ) : ?>
					<p><?php echo esc_html( $errors['form'] ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<input type="hidden" name="action" value="secplus_enquiry">
		<input type="hidden" name="sp_ts" value="<?php echo esc_attr( $ts_sig ); ?>">
		<input type="hidden" name="sp_return" value="<?php echo esc_url( $return ); ?>">
		<div class="sp-hp" aria-hidden="true">
			<label for="sp-website"><?php esc_html_e( 'Leave this field empty', 'secplus-core' ); ?></label>
			<input type="text" id="sp-website" name="sp_website" tabindex="-1" autocomplete="off">
		</div>

		<div class="sp-form__row">
			<div class="sp-field">
				<label for="sp-name"><?php esc_html_e( 'Full name', 'secplus-core' ); ?> *</label>
				<input type="text" id="sp-name" name="sp_name" autocomplete="name" required maxlength="120" value="<?php echo esc_attr( $val( 'name' ) ); ?>"<?php echo $aria( 'name' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
				<?php echo $err( 'name' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
			<div class="sp-field">
				<label for="sp-email"><?php esc_html_e( 'Email address', 'secplus-core' ); ?> *</label>
				<input type="email" id="sp-email" name="sp_email" autocomplete="email" required maxlength="190" value="<?php echo esc_attr( $val( 'email' ) ); ?>"<?php echo $aria( 'email' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
				<?php echo $err( 'email' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
		</div>

		<div class="sp-form__row">
			<div class="sp-field">
				<label for="sp-phone"><?php esc_html_e( 'Phone', 'secplus-core' ); ?> <span class="sp-hint"><?php esc_html_e( '(optional, with country code)', 'secplus-core' ); ?></span></label>
				<input type="tel" id="sp-phone" name="sp_phone" autocomplete="tel" maxlength="40" value="<?php echo esc_attr( $val( 'phone' ) ); ?>">
			</div>
			<div class="sp-field">
				<label for="sp-organization"><?php esc_html_e( 'Organization', 'secplus-core' ); ?> <span class="sp-hint"><?php esc_html_e( '(optional)', 'secplus-core' ); ?></span></label>
				<input type="text" id="sp-organization" name="sp_organization" autocomplete="organization" maxlength="160" value="<?php echo esc_attr( $val( 'organization' ) ); ?>">
			</div>
		</div>

		<div class="sp-form__row">
			<div class="sp-field">
				<label for="sp-client_type"><?php esc_html_e( 'Which best describes you?', 'secplus-core' ); ?> *</label>
				<?php echo $select( 'sp_client_type', 'client_type', $opts['client_types'], __( 'Select an option', 'secplus-core' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				<?php echo $err( 'client_type' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
			<div class="sp-field">
				<label for="sp-location"><?php esc_html_e( 'Where are you based?', 'secplus-core' ); ?> <span class="sp-hint"><?php esc_html_e( '(city and country)', 'secplus-core' ); ?></span></label>
				<input type="text" id="sp-location" name="sp_location" autocomplete="address-level2" maxlength="120" value="<?php echo esc_attr( $val( 'location' ) ); ?>">
			</div>
		</div>

		<div class="sp-field">
			<label for="sp-service"><?php esc_html_e( 'What support are you interested in?', 'secplus-core' ); ?> *</label>
			<?php echo $select( 'sp_service', 'service', $opts['services'], __( 'Select a service', 'secplus-core' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php echo $err( 'service' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>

		<div class="sp-field">
			<label for="sp-message"><?php esc_html_e( 'Tell us briefly what you need', 'secplus-core' ); ?> *</label>
			<textarea id="sp-message" name="sp_message" required maxlength="5000" placeholder="<?php esc_attr_e( 'Your company stage, what you need help with and any deadline.', 'secplus-core' ); ?>"<?php echo $aria( 'message' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php echo esc_textarea( $val( 'message' ) ); ?></textarea>
			<?php echo $err( 'message' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>

		<div class="sp-field">
			<label for="sp-contact_pref"><?php esc_html_e( 'Preferred contact method', 'secplus-core' ); ?></label>
			<select id="sp-contact_pref" name="sp_contact_pref">
				<?php foreach ( $opts['contact'] as $v => $label ) : ?>
					<option value="<?php echo esc_attr( $v ); ?>" <?php selected( $val( 'contact_pref' ), $v ); ?>><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="sp-field">
			<label class="sp-checkbox" for="sp-consent">
				<input type="checkbox" id="sp-consent" name="sp_consent" value="1" required <?php checked( ! empty( $old['consent'] ) ); ?><?php echo $aria( 'consent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
				<span>
					<?php
					printf(
						/* translators: %s: privacy policy link */
						esc_html__( 'I agree that SecPlus may use the information above to respond to my enquiry, as described in the %s. *', 'secplus-core' ),
						'<a href="' . esc_url( $privacy ) . '">' . esc_html__( 'Privacy Policy', 'secplus-core' ) . '</a>'
					);
					?>
				</span>
			</label>
			<?php echo $err( 'consent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>

		<button type="submit"><?php esc_html_e( 'Request a Consultation', 'secplus-core' ); ?></button>
		<p class="sp-form__privacy"><?php esc_html_e( 'Please do not include confidential identity or corporate documents in this form.', 'secplus-core' ); ?></p>
	</form>
	<?php
	return ob_get_clean();
}

/* ---------------------------------------------------------------------------
 * Admin: list columns, details box, status.
 * ------------------------------------------------------------------------- */

/**
 * List table columns.
 *
 * @param array $cols Columns.
 * @return array
 */
function secplus_core_enquiry_columns( $cols ) {
	return array(
		'cb'           => $cols['cb'],
		'title'        => __( 'Enquiry', 'secplus-core' ),
		'sp_email'     => __( 'Email', 'secplus-core' ),
		'sp_client'    => __( 'Client type', 'secplus-core' ),
		'sp_status'    => __( 'Status', 'secplus-core' ),
		'date'         => __( 'Received', 'secplus-core' ),
	);
}
add_filter( 'manage_secplus_enquiry_posts_columns', 'secplus_core_enquiry_columns' );

/**
 * Column output.
 *
 * @param string $col     Column.
 * @param int    $post_id Post.
 */
function secplus_core_enquiry_column_content( $col, $post_id ) {
	$opts = secplus_core_enquiry_options();
	switch ( $col ) {
		case 'sp_email':
			$email = get_post_meta( $post_id, '_sp_email', true );
			echo '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
			break;
		case 'sp_client':
			$type = get_post_meta( $post_id, '_sp_client_type', true );
			echo esc_html( $opts['client_types'][ $type ] ?? '—' );
			break;
		case 'sp_status':
			$status = get_post_meta( $post_id, '_sp_status', true );
			echo esc_html( $opts['statuses'][ $status ] ?? $opts['statuses']['new'] );
			break;
	}
}
add_action( 'manage_secplus_enquiry_posts_custom_column', 'secplus_core_enquiry_column_content', 10, 2 );

/**
 * Details meta box.
 */
function secplus_core_enquiry_meta_boxes() {
	add_meta_box( 'secplus-enquiry', __( 'Enquiry details', 'secplus-core' ), 'secplus_core_render_enquiry_box', 'secplus_enquiry', 'normal', 'high' );
	remove_meta_box( 'slugdiv', 'secplus_enquiry', 'normal' );
}
add_action( 'add_meta_boxes', 'secplus_core_enquiry_meta_boxes' );

/**
 * Renders enquiry details.
 *
 * @param WP_Post $post Post.
 */
function secplus_core_render_enquiry_box( $post ) {
	$opts = secplus_core_enquiry_options();
	$m    = function ( $k ) use ( $post ) {
		return (string) get_post_meta( $post->ID, '_sp_' . $k, true );
	};
	$rows = array(
		__( 'Email', 'secplus-core' )             => '<a href="mailto:' . esc_attr( $m( 'email' ) ) . '">' . esc_html( $m( 'email' ) ) . '</a>',
		__( 'Phone', 'secplus-core' )             => esc_html( $m( 'phone' ) ? $m( 'phone' ) : '—' ),
		__( 'Organization', 'secplus-core' )      => esc_html( $m( 'organization' ) ? $m( 'organization' ) : '—' ),
		__( 'Location', 'secplus-core' )          => esc_html( $m( 'location' ) ? $m( 'location' ) : '—' ),
		__( 'Client type', 'secplus-core' )       => esc_html( $opts['client_types'][ $m( 'client_type' ) ] ?? '—' ),
		__( 'Support required', 'secplus-core' )  => esc_html( $opts['services'][ $m( 'service' ) ] ?? '—' ),
		__( 'Preferred contact', 'secplus-core' ) => esc_html( $opts['contact'][ $m( 'contact_pref' ) ] ?? '—' ),
		__( 'Message', 'secplus-core' )           => nl2br( esc_html( $m( 'message' ) ) ),
		__( 'Consent recorded', 'secplus-core' )  => esc_html( $m( 'consent_at' ) ),
		__( 'Submitted from', 'secplus-core' )    => esc_html( $m( 'source' ) ),
	);
	wp_nonce_field( 'secplus_enquiry_status', 'secplus_enquiry_status_nonce' );
	echo '<table class="widefat striped"><tbody>';
	foreach ( $rows as $label => $value ) {
		echo '<tr><th style="width:180px">' . esc_html( $label ) . '</th><td>' . wp_kses_post( $value ) . '</td></tr>';
	}
	echo '<tr><th><label for="sp-status">' . esc_html__( 'Follow-up status', 'secplus-core' ) . '</label></th><td><select id="sp-status" name="sp_status">';
	foreach ( $opts['statuses'] as $v => $label ) {
		echo '<option value="' . esc_attr( $v ) . '"' . selected( $m( 'status' ), $v, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select> <span class="description">' . esc_html__( 'Click Update to save.', 'secplus-core' ) . '</span></td></tr>';
	echo '</tbody></table>';
}

/**
 * Saves follow-up status.
 *
 * @param int $post_id Post.
 */
function secplus_core_save_enquiry_status( $post_id ) {
	if ( ! isset( $_POST['secplus_enquiry_status_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['secplus_enquiry_status_nonce'] ), 'secplus_enquiry_status' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$status = isset( $_POST['sp_status'] ) ? sanitize_key( $_POST['sp_status'] ) : 'new';
	$opts   = secplus_core_enquiry_options();
	if ( isset( $opts['statuses'][ $status ] ) ) {
		update_post_meta( $post_id, '_sp_status', $status );
	}
}
add_action( 'save_post_secplus_enquiry', 'secplus_core_save_enquiry_status' );

/**
 * Keeps enquiries private when edited.
 *
 * @param array $data Post data.
 * @return array
 */
function secplus_core_force_private( $data ) {
	if ( 'secplus_enquiry' === $data['post_type'] && in_array( $data['post_status'], array( 'publish', 'future' ), true ) ) {
		$data['post_status'] = 'private';
	}
	return $data;
}
add_filter( 'wp_insert_post_data', 'secplus_core_force_private' );

/* ---------------------------------------------------------------------------
 * Privacy: personal data exporter and eraser (Tools → Export/Erase Personal Data).
 * ------------------------------------------------------------------------- */

/**
 * Finds enquiries for an email address.
 *
 * @param string $email Email.
 * @return int[]
 */
function secplus_core_enquiries_by_email( $email ) {
	return get_posts(
		array(
			'post_type'      => 'secplus_enquiry',
			'post_status'    => 'any',
			'fields'         => 'ids',
			'posts_per_page' => 200,
			'meta_key'       => '_sp_email', // phpcs:ignore WordPress.DB.SlowDBQuery
			'meta_value'     => $email, // phpcs:ignore WordPress.DB.SlowDBQuery
		)
	);
}

/**
 * Registers exporter.
 *
 * @param array $exporters Exporters.
 * @return array
 */
function secplus_core_register_exporter( $exporters ) {
	$exporters['secplus-enquiries'] = array(
		'exporter_friendly_name' => __( 'SecPlus website enquiries', 'secplus-core' ),
		'callback'               => function ( $email ) {
			$items = array();
			foreach ( secplus_core_enquiries_by_email( $email ) as $id ) {
				$data = array( array( 'name' => __( 'Submitted', 'secplus-core' ), 'value' => get_the_date( 'c', $id ) ) );
				foreach ( array( 'email', 'phone', 'organization', 'location', 'client_type', 'service', 'contact_pref', 'message', 'consent_at' ) as $k ) {
					$data[] = array( 'name' => $k, 'value' => (string) get_post_meta( $id, '_sp_' . $k, true ) );
				}
				$items[] = array( 'group_id' => 'secplus-enquiries', 'group_label' => __( 'Website enquiries', 'secplus-core' ), 'item_id' => 'enquiry-' . $id, 'data' => $data );
			}
			return array( 'data' => $items, 'done' => true );
		},
	);
	return $exporters;
}
add_filter( 'wp_privacy_personal_data_exporters', 'secplus_core_register_exporter' );

/**
 * Registers eraser.
 *
 * @param array $erasers Erasers.
 * @return array
 */
function secplus_core_register_eraser( $erasers ) {
	$erasers['secplus-enquiries'] = array(
		'eraser_friendly_name' => __( 'SecPlus website enquiries', 'secplus-core' ),
		'callback'             => function ( $email ) {
			$removed = false;
			foreach ( secplus_core_enquiries_by_email( $email ) as $id ) {
				$removed = (bool) wp_delete_post( $id, true ) || $removed;
			}
			return array( 'items_removed' => $removed, 'items_retained' => false, 'messages' => array(), 'done' => true );
		},
	);
	return $erasers;
}
add_filter( 'wp_privacy_personal_data_erasers', 'secplus_core_register_eraser' );
