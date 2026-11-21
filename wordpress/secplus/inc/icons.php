<?php
/**
 * Line icon set used by the SecPlus theme (24×24, stroke = currentColor).
 *
 * @package SecPlus
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns the icon library: slug => [ label, inner SVG markup ].
 *
 * @return array<string, array{0:string,1:string}>
 */
function secplus_icon_library() {
	return array(
		'building'     => array( __( 'Building / company', 'secplus' ), '<path d="M4 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16"/><path d="M16 9h2a2 2 0 0 1 2 2v10"/><path d="M3 21h18"/><path d="M8 7h4M8 11h4M8 15h4"/>' ),
		'file-check'   => array( __( 'Document with check', 'secplus' ), '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="m9 14 2 2 4-4"/>' ),
		'shield-check' => array( __( 'Shield / compliance', 'secplus' ), '<path d="M12 3 5 6v5c0 4.5 3 8.3 7 10 4-1.7 7-5.5 7-10V6z"/><path d="m9 12 2 2 4-4"/>' ),
		'landmark'     => array( __( 'Institution / governance', 'secplus' ), '<path d="M3 21h18"/><path d="M5 21V10M9.5 21V10M14.5 21V10M19 21V10"/><path d="m12 3 9 5H3z"/>' ),
		'briefcase'    => array( __( 'Briefcase', 'secplus' ), '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/><path d="M3 13h18"/>' ),
		'restructure'  => array( __( 'Restructuring arrows', 'secplus' ), '<path d="M16 3h5v5"/><path d="M4 20 21 3"/><path d="M21 16v5h-5"/><path d="m15 15 6 6"/><path d="m4 4 5 5"/>' ),
		'users'        => array( __( 'People', 'secplus' ), '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/><path d="M16 4.5a3.5 3.5 0 0 1 0 7"/><path d="M18 14.2a6.5 6.5 0 0 1 3.5 5.8"/>' ),
		'user-check'   => array( __( 'Person with check', 'secplus' ), '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/><path d="m16 11 2 2 4-4"/>' ),
		'globe'        => array( __( 'Globe', 'secplus' ), '<circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/>' ),
		'handshake'    => array( __( 'Partnership', 'secplus' ), '<path d="m3 11 4-4 3 1 3-2 3 1 5 5-3 3"/><path d="m3 11 5 5"/><path d="m7 15 2 2a1.4 1.4 0 0 0 2-2l-1-1"/><path d="m11 17 2 2a1.4 1.4 0 0 0 2-2"/><path d="m14 14 2.5 2.5a1.4 1.4 0 0 0 2-2L15 11"/>' ),
		'clipboard'    => array( __( 'Checklist', 'secplus' ), '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1"/><path d="M9 11h6M9 15h4"/>' ),
		'calendar'     => array( __( 'Calendar', 'secplus' ), '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>' ),
		'compass'      => array( __( 'Compass / guidance', 'secplus' ), '<circle cx="12" cy="12" r="9"/><path d="m15.5 8.5-2 5-5 2 2-5z"/>' ),
		'message'      => array( __( 'Conversation', 'secplus' ), '<path d="M21 12a8 8 0 0 1-11.6 7.1L4 20l1-4.6A8 8 0 1 1 21 12z"/>' ),
		'mail'         => array( __( 'Email', 'secplus' ), '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>' ),
		'phone'        => array( __( 'Phone', 'secplus' ), '<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/>' ),
		'map-pin'      => array( __( 'Location', 'secplus' ), '<path d="M12 21s-7-6.2-7-12a7 7 0 0 1 14 0c0 5.8-7 12-7 12z"/><circle cx="12" cy="9" r="2.5"/>' ),
		'lock'         => array( __( 'Confidentiality', 'secplus' ), '<rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/>' ),
		'check'        => array( __( 'Check', 'secplus' ), '<path d="m5 12 5 5 9-10"/>' ),
		'arrow-right'  => array( __( 'Arrow', 'secplus' ), '<path d="M5 12h14M13 6l6 6-6 6"/>' ),
		'book'         => array( __( 'Guide / book', 'secplus' ), '<path d="M3 5a2 2 0 0 1 2-2h5a2 2 0 0 1 2 2v16a2 2 0 0 0-2-2H3z"/><path d="M21 5a2 2 0 0 0-2-2h-5a2 2 0 0 0-2 2v16a2 2 0 0 1 2-2h7z"/>' ),
		'layers'       => array( __( 'Layers / structure', 'secplus' ), '<path d="m12 3 9 5-9 5-9-5z"/><path d="m3 13 9 5 9-5"/>' ),
		'target'       => array( __( 'Target / purpose', 'secplus' ), '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/>' ),
		'scale'        => array( __( 'Balance / integrity', 'secplus' ), '<path d="M12 3v18M7 21h10"/><path d="M5 7h14"/><path d="m5 7-3 7a3 3 0 0 0 6 0z"/><path d="m19 7-3 7a3 3 0 0 0 6 0z"/>' ),
		'coins'        => array( __( 'Share capital', 'secplus' ), '<ellipse cx="9" cy="7" rx="6" ry="3"/><path d="M3 7v5c0 1.7 2.7 3 6 3s6-1.3 6-3V7"/><path d="M9 15v3c0 1.7 2.7 3 6 3s6-1.3 6-3v-5c0-1.7-2.7-3-6-3"/>' ),
		'search'       => array( __( 'Search / review', 'secplus' ), '<circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>' ),
		'clock'        => array( __( 'Time', 'secplus' ), '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>' ),
		'refresh'      => array( __( 'Ongoing support', 'secplus' ), '<path d="M20 11a8 8 0 0 0-14.9-3M4 13a8 8 0 0 0 14.9 3"/><path d="M4 4v4h4M20 20v-4h-4"/>' ),
		'award'        => array( __( 'Credential', 'secplus' ), '<circle cx="12" cy="9" r="6"/><path d="m8.5 14-1.5 7 5-2.5 5 2.5-1.5-7"/>' ),
		'presentation' => array( __( 'Board meeting', 'secplus' ), '<path d="M3 4h18"/><path d="M4 4v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4"/><path d="m8 21 4-5 4 5"/>' ),
		'register'     => array( __( 'Register / records', 'secplus' ), '<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="11" r="2.5"/><path d="M5.5 17a3.5 3.5 0 0 1 7 0"/><path d="M15 10h3M15 14h3"/>' ),
		'pen'          => array( __( 'Resolutions / signing', 'secplus' ), '<path d="M4 20h4L19 9a2.8 2.8 0 0 0-4-4L4 16z"/><path d="m13.5 6.5 4 4"/>' ),
		'office'       => array( __( 'Registered office', 'secplus' ), '<path d="m3 11 9-7 9 7"/><path d="M5 10v10h14V10"/><path d="M10 20v-5h4v5"/>' ),
		'training'     => array( __( 'Training', 'secplus' ), '<path d="m2 9 10-5 10 5-10 5z"/><path d="M6 11v5c0 1.5 2.7 3 6 3s6-1.5 6-3v-5"/>' ),
		'chart'        => array( __( 'Growth', 'secplus' ), '<path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/>' ),
		'flag'         => array( __( 'Milestone', 'secplus' ), '<path d="M5 21V4"/><path d="M5 4h11l-2 4 2 4H5"/>' ),
		'plus'         => array( __( 'Plus', 'secplus' ), '<path d="M12 5v14M5 12h14"/>' ),
	);
}

/**
 * Returns an inline SVG icon.
 *
 * @param string $name  Icon slug.
 * @param string $class Extra CSS class.
 * @return string
 */
function secplus_icon( $name, $class = '' ) {
	$icons = secplus_icon_library();
	if ( ! isset( $icons[ $name ] ) ) {
		$name = 'check';
	}
	return sprintf(
		'<svg class="sp-svg %1$s" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">%2$s</svg>',
		esc_attr( $class ),
		$icons[ $name ][1] // phpcs:ignore WordPress.Security.EscapeOutput -- static markup.
	);
}
