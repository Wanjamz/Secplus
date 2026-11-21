<?php
/**
 * Lightweight dynamic blocks bundled with the theme (no build step required).
 *
 * @package SecPlus
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the editor script and the dynamic blocks.
 */
function secplus_register_theme_blocks() {
	wp_register_script(
		'secplus-theme-blocks',
		get_theme_file_uri( 'assets/js/blocks.js' ),
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-server-side-render', 'wp-i18n' ),
		SECPLUS_THEME_VERSION,
		true
	);

	$icons = array();
	foreach ( secplus_icon_library() as $slug => $icon ) {
		$icons[] = array(
			'value' => $slug,
			'label' => $icon[0],
		);
	}
	wp_add_inline_script( 'secplus-theme-blocks', 'window.secplusIcons = ' . wp_json_encode( $icons ) . ';', 'before' );

	$common = array(
		'api_version'          => 3,
		'category'             => 'design',
		'editor_script_handles' => array( 'secplus-theme-blocks' ),
		'supports'             => array(
			'html'      => false,
			'className' => true,
		),
	);

	register_block_type(
		'secplus/icon',
		array_merge(
			$common,
			array(
				'title'           => __( 'SecPlus Icon', 'secplus' ),
				'attributes'      => array(
					'icon'    => array( 'type' => 'string', 'default' => 'check' ),
					'variant' => array( 'type' => 'string', 'default' => 'tint' ),
					'size'    => array( 'type' => 'string', 'default' => 'md' ),
					'className' => array( 'type' => 'string' ),
				),
				'render_callback' => 'secplus_render_icon_block',
			)
		)
	);

	register_block_type(
		'secplus/breadcrumbs',
		array_merge(
			$common,
			array(
				'title'           => __( 'SecPlus Breadcrumbs', 'secplus' ),
				'attributes'      => array( 'className' => array( 'type' => 'string' ) ),
				'uses_context'    => array( 'postId', 'postType' ),
				'render_callback' => 'secplus_render_breadcrumbs_block',
			)
		)
	);

	register_block_type(
		'secplus/copyright',
		array_merge(
			$common,
			array(
				'title'           => __( 'SecPlus Copyright', 'secplus' ),
				'attributes'      => array( 'className' => array( 'type' => 'string' ) ),
				'render_callback' => 'secplus_render_copyright_block',
			)
		)
	);

	register_block_type(
		'secplus/article-meta',
		array_merge(
			$common,
			array(
				'title'           => __( 'SecPlus Article Meta', 'secplus' ),
				'attributes'      => array( 'className' => array( 'type' => 'string' ) ),
				'uses_context'    => array( 'postId', 'postType' ),
				'render_callback' => 'secplus_render_article_meta_block',
			)
		)
	);

	register_block_type(
		'secplus/related-posts',
		array_merge(
			$common,
			array(
				'title'           => __( 'SecPlus Related Insights', 'secplus' ),
				'attributes'      => array(
					'count'     => array( 'type' => 'number', 'default' => 3 ),
					'className' => array( 'type' => 'string' ),
				),
				'uses_context'    => array( 'postId', 'postType' ),
				'render_callback' => 'secplus_render_related_posts_block',
			)
		)
	);

	register_block_type(
		'secplus/guide-links',
		array_merge(
			$common,
			array(
				'title'           => __( 'SecPlus Guide Links', 'secplus' ),
				'attributes'      => array(
					'slugs'     => array( 'type' => 'array', 'default' => array(), 'items' => array( 'type' => 'string' ) ),
					'title'     => array( 'type' => 'string', 'default' => 'Related guides' ),
					'className' => array( 'type' => 'string' ),
				),
				'render_callback' => 'secplus_render_guide_links_block',
			)
		)
	);

	register_block_type(
		'secplus/topic-cards',
		array_merge(
			$common,
			array(
				'title'           => __( 'SecPlus Insight Topics', 'secplus' ),
				'attributes'      => array( 'className' => array( 'type' => 'string' ) ),
				'render_callback' => 'secplus_render_topic_cards_block',
			)
		)
	);

	register_block_type(
		'secplus/related-service',
		array_merge(
			$common,
			array(
				'title'           => __( 'SecPlus Related Service', 'secplus' ),
				'attributes'      => array( 'className' => array( 'type' => 'string' ) ),
				'uses_context'    => array( 'postId', 'postType' ),
				'render_callback' => 'secplus_render_related_service_block',
			)
		)
	);
}
add_action( 'init', 'secplus_register_theme_blocks' );

