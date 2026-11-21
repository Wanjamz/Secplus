<?php
/**
 * SecPlus site settings (contact details, enquiry routing, social profiles).
 *
 * @package SecPlusCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Settings fields definition.
 *
 * @return array<string, array<string,string>>
 */
function secplus_core_setting_fields() {
	return array(
		'legal_name'        => array( 'label' => __( 'Registered business name', 'secplus-core' ), 'type' => 'text', 'section' => 'business', 'help' => __( 'Official legal name as registered, used in structured data and the privacy policy.', 'secplus-core' ) ),
		'site_style'        => array( 'label' => __( 'Site style', 'secplus-core' ), 'type' => 'select', 'section' => 'business', 'choices' => array( 'editorial-sans' => __( 'Editorial: full-bleed photo heroes, bold sans headlines (default)', 'secplus-core' ), 'editorial' => __( 'Editorial: full-bleed photo heroes, serif headlines', 'secplus-core' ), 'classic' => __( 'Classic: light heroes with photo and card', 'secplus-core' ) ), 'help' => __( 'Applies to every page. A page set to one of the "Editorial landing" templates keeps that style.', 'secplus-core' ) ),
		'phone'             => array( 'label' => __( 'Main telephone', 'secplus-core' ), 'type' => 'tel', 'section' => 'contact', 'help' => __( 'International format, e.g. +254 7XX XXX XXX.', 'secplus-core' ) ),
		'whatsapp'          => array( 'label' => __( 'WhatsApp number', 'secplus-core' ), 'type' => 'tel', 'section' => 'contact', 'help' => __( 'With country code, e.g. 2547XXXXXXXX. Used for the chat assistant hand-over and shown with the contact details. Leave blank to hide (the chat then hands over to the enquiry form).', 'secplus-core' ) ),
		'email'             => array( 'label' => __( 'Public enquiries email', 'secplus-core' ), 'type' => 'email', 'section' => 'contact', 'help' => '' ),
		'address'           => array( 'label' => __( 'Office address', 'secplus-core' ), 'type' => 'textarea', 'section' => 'contact', 'help' => __( 'Verified Nairobi office address. One line per row.', 'secplus-core' ) ),
		'map_url'           => array( 'label' => __( 'Map link (optional)', 'secplus-core' ), 'type' => 'url', 'section' => 'contact', 'help' => '' ),
		'hours'             => array( 'label' => __( 'Office hours (optional)', 'secplus-core' ), 'type' => 'text', 'section' => 'contact', 'help' => __( 'e.g. Monday to Friday, 8:00am to 5:00pm (EAT).', 'secplus-core' ) ),
		'enquiry_recipient' => array( 'label' => __( 'Send enquiry notifications to', 'secplus-core' ), 'type' => 'email', 'section' => 'enquiries', 'help' => __( 'Defaults to the site administration email if blank.', 'secplus-core' ) ),
		'response_time'     => array( 'label' => __( 'Response standard shown after enquiry (optional)', 'secplus-core' ), 'type' => 'text', 'section' => 'enquiries', 'help' => __( 'Only add once confirmed, e.g. "We aim to respond within one working day."', 'secplus-core' ) ),
		'chat_enabled'      => array( 'label' => __( 'Show the chat assistant', 'secplus-core' ), 'type' => 'checkbox', 'section' => 'chat', 'help' => __( 'A WhatsApp-style chat bubble on every page that answers common questions and hands over to an adviser on WhatsApp. Edit the answers under SecPlus → Chat answers.', 'secplus-core' ) ),
		'chat_name'         => array( 'label' => __( 'Chat display name', 'secplus-core' ), 'type' => 'text', 'section' => 'chat', 'help' => __( 'Shown at the top of the chat. Defaults to "SecPlus".', 'secplus-core' ) ),
		'linkedin'          => array( 'label' => 'LinkedIn', 'type' => 'url', 'section' => 'social', 'help' => '' ),
		'facebook'          => array( 'label' => 'Facebook', 'type' => 'url', 'section' => 'social', 'help' => '' ),
		'x'                 => array( 'label' => 'X (Twitter)', 'type' => 'url', 'section' => 'social', 'help' => '' ),
		'instagram'         => array( 'label' => 'Instagram', 'type' => 'url', 'section' => 'social', 'help' => '' ),
		'youtube'           => array( 'label' => 'YouTube', 'type' => 'url', 'section' => 'social', 'help' => '' ),
	);
}

/**
 * Gets a setting value.
 *
 * @param string $key Setting key.
 * @return string
 */
function secplus_core_get( $key ) {
	$opts = get_option( 'secplus_settings', array() );
	return isset( $opts[ $key ] ) ? (string) $opts[ $key ] : '';
}

/**
 * Registers the option.
 */
function secplus_core_register_settings() {
	register_setting(
		'secplus_settings_group',
		'secplus_settings',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'secplus_core_sanitize_settings',
			'default'           => array(),
		)
	);
}
add_action( 'admin_init', 'secplus_core_register_settings' );

