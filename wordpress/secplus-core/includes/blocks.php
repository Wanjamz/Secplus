<?php
/**
 * Plugin blocks: enquiry form and contact details (dynamic, editable settings-driven).
 *
 * @package SecPlusCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers blocks and the editor script.
 */
function secplus_core_register_blocks() {
	wp_register_script(
		'secplus-core-blocks',
		SECPLUS_CORE_URL . 'assets/blocks.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-server-side-render', 'wp-i18n' ),
		SECPLUS_CORE_VERSION,
		true
	);

	register_block_type(
		'secplus/enquiry-form',
		array(
			'api_version'           => 3,
			'title'                 => __( 'SecPlus Enquiry Form', 'secplus-core' ),
			'category'              => 'widgets',
			'editor_script_handles' => array( 'secplus-core-blocks' ),
			'supports'              => array( 'html' => false, 'multiple' => false ),
			'attributes'            => array( 'className' => array( 'type' => 'string' ) ),
			'render_callback'       => 'secplus_core_render_enquiry_form',
		)
	);

	register_block_type(
		'secplus/contact-details',
		array(
			'api_version'           => 3,
			'title'                 => __( 'SecPlus Contact Details', 'secplus-core' ),
			'category'              => 'widgets',
			'editor_script_handles' => array( 'secplus-core-blocks' ),
			'supports'              => array( 'html' => false ),
			'attributes'            => array(
				'layout'    => array( 'type' => 'string', 'default' => 'stack' ),
				'className' => array( 'type' => 'string' ),
			),
			'render_callback'       => 'secplus_core_render_contact_details',
		)
	);
}
add_action( 'init', 'secplus_core_register_blocks' );

/**
 * Icon helper that uses the theme icon set when available.
 *
 * @param string $name Icon name.
 * @return string
 */
function secplus_core_icon( $name ) {
	if ( function_exists( 'secplus_icon' ) ) {
		return '<span class="sp-icon sp-icon--tint sp-icon--sm">' . secplus_icon( $name ) . '</span>';
	}
	return '';
}

/**
 * Contact details block.
 *
 * @param array $attributes Attributes.
 * @return string
 */
function secplus_core_render_contact_details( $attributes ) {
	$layout = in_array( $attributes['layout'] ?? 'stack', array( 'stack', 'card', 'footer' ), true ) ? $attributes['layout'] : 'stack';
	$items  = array();

	$phone = secplus_core_get( 'phone' );
	if ( $phone ) {
		$items[] = array( 'phone', __( 'Telephone', 'secplus-core' ), $phone, 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ) );
	}
	$wa = preg_replace( '/[^0-9]/', '', secplus_core_get( 'whatsapp' ) );
	if ( $wa ) {
		$items[] = array( 'message', __( 'WhatsApp', 'secplus-core' ), '+' . $wa, 'https://wa.me/' . $wa );
	}
	$email = secplus_core_get( 'email' );
	if ( is_email( $email ) ) {
		$items[] = array( 'mail', __( 'Email', 'secplus-core' ), $email, 'mailto:' . $email );
	}
	$address = secplus_core_get( 'address' );
	if ( $address ) {
		$items[] = array( 'map-pin', __( 'Office', 'secplus-core' ), $address, secplus_core_get( 'map_url' ) );
	}
	$hours = secplus_core_get( 'hours' );
	if ( $hours && 'footer' !== $layout ) {
		$items[] = array( 'clock', __( 'Office hours', 'secplus-core' ), $hours, '' );
	}

	$is_editor = defined( 'REST_REQUEST' ) && REST_REQUEST && current_user_can( 'edit_posts' );

	if ( ! $items ) {
		if ( $is_editor ) {
			return '<div class="sp-pending"><strong>' . esc_html__( 'Pending Client Confirmation:', 'secplus-core' ) . '</strong> ' . esc_html__( 'add the verified phone, email and office address under SecPlus → Site settings. Until then, visitors are directed to the enquiry form.', 'secplus-core' ) . '</div>';
		}
		if ( 'footer' === $layout ) {
			return '';
		}
		$items[] = array( 'message', __( 'Enquire online', 'secplus-core' ), __( 'Send us your enquiry', 'secplus-core' ), home_url( '/contact/#enquiry' ) );
	}

	$html = '';
	foreach ( $items as $item ) {
		list( $icon, $label, $value, $href ) = $item;
		$value_html = nl2br( esc_html( $value ) );
		if ( $href ) {
			$ext        = 0 === strpos( $href, 'http' ) && false === strpos( $href, home_url() ) ? ' target="_blank" rel="noopener"' : '';
			$value_html = '<a class="sp-contact-item__value" href="' . esc_url( $href ) . '"' . $ext . '>' . $value_html . '</a>';
		} else {
			$value_html = '<span class="sp-contact-item__value">' . $value_html . '</span>';
		}
		$html .= '<div class="sp-contact-item">' . secplus_core_icon( $icon ) . '<div><span class="sp-contact-item__label">' . esc_html( $label ) . '</span>' . $value_html . '</div></div>';
	}

	$social = array();
	foreach ( array( 'linkedin' => 'LinkedIn', 'facebook' => 'Facebook', 'x' => 'X', 'instagram' => 'Instagram', 'youtube' => 'YouTube' ) as $key => $label ) {
		$url = secplus_core_get( $key );
		if ( $url ) {
			$social[] = '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener me">' . esc_html( $label ) . '</a>';
		}
	}
	if ( $social ) {
		$html .= '<div class="sp-contact-social" aria-label="' . esc_attr__( 'Social media', 'secplus-core' ) . '">' . implode( '', $social ) . '</div>';
	}

	$wrapper = get_block_wrapper_attributes( array( 'class' => 'sp-contact-details sp-contact-details--' . $layout ) );
	return '<div ' . $wrapper . '>' . $html . '</div>';
}
