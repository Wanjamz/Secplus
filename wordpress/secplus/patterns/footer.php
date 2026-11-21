<?php
/**
 * Title: Site footer
 * Slug: secplus/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Inserter: no
 * Viewport Width: 1400
 *
 * @package SecPlus
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"sp-footer","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull sp-footer">
<!-- wp:group {"className":"sp-footer__grid","layout":{"type":"grid","minimumColumnWidth":"12rem"}} -->
<div class="wp-block-group sp-footer__grid">
<!-- wp:group {"className":"sp-footer__brand","layout":{"type":"default"}} -->
<div class="wp-block-group sp-footer__brand">
<!-- wp:site-logo {"width":170,"shouldSyncIcon":false,"className":"sp-footer__logo"} /-->
<!-- wp:paragraph {"className":"sp-footer__about"} -->
<p class="sp-footer__about">Corporate secretarial, compliance and governance support for Kenyan and international businesses and organizations at every stage of their corporate journey.</p>
<!-- /wp:paragraph -->
<!-- wp:secplus/contact-details {"layout":"footer"} /-->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"sp-footer__col","layout":{"type":"default"}} -->
<div class="wp-block-group sp-footer__col">
<!-- wp:heading {"className":"sp-footer__title"} -->
<h2 class="wp-block-heading sp-footer__title">Services</h2>
<!-- /wp:heading -->
<!-- wp:list {"className":"sp-footer__links"} -->
<ul class="wp-block-list sp-footer__links"><!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/services/company-registration/' ) ); ?>">Company Registration</a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/services/corporate-compliance/' ) ); ?>">Corporate Compliance</a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/services/company-secretarial/' ) ); ?>">Company Secretarial</a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/services/corporate-governance/' ) ); ?>">Corporate Governance</a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/services/corporate-advisory/' ) ); ?>">Corporate Advisory</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"sp-footer__col","layout":{"type":"default"}} -->
<div class="wp-block-group sp-footer__col">
<!-- wp:heading {"className":"sp-footer__title"} -->
<h2 class="wp-block-heading sp-footer__title">Who We Help</h2>
<!-- /wp:heading -->
<!-- wp:list {"className":"sp-footer__links"} -->
<ul class="wp-block-list sp-footer__links"><!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/who-we-help/kenyan-businesses/' ) ); ?>">Kenyan Businesses</a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/who-we-help/international-investors/' ) ); ?>">International Investors</a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/who-we-help/corporate-boards/' ) ); ?>">Corporate Boards</a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/who-we-help/professional-partners/' ) ); ?>">Professional Partners</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"sp-footer__col","layout":{"type":"default"}} -->
<div class="wp-block-group sp-footer__col">
<!-- wp:heading {"className":"sp-footer__title"} -->
<h2 class="wp-block-heading sp-footer__title">Useful Links</h2>
<!-- /wp:heading -->
<!-- wp:list {"className":"sp-footer__links"} -->
<ul class="wp-block-list sp-footer__links"><!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About SecPlus</a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/about/how-we-work/' ) ); ?>">How We Work</a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/insights/' ) ); ?>">Insights &amp; Resources</a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/faqs/' ) ); ?>">FAQs</a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/contact/#enquiry' ) ); ?>">Request a Consultation</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"sp-footer__bottom","layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group sp-footer__bottom">
<!-- wp:secplus/copyright /-->
<!-- wp:paragraph {"className":"sp-footer__legal"} -->
<p class="sp-footer__legal"><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a><a href="<?php echo esc_url( home_url( '/terms-of-use/' ) ); ?>">Terms of Use</a><a href="<?php echo esc_url( home_url( '/cookie-notice/' ) ); ?>">Cookie Notice</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
