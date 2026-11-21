<?php
/**
 * Title: Home: Insights and resources
 * Slug: secplus/home-insights
 * Categories: secplus-home
 * Viewport Width: 1400
 *
 * @package SecPlus
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","align":"full","className":"sp-section sp-section--mist sp-insights","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull sp-section sp-section--mist sp-insights">
<!-- wp:group {"className":"sp-section-head sp-section-head--row","layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group sp-section-head sp-section-head--row">
<!-- wp:group {"className":"sp-section-head__main","layout":{"type":"default"}} -->
<div class="wp-block-group sp-section-head__main">
<!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">Insights &amp; Resources</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Answers to the questions businesses ask.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Practical guides on company registration, statutory compliance, corporate governance, foreign investment and corporate change in Kenya.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-navy"} -->
<div class="wp-block-button is-style-navy"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/insights/' ) ); ?>">View All Insights</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
<!-- wp:query {"queryId":1,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"sp-latest"} -->
<div class="wp-block-query sp-latest">
<!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"className":"sp-post-card","layout":{"type":"default"}} -->
<div class="wp-block-group sp-post-card">
<!-- wp:post-terms {"term":"category","className":"sp-post-card__cat"} /-->
<!-- wp:post-title {"level":3,"isLink":true,"className":"sp-post-card__title"} /-->
<!-- wp:post-excerpt {"excerptLength":24,"className":"sp-post-card__excerpt"} /-->
<!-- wp:read-more {"content":"Read the guide","className":"sp-post-card__more"} /-->
</div>
<!-- /wp:group -->
<!-- /wp:post-template -->
<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"sp-empty-note"} -->
<p class="sp-empty-note">New practical guides are being prepared and professionally reviewed. In the meantime, <a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">explore our services</a> or <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">ask us a question directly</a>.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
</section>
<!-- /wp:group -->
