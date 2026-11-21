<?php
/**
 * Title: Site header
 * Slug: secplus/header
 * Categories: header
 * Block Types: core/template-part/header
 * Inserter: no
 * Viewport Width: 1400
 *
 * @package SecPlus
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"sp-header","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull sp-header">
<!-- wp:group {"className":"sp-header__inner","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group sp-header__inner">
<!-- wp:site-logo {"width":170,"shouldSyncIcon":false,"className":"sp-header__logo"} /-->
<!-- wp:navigation {"overlayMenu":"mobile","className":"sp-nav","layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:navigation-link {"label":"Home","url":"<?php echo esc_url( home_url( '/' ) ); ?>","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-submenu {"label":"Who We Help","url":"<?php echo esc_url( home_url( '/who-we-help/' ) ); ?>","kind":"custom"} -->
<!-- wp:navigation-link {"label":"Kenyan Businesses","url":"<?php echo esc_url( home_url( '/who-we-help/kenyan-businesses/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"International Investors & Diaspora","url":"<?php echo esc_url( home_url( '/who-we-help/international-investors/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Corporate Boards","url":"<?php echo esc_url( home_url( '/who-we-help/corporate-boards/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Professional Partners","url":"<?php echo esc_url( home_url( '/who-we-help/professional-partners/' ) ); ?>","kind":"custom"} /-->
<!-- /wp:navigation-submenu -->
<!-- wp:navigation-submenu {"label":"Our Services","url":"<?php echo esc_url( home_url( '/services/' ) ); ?>","kind":"custom"} -->
<!-- wp:navigation-link {"label":"Company Registration & Entity Setup","url":"<?php echo esc_url( home_url( '/services/company-registration/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Corporate Compliance","url":"<?php echo esc_url( home_url( '/services/corporate-compliance/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Company Secretarial Services","url":"<?php echo esc_url( home_url( '/services/company-secretarial/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Corporate Governance","url":"<?php echo esc_url( home_url( '/services/corporate-governance/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Corporate Advisory & Restructuring","url":"<?php echo esc_url( home_url( '/services/corporate-advisory/' ) ); ?>","kind":"custom"} /-->
<!-- /wp:navigation-submenu -->
<!-- wp:navigation-submenu {"label":"Insights & Resources","url":"<?php echo esc_url( home_url( '/insights/' ) ); ?>","kind":"custom"} -->
<!-- wp:navigation-link {"label":"All Insights","url":"<?php echo esc_url( home_url( '/insights/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Frequently Asked Questions","url":"<?php echo esc_url( home_url( '/faqs/' ) ); ?>","kind":"custom"} /-->
<!-- /wp:navigation-submenu -->
<!-- wp:navigation-submenu {"label":"About Us","url":"<?php echo esc_url( home_url( '/about/' ) ); ?>","kind":"custom"} -->
<!-- wp:navigation-link {"label":"About SecPlus","url":"<?php echo esc_url( home_url( '/about/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"How We Work","url":"<?php echo esc_url( home_url( '/about/how-we-work/' ) ); ?>","kind":"custom"} /-->
<!-- /wp:navigation-submenu -->
<!-- wp:navigation-link {"label":"Contact","url":"<?php echo esc_url( home_url( '/contact/' ) ); ?>","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Request a Consultation","url":"<?php echo esc_url( home_url( '/contact/#enquiry' ) ); ?>","kind":"custom","className":"sp-nav__cta-mobile"} /-->
<!-- /wp:navigation -->
<!-- wp:buttons {"className":"sp-header__cta"} -->
<div class="wp-block-buttons sp-header__cta"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/#enquiry' ) ); ?>">Request a Consultation</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
