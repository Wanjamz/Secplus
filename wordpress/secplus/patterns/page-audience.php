<?php
/**
 * Title: Page starter: Audience page
 * Slug: secplus/page-audience
 * Categories: secplus-pages
 * Block Types: core/post-content
 * Post Types: page
 * Viewport Width: 1400
 *
 * @package SecPlus
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","align":"full","className":"sp-page-hero has-photo","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull sp-page-hero has-photo">
<!-- wp:columns {"verticalAlignment":"center","className":"sp-page-hero__cols"} -->
<div class="wp-block-columns are-vertically-aligned-center sp-page-hero__cols">
<!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%">
<!-- wp:secplus/breadcrumbs /-->
<!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">For Kenyan Businesses</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Build Your Business on the Right Foundation.</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"is-style-lead"} -->
<p class="is-style-lead">Whether you are registering a new company, managing statutory filings or preparing for the next stage of growth, SecPlus provides corporate support suited to your business needs.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/?audience=kenyan-business#enquiry' ) ); ?>">Discuss Your Business Needs</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-navy"} -->
<div class="wp-block-button is-style-navy"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Explore Our Services</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
</div>
<!-- /wp:column -->
<!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%">
<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"sp-page-hero__photo"} -->
<figure class="wp-block-image size-full sp-page-hero__photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/pages/kenyan-businesses.jpg' ) ); ?>" alt="A Kenyan entrepreneur reviewing company documents beside a laptop"/></figure>
<!-- /wp:image -->
<!-- wp:group {"className":"sp-hero-card","layout":{"type":"default"}} -->
<div class="wp-block-group sp-hero-card">
<!-- wp:secplus/icon {"icon":"chart","variant":"solid"} /-->
<!-- wp:heading {"className":"sp-hero-card__title"} -->
<h2 class="wp-block-heading sp-hero-card__title">Questions we can help you answer</h2>
<!-- /wp:heading -->
<!-- wp:list {"className":"is-style-checklist"} -->
<ul class="wp-block-list is-style-checklist"><!-- wp:list-item -->
<li>Which type of business entity should I consider?</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Can SecPlus review my current compliance position?</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Do you offer ongoing company secretarial support?</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"sp-section sp-split","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull sp-section sp-split">
<!-- wp:columns {"className":"sp-split__cols"} -->
<div class="wp-block-columns sp-split__cols">
<!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%">
<!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">Every stage of growth</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">From first registration to everyday corporate responsibilities.</h2>
<!-- /wp:heading -->
</div>
<!-- /wp:column -->
<!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%">
<!-- wp:paragraph -->
<p><strong>New founders</strong> need to choose the right structure and register it properly. <strong>Growing SMEs</strong> need to keep filings, registers and company changes in order as the business takes on staff, customers and investors. <strong>Established companies</strong> need dependable administration and governance that keeps pace with their responsibilities.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>SecPlus supports each of these stages, so you can focus on running and growing your business.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"sp-section sp-section--mist","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull sp-section sp-section--mist">
<!-- wp:group {"className":"sp-section-head","layout":{"type":"default"}} -->
<div class="wp-block-group sp-section-head">
<!-- wp:heading -->
<h2 class="wp-block-heading">Where are you today?</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"is-style-lead"} -->
<p class="is-style-lead">Start with the situation that best describes your business.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"sp-card-grid sp-card-grid--4","layout":{"type":"grid","minimumColumnWidth":"15rem"}} -->
<div class="wp-block-group sp-card-grid sp-card-grid--4">
<!-- wp:group {"className":"is-style-card sp-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-card sp-card">
<!-- wp:secplus/icon {"icon":"building"} /-->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">I want to register a business or company.</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Understand the structures available and the registration steps.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"is-style-arrow-link"} -->
<p class="is-style-arrow-link"><a href="<?php echo esc_url( home_url( '/services/company-registration/' ) ); ?>">Company registration</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"is-style-card sp-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-card sp-card">
<!-- wp:secplus/icon {"icon":"calendar"} /-->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">My company needs statutory filings or record updates.</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Bring annual returns, registers and changes up to date.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"is-style-arrow-link"} -->
<p class="is-style-arrow-link"><a href="<?php echo esc_url( home_url( '/services/corporate-compliance/' ) ); ?>">Corporate compliance</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"is-style-card sp-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-card sp-card">
<!-- wp:secplus/icon {"icon":"register"} /-->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">We need a company secretary or governance support.</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Dependable administration, meetings and governance documents.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"is-style-arrow-link"} -->
<p class="is-style-arrow-link"><a href="<?php echo esc_url( home_url( '/services/company-secretarial/' ) ); ?>">Company secretarial</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"is-style-card sp-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-card sp-card">
<!-- wp:secplus/icon {"icon":"restructure"} /-->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">We are changing ownership, directors or structure.</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Plan the resolutions, records and filings a change requires.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"is-style-arrow-link"} -->
<p class="is-style-arrow-link"><a href="<?php echo esc_url( home_url( '/services/corporate-advisory/' ) ); ?>">Corporate advisory</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"sp-section sp-challenges","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull sp-section sp-challenges">
<!-- wp:columns {"className":"sp-challenges__cols"} -->
<div class="wp-block-columns sp-challenges__cols">
<!-- wp:column {"width":"45%"} -->
<div class="wp-block-column" style="flex-basis:45%">
<!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">Common challenges</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">The questions that slow businesses down.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Most corporate issues are manageable when they are identified early. These are the challenges Kenyan businesses most often bring to us.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column {"width":"55%"} -->
<div class="wp-block-column" style="flex-basis:55%">
<!-- wp:group {"className":"is-style-card sp-card sp-card--flat","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-card sp-card sp-card--flat">
<!-- wp:list {"className":"is-style-checklist"} -->
<ul class="wp-block-list is-style-checklist"><!-- wp:list-item -->
<li>Choosing between a business name, a private company or another structure</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Not knowing whether annual returns and other filings are up to date</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Statutory registers and minutes that are incomplete or hard to find</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Missing a filing deadline after a change in directors or shareholders</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Unclear internal responsibility for corporate compliance</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Finding reliable, professional guidance you can trust</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"sp-section sp-section--navy","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull sp-section sp-section--navy">
<!-- wp:group {"className":"sp-section-head","layout":{"type":"default"}} -->
<div class="wp-block-group sp-section-head">
<!-- wp:heading -->
<h2 class="wp-block-heading">A practical approach, tailored to your business.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"is-style-lead"} -->
<p class="is-style-lead">We start by understanding your business and agree a scope that fits before work begins.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"sp-steps","layout":{"type":"grid","minimumColumnWidth":"13rem"}} -->
<div class="wp-block-group sp-steps">
<!-- wp:group {"className":"sp-step","layout":{"type":"default"}} -->
<div class="wp-block-group sp-step">
<!-- wp:paragraph {"className":"sp-step__num"} -->
<p class="sp-step__num">01</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Initial review</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>We discuss your business, its current position and what you want to achieve.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"sp-step","layout":{"type":"default"}} -->
<div class="wp-block-group sp-step">
<!-- wp:paragraph {"className":"sp-step__num"} -->
<p class="sp-step__num">02</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Tailored scope</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>We recommend the relevant services and agree a defined scope and terms.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"sp-step","layout":{"type":"default"}} -->
<div class="wp-block-group sp-step">
<!-- wp:paragraph {"className":"sp-step__num"} -->
<p class="sp-step__num">03</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Documentation</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>We explain the information and documents needed and how to share them securely.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"sp-step","layout":{"type":"default"}} -->
<div class="wp-block-group sp-step">
<!-- wp:paragraph {"className":"sp-step__num"} -->
<p class="sp-step__num">04</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Agreed process</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>We carry out the agreed work and explain your continuing obligations.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"sp-section sp-audience-services","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull sp-section sp-audience-services">
<!-- wp:group {"className":"sp-section-head","layout":{"type":"default"}} -->
<div class="wp-block-group sp-section-head">
<!-- wp:heading -->
<h2 class="wp-block-heading">Services for Kenyan businesses.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"is-style-lead"} -->
<p class="is-style-lead">The services Kenyan founders, SMEs and established companies use most.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"sp-card-grid sp-card-grid--3","layout":{"type":"grid","minimumColumnWidth":"16rem"}} -->
<div class="wp-block-group sp-card-grid sp-card-grid--3">
<!-- wp:group {"className":"is-style-card sp-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-card sp-card">
<!-- wp:secplus/icon {"icon":"building"} /-->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Company Registration &amp; Entity Setup</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Registering a business name or company on the right foundation.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"is-style-arrow-link"} -->
<p class="is-style-arrow-link"><a href="<?php echo esc_url( home_url( '/services/company-registration/' ) ); ?>">Explore the service</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"is-style-card sp-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-card sp-card">
<!-- wp:secplus/icon {"icon":"shield-check"} /-->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Corporate Compliance &amp; Statutory Filings</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Annual returns, health checks and company changes.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"is-style-arrow-link"} -->
<p class="is-style-arrow-link"><a href="<?php echo esc_url( home_url( '/services/corporate-compliance/' ) ); ?>">Explore the service</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"is-style-card sp-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-card sp-card">
<!-- wp:secplus/icon {"icon":"register"} /-->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Company Secretarial Services</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Ongoing administration, registers and meeting support.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"is-style-arrow-link"} -->
<p class="is-style-arrow-link"><a href="<?php echo esc_url( home_url( '/services/company-secretarial/' ) ); ?>">Explore the service</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"is-style-card sp-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-card sp-card">
<!-- wp:secplus/icon {"icon":"restructure"} /-->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Corporate Advisory &amp; Restructuring</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Share capital, ownership changes and restructuring.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"is-style-arrow-link"} -->
<p class="is-style-arrow-link"><a href="<?php echo esc_url( home_url( '/services/corporate-advisory/' ) ); ?>">Explore the service</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"is-style-card sp-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-card sp-card">
<!-- wp:secplus/icon {"icon":"landmark"} /-->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Corporate Governance &amp; Board Support</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Board support and governance documents as you grow.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"is-style-arrow-link"} -->
<p class="is-style-arrow-link"><a href="<?php echo esc_url( home_url( '/services/corporate-governance/' ) ); ?>">Explore the service</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"sp-section sp-section--mist sp-trust","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull sp-section sp-section--mist sp-trust">
<!-- wp:columns {"className":"sp-trust__cols"} -->
<div class="wp-block-columns sp-trust__cols">
<!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%">
<!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">Working with SecPlus</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Professional support you can understand.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Corporate matters are sensitive. We are clear about scope, responsibilities and how your information is handled.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"is-style-arrow-link"} -->
<p class="is-style-arrow-link"><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About SecPlus</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%">
<!-- wp:group {"className":"sp-mini-grid","layout":{"type":"grid","minimumColumnWidth":"14rem"}} -->
<div class="wp-block-group sp-mini-grid">
<!-- wp:group {"className":"sp-mini-card","layout":{"type":"default"}} -->
<div class="wp-block-group sp-mini-card">
<!-- wp:secplus/icon {"icon":"file-check","size":"sm"} /-->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Defined scope</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>You receive a clear scope, assumptions and terms before work begins.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"sp-mini-card","layout":{"type":"default"}} -->
<div class="wp-block-group sp-mini-card">
<!-- wp:secplus/icon {"icon":"lock","size":"sm"} /-->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Confidential handling</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Sensitive documents are requested only through an agreed, secure channel.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"sp-mini-card","layout":{"type":"default"}} -->
<div class="wp-block-group sp-mini-card">
<!-- wp:secplus/icon {"icon":"message","size":"sm"} /-->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Plain-English guidance</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Requirements explained clearly, with technical terms defined.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"sp-mini-card","layout":{"type":"default"}} -->
<div class="wp-block-group sp-mini-card">
<!-- wp:secplus/icon {"icon":"refresh","size":"sm"} /-->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Continuity</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Ongoing support available where it suits your organization.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"sp-section sp-faqs","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull sp-section sp-faqs">
<!-- wp:columns {"className":"sp-faqs__cols"} -->
<div class="wp-block-columns sp-faqs__cols">
<!-- wp:column {"width":"36%"} -->
<div class="wp-block-column" style="flex-basis:36%">
<!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">Frequently asked questions</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Questions we often hear.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>General information only. We will confirm what applies once we understand your circumstances.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"is-style-arrow-link"} -->
<p class="is-style-arrow-link"><a href="<?php echo esc_url( home_url( '/faqs/' ) ); ?>">View all FAQs</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column {"width":"64%"} -->
<div class="wp-block-column" style="flex-basis:64%">
<!-- wp:group {"className":"sp-faq-list","layout":{"type":"default"}} -->
<div class="wp-block-group sp-faq-list">
<!-- wp:details {"className":"sp-faq"} -->
<details class="wp-block-details sp-faq"><summary>Which type of business entity should I consider?</summary><!-- wp:paragraph -->
<p>It depends on factors such as ownership, liability, how you plan to raise finance and the formalities you are prepared to maintain. A business name registration suits some sole traders and partnerships, while a limited company provides a separate legal entity. We can talk through the options for your situation.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->
<!-- wp:details {"className":"sp-faq"} -->
<details class="wp-block-details sp-faq"><summary>Can SecPlus review my current compliance position?</summary><!-- wp:paragraph -->
<p>Yes. A statutory health check reviews your records and filings and identifies any gaps, together with the steps needed to correct them.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->
<!-- wp:details {"className":"sp-faq"} -->
<details class="wp-block-details sp-faq"><summary>Do you offer ongoing company secretarial support?</summary><!-- wp:paragraph -->
<p>Ongoing company secretarial support can be discussed and scoped to suit your company, from register maintenance to meeting support.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->
<!-- wp:details {"className":"sp-faq"} -->
<details class="wp-block-details sp-faq"><summary>What information should I prepare before contacting you?</summary><!-- wp:paragraph -->
<p>A short description of your business and what you need is enough to start. If you already have a company, its name and registration details are helpful. Please do not send confidential documents until a secure process has been agreed.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->
<!-- wp:details {"className":"sp-faq"} -->
<details class="wp-block-details sp-faq"><summary>What happens after I make an enquiry?</summary><!-- wp:paragraph -->
<p>We review your enquiry and contact you to discuss your needs and an appropriate next step. Where relevant, we will then send a proposal setting out scope and terms.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->
</div>
<!-- /wp:group -->
<!-- wp:secplus/guide-links {"slugs":["registering-a-company-in-kenya","business-name-or-limited-company-in-kenya","company-annual-returns-in-kenya","corporate-compliance-checklist"],"title":"Related guides"} /-->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"sp-section sp-section--cta","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull sp-section sp-section--cta">
<!-- wp:group {"className":"sp-cta","layout":{"type":"default"}} -->
<div class="wp-block-group sp-cta">
<!-- wp:group {"className":"sp-cta__text","layout":{"type":"default"}} -->
<div class="wp-block-group sp-cta__text">
<!-- wp:heading -->
<h2 class="wp-block-heading">Let’s talk about your business.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Whether you are starting out or keeping an established company in order, tell us what you need and we will discuss the next step.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:buttons {"className":"sp-cta__actions"} -->
<div class="wp-block-buttons sp-cta__actions"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/?audience=kenyan-business#enquiry' ) ); ?>">Discuss Your Business Needs</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-ghost"} -->
<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Explore Our Services</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->
