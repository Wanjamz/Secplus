<?php
/**
 * Lightweight SEO foundations: per-page title and meta description, Open Graph,
 * structured data and editorial review metadata. Automatically steps aside when
 * a dedicated SEO plugin is active.
 *
 * @package SecPlusCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether a dedicated SEO plugin is handling head output.
 *
 * @return bool
 */
function secplus_core_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) || class_exists( 'The_SEO_Framework\Load' );
}

/**
 * Registers post meta used by the editor panel.
 */
function secplus_core_register_meta() {
	$auth = function () {
		return current_user_can( 'edit_posts' );
	};
	foreach ( array( 'post', 'page' ) as $type ) {
		foreach ( array( 'secplus_seo_title', 'secplus_meta_description' ) as $key ) {
			register_post_meta( $type, $key, array( 'type' => 'string', 'single' => true, 'show_in_rest' => true, 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'auth_callback' => $auth ) );
		}
	}
	foreach ( array( 'secplus_reviewer', 'secplus_last_reviewed', 'secplus_related_service' ) as $key ) {
		register_post_meta( 'post', $key, array( 'type' => 'string', 'single' => true, 'show_in_rest' => true, 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'auth_callback' => $auth ) );
	}
}
add_action( 'init', 'secplus_core_register_meta' );

/**
 * Editor sidebar panel.
 */
function secplus_core_editor_assets() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || ! in_array( $screen->post_type, array( 'post', 'page' ), true ) ) {
		return;
	}
	wp_enqueue_script(
		'secplus-core-editor',
		SECPLUS_CORE_URL . 'assets/editor.js',
		array( 'wp-plugins', 'wp-editor', 'wp-element', 'wp-components', 'wp-data', 'wp-i18n', 'wp-core-data' ),
		SECPLUS_CORE_VERSION,
		true
	);
	$services = array( array( 'value' => '', 'label' => __( 'Automatic (from category)', 'secplus-core' ) ) );
	foreach ( secplus_core_enquiry_options()['services'] as $slug => $label ) {
		if ( 'not-sure' !== $slug ) {
			$services[] = array( 'value' => $slug, 'label' => $label );
		}
	}
	wp_add_inline_script( 'secplus-core-editor', 'window.secplusServices = ' . wp_json_encode( $services ) . ';', 'before' );
}
add_action( 'enqueue_block_editor_assets', 'secplus_core_editor_assets' );

/**
 * Custom SEO title.
 *
 * @param array $parts Title parts.
 * @return array
 */
function secplus_core_title_parts( $parts ) {
	if ( secplus_core_seo_plugin_active() || ! is_singular() ) {
		return $parts;
	}
	$custom = get_post_meta( get_queried_object_id(), 'secplus_seo_title', true );
	if ( $custom ) {
		$parts['title'] = $custom;
	}
	return $parts;
}
add_filter( 'document_title_parts', 'secplus_core_title_parts' );

/**
 * Returns the description for the current request.
 *
 * @return string
 */
function secplus_core_current_description() {
	$desc = '';
	if ( is_singular() ) {
		$id   = get_queried_object_id();
		$desc = get_post_meta( $id, 'secplus_meta_description', true );
		if ( ! $desc && has_excerpt( $id ) ) {
			$desc = get_the_excerpt( $id );
		}
	} elseif ( is_category() ) {
		$desc = term_description();
	}
	if ( ! $desc ) {
		$desc = get_bloginfo( 'description' );
	}
	return trim( wp_strip_all_tags( $desc ) );
}

/**
 * Logo URL for structured data.
 *
 * @return string
 */
function secplus_core_logo_url() {
	$logo_id = (int) get_option( 'site_logo' );
	if ( $logo_id ) {
		$src = wp_get_attachment_image_url( $logo_id, 'full' );
		if ( $src ) {
			return $src;
		}
	}
	return function_exists( 'get_theme_file_uri' ) ? get_theme_file_uri( 'assets/images/secplus-logo.png' ) : '';
}

/**
 * Head output: description, Open Graph and JSON-LD.
 */