/**
 * Icon block.
 *
 * @param array $attributes Block attributes.
 * @return string
 */
function secplus_render_icon_block( $attributes ) {
	$variant = in_array( $attributes['variant'] ?? 'tint', array( 'tint', 'solid', 'dark', 'plain' ), true ) ? $attributes['variant'] : 'tint';
	$size    = in_array( $attributes['size'] ?? 'md', array( 'sm', 'md', 'lg' ), true ) ? $attributes['size'] : 'md';
	$wrapper = get_block_wrapper_attributes( array( 'class' => "sp-icon sp-icon--{$variant} sp-icon--{$size}" ) );
	return sprintf( '<div %1$s>%2$s</div>', $wrapper, secplus_icon( sanitize_key( $attributes['icon'] ?? 'check' ) ) );
}

/**
 * Returns the breadcrumb trail for the current view.
 *
 * @param int|null $post_id Optional post ID.
 * @return array<int, array{0:string,1:string}> List of [ label, url ] (url empty for current item).
 */
function secplus_breadcrumb_trail( $post_id = null ) {
	$trail = array( array( __( 'Home', 'secplus' ), home_url( '/' ) ) );

	if ( is_search() ) {
		$trail[] = array( __( 'Search results', 'secplus' ), '' );
		return $trail;
	}
	if ( is_404() ) {
		$trail[] = array( __( 'Page not found', 'secplus' ), '' );
		return $trail;
	}

	$insights = get_page_by_path( 'insights' );

	if ( is_category() || is_tag() || is_archive() ) {
		if ( $insights ) {
			$trail[] = array( get_the_title( $insights ), get_permalink( $insights ) );
		}
		$trail[] = array( wp_strip_all_tags( get_the_archive_title() ), '' );
		return $trail;
	}

	$post_id = $post_id ? $post_id : get_queried_object_id();
	$post    = get_post( $post_id );
	if ( ! $post ) {
		return $trail;
	}

	if ( 'post' === $post->post_type ) {
		if ( $insights ) {
			$trail[] = array( get_the_title( $insights ), get_permalink( $insights ) );
		}
		$cats = get_the_category( $post->ID );
		if ( $cats ) {
			$trail[] = array( $cats[0]->name, get_category_link( $cats[0] ) );
		}
	} elseif ( 'page' === $post->post_type ) {
		foreach ( array_reverse( get_post_ancestors( $post ) ) as $ancestor ) {
			$trail[] = array( get_the_title( $ancestor ), get_permalink( $ancestor ) );
		}
	}
	$trail[] = array( get_the_title( $post ), '' );
	return $trail;
}

/**
 * Breadcrumbs block.
 *
 * @param array    $attributes Attributes.
 * @param string   $content    Content.
 * @param WP_Block $block      Block instance.
 * @return string
 */
function secplus_render_breadcrumbs_block( $attributes, $content, $block ) {
	if ( is_front_page() ) {
		return '';
	}
	$post_id = $block->context['postId'] ?? null;
	$trail   = secplus_breadcrumb_trail( is_singular() || ! did_action( 'wp' ) ? $post_id : null );
	if ( count( $trail ) < 2 ) {
		return '';
	}
	$items = '';
	$last  = count( $trail ) - 1;
	foreach ( $trail as $i => $crumb ) {
		if ( $i === $last || '' === $crumb[1] ) {
			$items .= sprintf( '<li aria-current="page">%s</li>', esc_html( $crumb[0] ) );
		} else {
			$items .= sprintf( '<li><a href="%1$s">%2$s</a></li>', esc_url( $crumb[1] ), esc_html( $crumb[0] ) );
		}
	}
	return sprintf(
		'<nav %1$s aria-label="%2$s"><ol>%3$s</ol></nav>',
		get_block_wrapper_attributes( array( 'class' => 'sp-breadcrumbs' ) ),
		esc_attr__( 'Breadcrumb', 'secplus' ),
		$items
	);
}

/**
 * Copyright block.
 *
 * @return string
 */
function secplus_render_copyright_block() {
	return sprintf(
		'<p %1$s>&copy; %2$s %3$s. %4$s</p>',
		get_block_wrapper_attributes( array( 'class' => 'sp-copyright' ) ),
		esc_html( wp_date( 'Y' ) ),
		esc_html( get_bloginfo( 'name' ) ),
		esc_html__( 'All rights reserved.', 'secplus' )
	);
}

/**
 * Article meta: category, dates, professional reviewer and reading time.
 *
 * @param array    $attributes Attributes.
 * @param string   $content    Content.
 * @param WP_Block $block      Block.
 * @return string
 */
