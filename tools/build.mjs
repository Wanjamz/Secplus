// Generates theme patterns and importer content from the content modules.
// Usage: node tools/build.mjs
import { writeFileSync, mkdirSync, rmSync, readdirSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';
import { ctx, url, img, group, flow, row, h, p, buttons, list, image, contactDetails } from './lib/blocks.mjs';
import { PHOTOS } from './content/photos.mjs';
import * as home from './content/home.mjs';
import { servicePages, servicesHub } from './content/services.mjs';
import { audiencePages, audiencesHub } from './content/audiences.mjs';
import * as co from './content/company.mjs';
import { posts } from './content/posts.mjs';

const root = join(dirname(fileURLToPath(import.meta.url)), '..');
const THEME = join(root, 'wordpress', 'secplus');
const CORE = join(root, 'wordpress', 'secplus-core');

const write = (file, data) => {
	mkdirSync(dirname(file), { recursive: true });
	writeFileSync(file, data, 'utf8');
};

/* ------------------------------------------------------------------ */
/* Header & footer (theme patterns, PHP mode)                          */
/* ------------------------------------------------------------------ */

const navLink = (label, path) =>
	`<!-- wp:navigation-link ${JSON.stringify({ label, url: '__URL__', kind: 'custom', isTopLevelLink: true })} /-->`.replace('"__URL__"', `"${url(path)}"`);
const navSub = (label, path, items) =>
	[
		`<!-- wp:navigation-submenu ${JSON.stringify({ label, url: '__URL__', kind: 'custom' })} -->`.replace('"__URL__"', `"${url(path)}"`),
		...items.map(([l, pth]) => `<!-- wp:navigation-link ${JSON.stringify({ label: l, url: '__URL__', kind: 'custom' })} /-->`.replace('"__URL__"', `"${url(pth)}"`)),
		`<!-- /wp:navigation-submenu -->`,
	].join('\n');

const header = () =>
	group({ align: 'full', cls: 'sp-header', layout: { type: 'constrained' } }, [
		group({ cls: 'sp-header__inner', layout: { type: 'flex', flexWrap: 'nowrap', justifyContent: 'space-between' } }, [
			`<!-- wp:site-logo {"width":170,"shouldSyncIcon":false,"className":"sp-header__logo"} /-->`,
			[
				`<!-- wp:navigation {"overlayMenu":"mobile","className":"sp-nav","layout":{"type":"flex","justifyContent":"center"}} -->`,
				navLink('Home', '/'),
				navSub('Who We Help', '/who-we-help/', [
					['Kenyan Businesses', '/who-we-help/kenyan-businesses/'],
					['International Investors & Diaspora', '/who-we-help/international-investors/'],
					['Corporate Boards', '/who-we-help/corporate-boards/'],
					['Professional Partners', '/who-we-help/professional-partners/'],
				]),
				navSub('Our Services', '/services/', [
					['Company Registration & Entity Setup', '/services/company-registration/'],
					['Corporate Compliance', '/services/corporate-compliance/'],
					['Company Secretarial Services', '/services/company-secretarial/'],
					['Corporate Governance', '/services/corporate-governance/'],
					['Corporate Advisory & Restructuring', '/services/corporate-advisory/'],
				]),
				navSub('Insights & Resources', '/insights/', [
					['All Insights', '/insights/'],
					['Frequently Asked Questions', '/faqs/'],
				]),
				navSub('About Us', '/about/', [
					['About SecPlus', '/about/'],
					['How We Work', '/about/how-we-work/'],
				]),
				navLink('Contact', '/contact/'),
				`<!-- wp:navigation-link ${JSON.stringify({ label: 'Request a Consultation', url: '__URL__', kind: 'custom', className: 'sp-nav__cta-mobile' })} /-->`.replace('"__URL__"', `"${url('/contact/#enquiry')}"`),
				`<!-- /wp:navigation -->`,
			].join('\n'),
			buttons([{ label: 'Request a Consultation', href: url('/contact/#enquiry') }], 'sp-header__cta'),
		]),
	]);

const footerCol = (title, links) =>
	flow('sp-footer__col', [h(2, title, 'sp-footer__title'), list(links.map(([l, pth]) => `<a href="${url(pth)}">${l}</a>`), 'sp-footer__links')]);

const footer = () =>
	group({ align: 'full', cls: 'sp-footer' }, [
		group({ cls: 'sp-footer__grid', layout: { type: 'grid', minimumColumnWidth: '12rem' } }, [
			flow('sp-footer__brand', [
				`<!-- wp:site-logo {"width":170,"shouldSyncIcon":false,"className":"sp-footer__logo"} /-->`,
				p('Corporate secretarial, compliance and governance support for Kenyan and international businesses and organizations at every stage of their corporate journey.', 'sp-footer__about'),
				contactDetails('footer'),
			]),
			footerCol('Services', [
				['Company Registration', '/services/company-registration/'],
				['Corporate Compliance', '/services/corporate-compliance/'],
				['Company Secretarial', '/services/company-secretarial/'],
				['Corporate Governance', '/services/corporate-governance/'],
				['Corporate Advisory', '/services/corporate-advisory/'],
			]),
			footerCol('Who We Help', [
				['Kenyan Businesses', '/who-we-help/kenyan-businesses/'],
				['International Investors', '/who-we-help/international-investors/'],
				['Corporate Boards', '/who-we-help/corporate-boards/'],
				['Professional Partners', '/who-we-help/professional-partners/'],
			]),
			footerCol('Useful Links', [
				['About SecPlus', '/about/'],
				['How We Work', '/about/how-we-work/'],
				['Insights & Resources', '/insights/'],
				['FAQs', '/faqs/'],
				['Request a Consultation', '/contact/#enquiry'],
			]),
		]),
		row('sp-footer__bottom', [
			`<!-- wp:secplus/copyright /-->`,
			p(`<a href="${url('/privacy-policy/')}">Privacy Policy</a><a href="${url('/terms-of-use/')}">Terms of Use</a><a href="${url('/cookie-notice/')}">Cookie Notice</a>`, 'sp-footer__legal'),
		]),
	]);

/* ------------------------------------------------------------------ */
/* Patterns                                                            */
/* ------------------------------------------------------------------ */

const patterns = [
	['header', 'Site header', 'header', header, { inserter: false, blockTypes: 'core/template-part/header' }],
	['footer', 'Site footer', 'footer', footer, { inserter: false, blockTypes: 'core/template-part/footer' }],
	['home-hero', 'Home: Hero', 'secplus-home', home.homeHero],
	['home-routes', 'Home: What brings you to SecPlus?', 'secplus-home', home.homeRoutes],
	['home-clients', 'Client logo strip (auto-scrolling)', 'secplus-home', home.clientLogos],
	['home-about','Home: About SecPlus', 'secplus-home', home.homeAbout],
	['home-audiences', 'Home: Who we help', 'secplus-home', home.homeAudiences],
	['home-services', 'Home: Our services', 'secplus-home', home.homeServices],
	['home-why', 'Home: Why work with SecPlus', 'secplus-home', home.homeWhy],
	['home-process', 'Home: How we work', 'secplus-home', home.homeProcess],
	['home-insights', 'Home: Insights and resources', 'secplus-home', home.homeInsights],
	['cta-final', 'Call to action: Let’s discuss what your business needs', 'secplus-cta', home.finalCta],
	['international-banner', 'International invitation banner', 'secplus-sections', home.internationalBanner],
	['hero-photo-documents', 'Hero photo: documents', 'secplus-sections', () => image(img('pages/legal.jpg'), PHOTOS.legal, 'sp-page-hero__photo'), { inserter: false }],
	['hero-photo-insights', 'Hero photo: insights', 'secplus-sections', () => image(img('pages/insights.jpg'), PHOTOS.insights, 'sp-page-hero__photo'), { inserter: false }],
	['links-404', '404 links', 'secplus-sections', () => buttons([{ label: 'Go to the homepage', href: url('/') }, { label: 'Our Services', href: url('/services/'), style: 'navy' }, { label: 'Contact Us', href: url('/contact/'), style: 'text' }]), { inserter: false }],
	['page-service','Page starter: Service page', 'secplus-pages', () => servicePages()[0].content, { postTypes: 'page', blockTypes: 'core/post-content' }],
	['page-audience', 'Page starter: Audience page', 'secplus-pages', () => audiencePages()[0].content, { postTypes: 'page', blockTypes: 'core/post-content' }],
];

function buildPatterns() {
	ctx.mode = 'php';
	const dir = join(THEME, 'patterns');
	rmSync(dir, { recursive: true, force: true });
	for (const [slug, title, cat, fn, opt = {}] of patterns) {
		const headerLines = [
			'<?php',
			'/**',
			` * Title: ${title}`,
			` * Slug: secplus/${slug}`,
			` * Categories: ${cat}`,
			opt.blockTypes ? ` * Block Types: ${opt.blockTypes}` : null,
			opt.postTypes ? ` * Post Types: ${opt.postTypes}` : null,
			opt.inserter === false ? ' * Inserter: no' : null,
			' * Viewport Width: 1400',
			' *',
			' * @package SecPlus',
			' */',
			'',
			"defined( 'ABSPATH' ) || exit;",
			'?>',
		].filter((l) => l !== null);
		write(join(dir, `${slug}.php`), headerLines.join('\n') + '\n' + fn() + '\n');
	}
	return patterns.length;
}

/* ------------------------------------------------------------------ */
/* Importer content (content mode)                                     */
/* ------------------------------------------------------------------ */

function buildContent() {
	ctx.mode = 'content';
	const pagesDir = join(CORE, 'content', 'pages');
	const postsDir = join(CORE, 'content', 'posts');
	rmSync(pagesDir, { recursive: true, force: true });
	rmSync(postsDir, { recursive: true, force: true });

	const L = 'page-landing';
	const pages = [
		{ slug: 'home', title: 'Home', template: L, front: true, meta: 'SecPlus Consulting: corporate secretarial, compliance and governance services for Kenyan and international businesses, from company formation to board support.', content: home.homePage() },
		{ slug: 'who-we-help', title: 'Who We Help', template: L, meta: 'SecPlus supports Kenyan businesses, international investors and diaspora founders, corporate boards and professional referral partners.', content: audiencesHub() },
		...audiencePages().map((pg) => ({ ...pg, parent: 'who-we-help', template: L })),
		{ slug: 'services', title: 'Our Services', template: L, meta: 'Company registration, corporate compliance, company secretarial, corporate governance and corporate advisory services in Kenya.', content: servicesHub() },
		...servicePages().map((pg) => ({ ...pg, parent: 'services', template: L })),
		{ slug: 'insights', title: 'Insights & Resources', template: L, meta: 'Practical guides on company registration, statutory compliance, governance and foreign investment in Kenya.', content: co.insightsPage() },
		{ slug: 'faqs', title: 'Frequently Asked Questions', template: L, meta: 'Answers to common questions about company registration, compliance, governance, international clients and working with SecPlus.', content: co.faqPage() },
		{ slug: 'about', title: 'About Us', template: L, meta: 'About SecPlus Consulting: a Kenyan corporate secretarial, compliance and governance consultancy supporting local and international clients.', content: co.aboutPage() },
		{ slug: 'how-we-work', title: 'How We Work', parent: 'about', template: L, meta: 'How SecPlus works: from first enquiry and initial discussion to proposal, engagement, delivery and ongoing support.', content: co.howWeWorkPage() },
		{ slug: 'our-people', title: 'Our People & Credentials', parent: 'about', template: L, status: 'draft', meta: 'Meet the professionals behind SecPlus Consulting.', content: co.peoplePage() },
		{ slug: 'client-experiences', title: 'Client Experiences', parent: 'about', template: L, status: 'draft', meta: 'How businesses have worked through corporate challenges with SecPlus.', content: co.caseStudiesPage() },
		{ slug: 'contact', title: 'Contact', template: L, meta: 'Request a consultation with SecPlus Consulting. Kenyan and international clients can enquire online about corporate secretarial, compliance and governance support.', content: co.contactPage() },
		{ slug: 'privacy-policy', title: 'Privacy Policy', meta: 'How SecPlus Consulting collects, uses and protects personal data under Kenya’s Data Protection Act, 2019.', content: co.privacyPage(), legal: true },
		{ slug: 'terms-of-use', title: 'Terms of Use', meta: 'Terms governing use of the SecPlus Consulting website.', content: co.termsPage(), legal: true },
		{ slug: 'cookie-notice', title: 'Cookie Notice', meta: 'How the SecPlus Consulting website uses cookies.', content: co.cookiePage(), legal: true },
	];

	const manifest = pages.map((pg, i) => {
		write(join(pagesDir, `${pg.slug}.html`), pg.content + '\n');
		return {
			slug: pg.slug,
			title: pg.title,
			parent: pg.parent || '',
			template: pg.template || '',
			status: pg.status || 'publish',
			front: !!pg.front,
			legal: !!pg.legal,
			meta: pg.meta || '',
			order: i,
		};
	});
	write(join(pagesDir, 'manifest.json'), JSON.stringify(manifest, null, '\t'));

	const postList = posts().map((po, i) => {
		write(join(postsDir, `${po.slug}.html`), po.content.join('\n\n') + '\n');
		return { slug: po.slug, title: po.title, category: po.category, service: po.service, excerpt: po.excerpt, meta: po.meta, reader: po.reader, order: i };
	});
	write(join(postsDir, 'manifest.json'), JSON.stringify(postList, null, '\t'));
	return [manifest.length, postList.length];
}

const n = buildPatterns();
const [np, nposts] = buildContent();
console.log(`Patterns: ${n} | Pages: ${np} | Posts: ${nposts}`);