function secplus_core_head() {
	if ( secplus_core_seo_plugin_active() || is_404() ) {
		return;
	}
	$desc  = secplus_core_current_description();
	$title = wp_get_document_title();
	$url   = is_singular() ? get_permalink() : home_url( add_query_arg( array() ) );
	$site  = get_bloginfo( 'name' );

	if ( $desc ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	}
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( $site ) );
	printf( '<meta property="og:type" content="%s">' . "\n", is_singular( 'post' ) ? 'article' : 'website' );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	if ( $desc ) {
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
	}
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	printf( '<meta property="og:locale" content="%s">' . "\n", esc_attr( get_locale() ) );
	$image = is_singular() && has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'large' ) : secplus_core_logo_url();
	if ( $image ) {
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";

	// Structured data.
	$org_id = home_url( '/#organization' );
	$org    = array(
		'@type'       => 'ProfessionalService',
		'@id'         => $org_id,
		'name'        => secplus_core_get( 'legal_name' ) ? secplus_core_get( 'legal_name' ) : $site,
		'url'         => home_url( '/' ),
		'logo'        => secplus_core_logo_url(),
		'image'       => secplus_core_logo_url(),
		'description' => 'Corporate secretarial, compliance and governance services for Kenyan and international businesses.',
		'areaServed'  => array( '@type' => 'Country', 'name' => 'Kenya' ),
		'knowsAbout'  => array( 'Company registration', 'Corporate compliance', 'Company secretarial services', 'Corporate governance', 'Corporate restructuring' ),
	);
	if ( secplus_core_get( 'phone' ) ) {
		$org['telephone'] = secplus_core_get( 'phone' );
	}
	if ( is_email( secplus_core_get( 'email' ) ) ) {
		$org['email'] = secplus_core_get( 'email' );
	}
	if ( secplus_core_get( 'address' ) ) {
		$org['address'] = array(
			'@type'          => 'PostalAddress',
			'streetAddress'  => preg_replace( '/\s*\n\s*/', ', ', secplus_core_get( 'address' ) ),
			'addressCountry' => 'KE',
		);
	}
	$same = array();
	foreach ( array( 'linkedin', 'facebook', 'x', 'instagram', 'youtube' ) as $k ) {
		if ( secplus_core_get( $k ) ) {
			$same[] = secplus_core_get( $k );
		}
	}
	if ( $same ) {
		$org['sameAs'] = $same;
	}

	$graph = array(
		$org,
		array(
			'@type'     => 'WebSite',
			'@id'       => home_url( '/#website' ),
			'url'       => home_url( '/' ),
			'name'      => $site,
			'publisher' => array( '@id' => $org_id ),
		),
	);

	if ( is_singular() && ! is_front_page() ) {
		$post  = get_queried_object();
		$crumb = array( array( 'Home', home_url( '/' ) ) );
		if ( 'post' === $post->post_type ) {
			$hub = get_page_by_path( 'insights' );
			if ( $hub ) {
				$crumb[] = array( get_the_title( $hub ), get_permalink( $hub ) );
			}
		} else {
			foreach ( array_reverse( get_post_ancestors( $post ) ) as $anc ) {
				$crumb[] = array( get_the_title( $anc ), get_permalink( $anc ) );
			}
		}
		$crumb[] = array( get_the_title( $post ), get_permalink( $post ) );
		$items   = array();
		foreach ( $crumb as $i => $c ) {
			$items[] = array( '@type' => 'ListItem', 'position' => $i + 1, 'name' => wp_strip_all_tags( $c[0] ), 'item' => $c[1] );
		}
		$graph[] = array( '@type' => 'BreadcrumbList', 'itemListElement' => $items );

		if ( 'post' === $post->post_type ) {
			$article = array(
				'@type'            => 'Article',
				'headline'         => wp_strip_all_tags( get_the_title( $post ) ),
				'description'      => $desc,
				'datePublished'    => get_the_date( 'c', $post ),
				'dateModified'     => get_the_modified_date( 'c', $post ),
				'author'           => array( '@id' => $org_id ),
				'publisher'        => array( '@id' => $org_id ),
				'mainEntityOfPage' => array( '@type' => 'WebPage', '@id' => get_permalink( $post ) ),
				'inLanguage'       => get_bloginfo( 'language' ),
			);
			$reviewed = get_post_meta( $post->ID, 'secplus_last_reviewed', true );
			if ( $reviewed ) {
				$article['mainEntityOfPage']['lastReviewed'] = $reviewed;
			}
			$reviewer = get_post_meta( $post->ID, 'secplus_reviewer', true );
			if ( $reviewer ) {
				$article['mainEntityOfPage']['reviewedBy'] = array( '@type' => 'Person', 'name' => $reviewer );
			}
			$graph[] = $article;
		}
	}

	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'secplus_core_head', 5 );