function secplus_render_article_meta_block( $attributes, $content, $block ) {
	$post_id = $block->context['postId'] ?? get_the_ID();
	if ( ! $post_id ) {
		return '';
	}
	$parts = array();

	$cats = get_the_category( $post_id );
	if ( $cats ) {
		$parts[] = sprintf( '<span class="sp-meta__item"><a class="sp-meta__cat" href="%1$s">%2$s</a></span>', esc_url( get_category_link( $cats[0] ) ), esc_html( $cats[0]->name ) );
	}

	$published = get_the_date( '', $post_id );
	$parts[]   = sprintf(
		'<span class="sp-meta__item">%1$s <time datetime="%2$s">%3$s</time></span>',
		esc_html__( 'Published', 'secplus' ),
		esc_attr( get_the_date( 'c', $post_id ) ),
		esc_html( $published )
	);

	$reviewed = get_post_meta( $post_id, 'secplus_last_reviewed', true );
	$reviewer = get_post_meta( $post_id, 'secplus_reviewer', true );
	if ( $reviewed ) {
		$parts[] = sprintf(
			'<span class="sp-meta__item">%1$s <time datetime="%2$s">%3$s</time></span>',
			esc_html__( 'Last reviewed', 'secplus' ),
			esc_attr( $reviewed ),
			esc_html( date_i18n( get_option( 'date_format' ), strtotime( $reviewed ) ) )
		);
	}
	if ( $reviewer ) {
		$parts[] = sprintf( '<span class="sp-meta__item">%1$s %2$s</span>', esc_html__( 'Reviewed by', 'secplus' ), esc_html( $reviewer ) );
	}

	$words   = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ) );
	$minutes = max( 1, (int) ceil( $words / 220 ) );
	/* translators: %d: minutes */
	$parts[] = sprintf( '<span class="sp-meta__item">%s</span>', esc_html( sprintf( _n( '%d min read', '%d min read', $minutes, 'secplus' ), $minutes ) ) );

	return sprintf( '<div %1$s>%2$s</div>', get_block_wrapper_attributes( array( 'class' => 'sp-meta' ) ), implode( '', $parts ) );
}

/**
 * Renders a list of post cards.
 *
 * @param WP_Post[] $posts Posts.
 * @return string
 */
function secplus_post_cards( $posts ) {
	$out = '';
	foreach ( $posts as $post ) {
		$cats = get_the_category( $post->ID );
		$cat  = $cats ? sprintf( '<p class="sp-post-card__cat">%s</p>', esc_html( $cats[0]->name ) ) : '';
		$out .= sprintf(
			'<article class="sp-post-card">%1$s<h3 class="sp-post-card__title"><a href="%2$s">%3$s</a></h3><p class="sp-post-card__excerpt">%4$s</p><p class="sp-post-card__more"><a href="%2$s" aria-hidden="true" tabindex="-1">%5$s</a></p></article>',
			$cat,
			esc_url( get_permalink( $post ) ),
			esc_html( get_the_title( $post ) ),
			esc_html( wp_trim_words( get_the_excerpt( $post ), 24 ) ),
			esc_html__( 'Read the guide', 'secplus' )
		);
	}
	return $out;
}

/**
 * Related insights (same category, then most recent).
 *
 * @param array    $attributes Attributes.
 * @param string   $content    Content.
 * @param WP_Block $block      Block.
 * @return string
 */
function secplus_render_related_posts_block( $attributes, $content, $block ) {
	$post_id = $block->context['postId'] ?? get_the_ID();
	$count   = max( 1, min( 6, (int) ( $attributes['count'] ?? 3 ) ) );
	$cats    = wp_get_post_categories( $post_id );
	$args    = array(
		'post_type'           => 'post',
		'posts_per_page'      => $count,
		'post__not_in'        => array( $post_id ),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);
	$posts   = $cats ? get_posts( array_merge( $args, array( 'category__in' => $cats ) ) ) : array();
	if ( count( $posts ) < $count ) {
		$exclude = array_merge( array( $post_id ), wp_list_pluck( $posts, 'ID' ) );
		$posts   = array_merge( $posts, get_posts( array_merge( $args, array( 'posts_per_page' => $count - count( $posts ), 'post__not_in' => $exclude ) ) ) );
	}
	if ( ! $posts ) {
		return '';
	}
	return sprintf(
		'<div %1$s><h2 class="sp-related__title">%2$s</h2><div class="sp-post-grid">%3$s</div></div>',
		get_block_wrapper_attributes( array( 'class' => 'sp-related' ) ),
		esc_html__( 'Related insights', 'secplus' ),
		secplus_post_cards( $posts )
	);
}