/**
 * Sanitizes settings.
 *
 * @param mixed $input Raw input.
 * @return array
 */
function secplus_core_sanitize_settings( $input ) {
	$out = array();
	if ( ! is_array( $input ) ) {
		return $out;
	}
	foreach ( secplus_core_setting_fields() as $key => $field ) {
		$value = isset( $input[ $key ] ) ? wp_unslash( $input[ $key ] ) : '';
		switch ( $field['type'] ) {
			case 'email':
				$out[ $key ] = sanitize_email( $value );
				break;
			case 'url':
				$out[ $key ] = esc_url_raw( $value );
				break;
			case 'textarea':
				$out[ $key ] = sanitize_textarea_field( $value );
				break;
			case 'select':
				$out[ $key ] = isset( $field['choices'][ $value ] ) ? $value : (string) array_key_first( $field['choices'] );
				break;
			case 'checkbox':
				$out[ $key ] = empty( $value ) ? '0' : '1';
				break;
			case 'tel':
				$out[ $key ] = preg_replace( '/[^0-9+\s()-]/', '', sanitize_text_field( $value ) );
				break;
			default:
				$out[ $key ] = sanitize_text_field( $value );
		}
	}
	return $out;
}

/**
 * Adds the settings sub-page.
 */
function secplus_core_settings_menu() {
	add_submenu_page( 'secplus', __( 'Site settings', 'secplus-core' ), __( 'Site settings', 'secplus-core' ), 'manage_options', 'secplus-settings', 'secplus_core_render_settings_page' );
}
add_action( 'admin_menu', 'secplus_core_settings_menu', 20 );

/**
 * Renders the settings page.
 */
function secplus_core_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$sections = array(
		'business'  => __( 'Business', 'secplus-core' ),
		'contact'   => __( 'Contact details', 'secplus-core' ),
		'enquiries' => __( 'Enquiries', 'secplus-core' ),
		'chat'      => __( 'Chat assistant', 'secplus-core' ),
		'social'    => __( 'Social profiles (verified accounts only)', 'secplus-core' ),
	);
	$opts     = get_option( 'secplus_settings', array() );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'SecPlus site settings', 'secplus-core' ); ?></h1>
		<p><?php esc_html_e( 'These details appear in the website header, footer, Contact and About pages and in search-engine structured data. Leave a field blank until the information has been confirmed: blank fields are hidden on the website and listed on the Launch checklist as Pending Client Confirmation.', 'secplus-core' ); ?></p>
		<form method="post" action="options.php">
			<?php settings_fields( 'secplus_settings_group' ); ?>
			<?php foreach ( $sections as $section => $title ) : ?>
				<h2 class="title"><?php echo esc_html( $title ); ?></h2>
				<table class="form-table" role="presentation">
					<?php
					foreach ( secplus_core_setting_fields() as $key => $field ) :
						if ( $field['section'] !== $section ) {
							continue;
						}
						$id    = 'secplus_' . $key;
						$value = $opts[ $key ] ?? '';
						?>
						<tr>
							<th scope="row"><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $field['label'] ); ?></label></th>
							<td>
								<?php if ( 'select' === $field['type'] ) : ?>
									<select id="<?php echo esc_attr( $id ); ?>" name="secplus_settings[<?php echo esc_attr( $key ); ?>]">
										<?php foreach ( $field['choices'] as $choice => $choice_label ) : ?>
											<option value="<?php echo esc_attr( $choice ); ?>" <?php selected( $value ? $value : 'editorial-sans', $choice ); ?>><?php echo esc_html( $choice_label ); ?></option>
										<?php endforeach; ?>
									</select>
								<?php elseif ( 'checkbox' === $field['type'] ) : ?>
									<input type="hidden" name="secplus_settings[<?php echo esc_attr( $key ); ?>]" value="0">
									<label><input id="<?php echo esc_attr( $id ); ?>" type="checkbox" name="secplus_settings[<?php echo esc_attr( $key ); ?>]" value="1" <?php checked( '0' !== $value ); ?>> <?php esc_html_e( 'Enabled', 'secplus-core' ); ?></label>
								<?php elseif ( 'textarea' === $field['type'] ) : ?>
									<textarea id="<?php echo esc_attr( $id ); ?>" name="secplus_settings[<?php echo esc_attr( $key ); ?>]" rows="3" class="large-text"><?php echo esc_textarea( $value ); ?></textarea>
								<?php else : ?>
									<input id="<?php echo esc_attr( $id ); ?>" type="<?php echo esc_attr( $field['type'] ); ?>" name="secplus_settings[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $value ); ?>" class="regular-text">
								<?php endif; ?>
								<?php if ( $field['help'] ) : ?>
									<p class="description"><?php echo esc_html( $field['help'] ); ?></p>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
			<?php endforeach; ?>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
