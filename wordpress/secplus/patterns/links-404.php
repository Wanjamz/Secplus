<?php
/**
 * Title: 404 links
 * Slug: secplus/links-404
 * Categories: secplus-sections
 * Inserter: no
 * Viewport Width: 1400
 *
 * @package SecPlus
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/' ) ); ?>">Go to the homepage</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-navy"} -->
<div class="wp-block-button is-style-navy"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Our Services</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-text"} -->
<div class="wp-block-button is-style-text"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Us</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