/**
 * Related service card for an article (chosen by meta or category).
 *
 * @param array    $attributes Attributes.
 * @param string   $content    Content.
 * @param WP_Block $block      Block.
 * @return string
 */
function secplus_render_related_service_block( $attributes, $content, $block ) {
	$post_id  = $block->context['postId'] ?? get_the_ID();
	$services = secplus_services();
	$slug     = (string) get_post_meta( $post_id, 'secplus_related_service', true );

	if ( ! isset( $services[ $slug ] ) ) {
		$map = secplus_category_service_map();
		foreach ( get_the_category( $post_id ) as $cat ) {
			if ( isset( $map[ $cat->slug ] ) ) {
				$slug = $map[ $cat->slug ];
				break;
			}
		}
	}
	if ( ! isset( $services[ $slug ] ) ) {
		$slug = 'company-registration';
	}
	$service = $services[ $slug ];

	return sprintf(
		'<aside %1$s><div class="sp-related-service__icon">%2$s</div><div class="sp-related-service__body"><h2 class="sp-related-service__title">%3$s</h2><p><strong>%4$s.</strong> %5$s</p><div class="sp-related-service__actions"><a class="sp-btn" href="%6$s">%7$s</a><a class="sp-btn sp-btn--ghost" href="%8$s">%9$s</a></div></div></aside>',
		get_block_wrapper_attributes( array( 'class' => 'sp-related-service' ) ),
		secplus_icon( $service['icon'] ),
		esc_html__( 'Need support with this?', 'secplus' ),
		esc_html( $service['title'] ),
		esc_html( $service['text'] ),
		esc_url( home_url( '/contact/?service=' . $slug . '#enquiry' ) ),
		esc_html( $service['cta'] ),
		esc_url( home_url( $service['path'] ) ),
		esc_html__( 'Explore the service', 'secplus' )
	);
}

/**
 * Links to related guides. Only published articles are shown, so draft or
 * pending-review guides never produce broken links.
 *
 * @param array $attributes Attributes.
 * @return string
 */
function secplus_render_guide_links_block( $attributes ) {
	$slugs = array_filter( array_map( 'sanitize_title', (array) ( $attributes['slugs'] ?? array() ) ) );
	if ( ! $slugs ) {
		return '';
	}
	$posts = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'post_name__in'  => $slugs,
			'orderby'        => 'post_name__in',
			'posts_per_page' => count( $slugs ),
			'no_found_rows'  => true,
		)
	);
	if ( ! $posts ) {
		return '';
	}
	$items = '';
	foreach ( $posts as $post ) {
		$items .= sprintf( '<li><a href="%1$s">%2$s</a></li>', esc_url( get_permalink( $post ) ), esc_html( get_the_title( $post ) ) );
	}
	return sprintf(
		'<div %1$s><p class="sp-guide-links__title">%2$s%3$s</p><ul>%4$s</ul></div>',
		get_block_wrapper_attributes( array( 'class' => 'sp-guide-links' ) ),
		secplus_icon( 'book' ),
		esc_html( $attributes['title'] ?? __( 'Related guides', 'secplus' ) ),
		$items
	);
}

/**
 * Insight topic cards with live article counts.
 *
 * @return string
 */
function secplus_render_topic_cards_block() {
	$cards = '';
	foreach ( secplus_topics() as $slug => $topic ) {
		$term  = get_category_by_slug( $slug );
		$count = $term ? (int) $term->count : 0;
		if ( $count > 0 ) {
			/* translators: %d: number of guides */
			$footer = sprintf( '<a class="sp-topic__link" href="%1$s">%2$s</a>', esc_url( get_category_link( $term ) ), esc_html( sprintf( _n( 'View %d guide', 'View %d guides', $count, 'secplus' ), $count ) ) );
		} else {
			$footer = sprintf( '<span class="sp-topic__soon">%s</span>', esc_html__( 'Guides in preparation', 'secplus' ) );
		}
		$cards .= sprintf(
			'<div class="sp-topic"><div class="sp-icon sp-icon--tint sp-icon--md">%1$s</div><h3>%2$s</h3><p>%3$s</p>%4$s</div>',
			secplus_icon( $topic['icon'] ),
			esc_html( $term ? $term->name : $topic['name'] ),
			esc_html( $topic['text'] ),
			$footer
		);
	}
	return sprintf( '<div %1$s>%2$s</div>', get_block_wrapper_attributes( array( 'class' => 'sp-topics' ) ), $cards );
}
