<?php
/**
 * Site-wide behaviour: comments off (not used on this site) and small performance tidy-ups.
 *
 * @package SecPlusCore
 */

defined( 'ABSPATH' ) || exit;

// Comments are not used: close them everywhere and hide the UI.
add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );
add_filter( 'comments_array', '__return_empty_array', 10 );

/**
 * Removes comment support from content types and the admin menu.
 */
function secplus_core_disable_comments() {
	foreach ( array( 'post', 'page', 'attachment' ) as $type ) {
		remove_post_type_support( $type, 'comments' );
		remove_post_type_support( $type, 'trackbacks' );
	}
}
add_action( 'init', 'secplus_core_disable_comments', 100 );

add_action(
	'admin_menu',
	function () {
		remove_menu_page( 'edit-comments.php' );
	}
);

add_action(
	'wp_before_admin_bar_render',
	function () {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'comments' );
	}
);

// Emoji detection script is unnecessary for this site.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/**
 * Keeps enquiry and preview query strings out of search indexes.
 */
function secplus_core_noindex_states() {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['enquiry'] ) || isset( $_GET['ek'] ) ) {
		echo '<meta name="robots" content="noindex, nofollow">' . "\n";
	}
}
add_action( 'wp_head', 'secplus_core_noindex_states', 1 );
