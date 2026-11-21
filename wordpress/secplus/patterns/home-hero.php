<?php
/**
 * Title: Home: Hero
 * Slug: secplus/home-hero
 * Categories: secplus-home
 * Viewport Width: 1400
 *
 * @package SecPlus
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","align":"full","className":"sp-hero","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull sp-hero">
<!-- wp:columns {"verticalAlignment":"center","className":"sp-hero__cols"} -->
<div class="wp-block-columns are-vertically-aligned-center sp-hero__cols">
<!-- wp:column {"width":"56%","className":"sp-hero__text"} -->
<div class="wp-block-column sp-hero__text" style="flex-basis:56%">
<!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">SecPlus Consulting · Corporate Secretarial, Compliance &amp; Governance Services</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Your Partner in Corporate Compliance and Governance.</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"is-style-lead"} -->
<p class="is-style-lead">From company formation and statutory compliance to corporate secretarial services, board administration and governance advisory, SecPlus supports Kenyan and international businesses and organizations at every stage of their corporate journey.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Explore Our Services</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-navy"} -->
<div class="wp-block-button is-style-navy"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Speak to an Adviser</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<!-- wp:group {"className":"sp-hero__assurances","layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group sp-hero__assurances">
<!-- wp:group {"className":"sp-assurance","layout":{"type":"default"}} -->
<div class="wp-block-group sp-assurance">
<!-- wp:secplus/icon {"icon":"globe","variant":"plain","size":"sm"} /-->
<!-- wp:paragraph -->
<p>Kenyan &amp; international clients</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"sp-assurance","layout":{"type":"default"}} -->
<div class="wp-block-group sp-assurance">
<!-- wp:secplus/icon {"icon":"layers","variant":"plain","size":"sm"} /-->
<!-- wp:paragraph -->
<p>Formation to governance support</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"sp-assurance","layout":{"type":"default"}} -->
<div class="wp-block-group sp-assurance">
<!-- wp:secplus/icon {"icon":"file-check","variant":"plain","size":"sm"} /-->
<!-- wp:paragraph -->
<p>Clear scope before work begins</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column {"width":"44%","className":"sp-hero__media"} -->
<div class="wp-block-column sp-hero__media" style="flex-basis:44%">
<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"sp-hero__art"} -->
<figure class="wp-block-image size-full sp-hero__art"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/hero-nairobi-skyline.jpg' ) ); ?>" alt="Nairobi city skyline at sunrise, with the KICC tower and modern office buildings"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</section>
<!-- /wp:group -->
