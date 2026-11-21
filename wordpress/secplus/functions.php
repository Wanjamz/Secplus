<?php
/**
 * SecPlus Consulting block theme.
 *
 * @package SecPlus
 */

defined( 'ABSPATH' ) || exit;

define( 'SECPLUS_THEME_VERSION', '1.2.1' );

require_once get_theme_file_path( 'inc/icons.php' );
require_once get_theme_file_path( 'inc/helpers.php' );
require_once get_theme_file_path( 'inc/blocks.php' );

/**
 * Theme setup.
 */
function secplus_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_editor_style( array( 'style.css' ) );
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'after_setup_theme', 'secplus_setup' );

/**
 * Front-end stylesheet.
 */
function secplus_enqueue_assets() {
	wp_enqueue_style( 'secplus-style', get_stylesheet_uri(), array(), SECPLUS_THEME_VERSION );
	wp_enqueue_script(
		'secplus-motion',
		get_theme_file_uri( 'assets/js/motion.js' ),
		array(),
		SECPLUS_THEME_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'secplus_enqueue_assets' );

/**
 * Flags motion support before first paint. Elements are only hidden for an
 * entrance when this flag is present; if the motion script fails to run, the
 * flag is removed after 2.5s so content can never stay hidden.
 */
function secplus_motion_flag() {
	echo "<script>(function(d){var r=d.documentElement;if(window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches){return;}r.classList.add('sp-js');setTimeout(function(){if(!r.classList.contains('sp-motion-ready')){r.classList.remove('sp-js');}},2500);})(document);</script>\n";
}
add_action( 'wp_head', 'secplus_motion_flag', 0 );

/**
 * Preload the primary font file for faster first paint.
 */
function secplus_preload_font() {
	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
		esc_url( get_theme_file_uri( 'assets/fonts/manrope-latin-wght-normal.woff2' ) )
	);
}
add_action( 'wp_head', 'secplus_preload_font', 1 );

/**
 * Pattern categories.
 */
function secplus_register_pattern_categories() {
	$categories = array(
		'secplus-home'     => __( 'SecPlus: Homepage sections', 'secplus' ),
		'secplus-sections' => __( 'SecPlus: Page sections', 'secplus' ),
		'secplus-cta'      => __( 'SecPlus: Calls to action', 'secplus' ),
		'secplus-pages'    => __( 'SecPlus: Page starters', 'secplus' ),
	);
	foreach ( $categories as $slug => $label ) {
		register_block_pattern_category( $slug, array( 'label' => $label ) );
	}
}
add_action( 'init', 'secplus_register_pattern_categories' );

/**
 * Block styles that map to the SecPlus design system.
 */
function secplus_register_block_styles() {
	register_block_style( 'core/button', array( 'name' => 'navy', 'label' => __( 'Navy', 'secplus' ) ) );
	register_block_style( 'core/button', array( 'name' => 'ghost', 'label' => __( 'Ghost (on dark)', 'secplus' ) ) );
	register_block_style( 'core/button', array( 'name' => 'text', 'label' => __( 'Text link', 'secplus' ) ) );
	register_block_style( 'core/list', array( 'name' => 'checklist', 'label' => __( 'Checklist', 'secplus' ) ) );
	register_block_style( 'core/group', array( 'name' => 'card', 'label' => __( 'Card', 'secplus' ) ) );
	register_block_style( 'core/group', array( 'name' => 'panel-navy', 'label' => __( 'Navy panel', 'secplus' ) ) );
	register_block_style( 'core/image', array( 'name' => 'rounded-lg', 'label' => __( 'Large rounded', 'secplus' ) ) );
	register_block_style( 'core/paragraph', array( 'name' => 'eyebrow', 'label' => __( 'Eyebrow label', 'secplus' ) ) );
	register_block_style( 'core/paragraph', array( 'name' => 'lead', 'label' => __( 'Lead paragraph', 'secplus' ) ) );
	register_block_style( 'core/paragraph', array( 'name' => 'arrow-link', 'label' => __( 'Arrow link', 'secplus' ) ) );
}
add_action( 'init', 'secplus_register_block_styles' );

/**
 * Fall back to the bundled original logo when no Site Logo has been chosen yet.
 *
 * @param string $content Rendered block.
 * @param array  $block   Block data.
 * @return string
 */
function secplus_site_logo_fallback( $content, $block ) {
	if ( '' !== trim( $content ) ) {
		return $content;
	}
	$width = isset( $block['attrs']['width'] ) ? (int) $block['attrs']['width'] : 180;
	$class = isset( $block['attrs']['className'] ) ? ' ' . $block['attrs']['className'] : '';
	return sprintf(
		'<div class="wp-block-site-logo%1$s"><a href="%2$s" class="custom-logo-link" rel="home"><img src="%3$s" class="custom-logo" alt="%4$s" width="%5$d" height="%6$d" decoding="async"></a></div>',
		esc_attr( $class ),
		esc_url( home_url( '/' ) ),
		esc_url( get_theme_file_uri( 'assets/images/secplus-logo.png' ) ),
		esc_attr( get_bloginfo( 'name' ) ),
		$width,
		(int) round( $width * 90 / 250 )
	);
}
add_filter( 'render_block_core/site-logo', 'secplus_site_logo_fallback', 10, 2 );

/**
 * Loads the logo marquee script only on pages that contain a client logo strip.
 *
 * @param string $content Rendered block.
 * @param array  $block   Block data.
 * @return string
 */
function secplus_maybe_enqueue_marquee( $content, $block ) {
	if ( ! is_admin() && isset( $block['attrs']['className'] ) && false !== strpos( $block['attrs']['className'], 'sp-logo-marquee' ) ) {
		wp_enqueue_script(
			'secplus-logo-marquee',
			get_theme_file_uri( 'assets/js/logo-marquee.js' ),
			array(),
			SECPLUS_THEME_VERSION,
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}
	return $content;
}
add_filter( 'render_block_core/group', 'secplus_maybe_enqueue_marquee', 10, 2 );

/**
 * Body classes for page-level styling hooks.
 *
 * @param string[] $classes Classes.
 * @return string[]
 */
function secplus_body_class( $classes ) {
	// Site-wide style (SecPlus → Site settings → Site style). A page using one of the
	// editorial templates keeps that template's style whatever the site-wide choice.
	$opts  = get_option( 'secplus_settings', array() );
	$style = isset( $opts['site_style'] ) && in_array( $opts['site_style'], array( 'classic', 'editorial', 'editorial-sans' ), true ) ? $opts['site_style'] : 'editorial-sans';

	if ( is_page() ) {
		$classes[] = 'sp-page-' . sanitize_html_class( get_post_field( 'post_name', get_queried_object_id() ) );
		$template  = get_page_template_slug( get_queried_object_id() );
		if ( 'page-editorial-sans' === $template ) {
			$style = 'editorial-sans';
		} elseif ( 'page-editorial' === $template ) {
			$style = 'editorial';
		}
	}

	if ( 'classic' !== $style && ! in_array( 'page-template-page-editorial', $classes, true ) ) {
		$classes[] = 'page-template-page-editorial';
	}
	if ( 'editorial-sans' === $style ) {
		$classes[] = 'sp-sans-headings';
	}
	return array_unique( $classes );
}
add_filter( 'body_class', 'secplus_body_class' );

/**
 * Shorter excerpts in cards.
 *
 * @return int
 */
function secplus_excerpt_length() {
	return 26;
}
add_filter( 'excerpt_length', 'secplus_excerpt_length' );
