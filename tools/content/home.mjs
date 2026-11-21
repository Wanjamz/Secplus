// Homepage sections (also exported as theme patterns).
import {
	url, img, group, flow, grid, row, columns, h, p, eyebrow, lead, buttons, image, icon, section,
	sectionHead, card, cardGrid, steps, ctaBand, latestPosts, arrowLink,
} from '../lib/blocks.mjs';

export const homeHero = () =>
	group({ tag: 'section', align: 'full', cls: 'sp-hero' }, [
		columns({ valign: 'center', cls: 'sp-hero__cols' }, [
			{
				width: '56%',
				cls: 'sp-hero__text',
				inner: [
					eyebrow('SecPlus Consulting · Corporate Secretarial, Compliance & Governance Services'),
					h(1, 'Your Partner in Corporate Compliance and Governance.'),
					lead('From company formation and statutory compliance to corporate secretarial services, board administration and governance advisory, SecPlus supports Kenyan and international businesses and organizations at every stage of their corporate journey.'),
					buttons([
						{ label: 'Explore Our Services', href: url('/services/') },
						{ label: 'Speak to an Adviser', href: url('/contact/'), style: 'navy' },
					]),
					row('sp-hero__assurances', [
						flow('sp-assurance', [icon('globe', 'plain', 'sm'), p('Kenyan &amp; international clients')]),
						flow('sp-assurance', [icon('layers', 'plain', 'sm'), p('Formation to governance support')]),
						flow('sp-assurance', [icon('file-check', 'plain', 'sm'), p('Clear scope before work begins')]),
					]),
				],
			},
			{
				width: '44%',
				cls: 'sp-hero__media',
				inner: [image(img('hero-nairobi-skyline.jpg'), 'Nairobi city skyline at sunrise, with the KICC tower and modern office buildings', 'sp-hero__art')],
			},
		]),
	]);

const routes = () => [
	{
		icon: 'building', iconVariant: 'solid', tag: 'Establish',
		title: 'Establish a Business',
		text: 'Company formation, registration and entity setup for Kenyan and international founders.',
		link: { label: 'Explore Company Registration', href: url('/services/company-registration/') },
	},
	{
		icon: 'shield-check', iconVariant: 'solid', tag: 'Maintain',
		title: 'Maintain Compliance',
		text: 'Statutory filings, annual returns, corporate records and company changes.',
		link: { label: 'Explore Compliance Services', href: url('/services/corporate-compliance/') },
	},
	{
		icon: 'landmark', iconVariant: 'solid', tag: 'Govern',
		title: 'Strengthen Governance',
		text: 'Company secretarial services, board administration, governance reviews and advisory.',
		link: { label: 'Explore Governance Support', href: url('/services/corporate-governance/') },
	},
	{
		icon: 'restructure', iconVariant: 'solid', tag: 'Advance',
		title: 'Navigate Corporate Changes',
		text: 'Corporate restructuring, share capital, ownership and specialist advisory matters.',
		link: { label: 'Explore Corporate Advisory', href: url('/services/corporate-advisory/') },
	},
];

export const homeRoutes = () =>
	group({ tag: 'section', align: 'full', cls: 'sp-routes-wrap' }, [
		flow('sp-routes', [
			flow('sp-routes__head', [
				h(2, 'What brings you to SecPlus?'),
				p('Whether you are establishing a company, maintaining statutory obligations, strengthening governance or navigating a corporate change, find the support that fits your needs.'),
			]),
			grid('sp-routes__grid', '14rem', routes().map((r) => card(r, 'sp-route-card'))),
		]),
	]);

export const homeAbout = () =>
	section('sp-about', [
		columns({ valign: 'center', cls: 'sp-about__cols' }, [
			{
				width: '46%',
				cls: 'sp-about__media',
				inner: [
					image(img('about-consultation.jpg'), 'A corporate adviser reviewing company documents with two clients in a Nairobi office', 'is-style-rounded-lg sp-about__img'),
				],
			},
			{
				width: '54%',
				inner: [
					eyebrow('About SecPlus'),
					h(2, 'Experienced Guidance for Your Organization.'),
					p('Corporate requirements can be complex. Finding the right guidance should not be. Registration, company records, filings and governance responsibilities all demand attention.'),
					p('SecPlus Consulting is a Kenyan corporate secretarial, compliance and governance consultancy. We help you understand the steps, manage important requirements and focus on the work ahead, whether your organization is new, established or navigating change.'),
					grid('sp-about__points', '15rem', [
						flow('sp-point', [icon('target'), h(3, 'Our purpose'), p('Clear guidance and practical corporate secretarial, compliance and governance support for organizations establishing and operating in Kenya.')]),
						flow('sp-point', [icon('compass'), h(3, 'Our approach'), p('We work to understand your circumstances, clarify the relevant requirements and provide support matched to the assignment.')]),
					]),
					row('sp-pillbar', [
						p('<strong>Clarity in compliance.</strong> Confidence in business.', 'sp-pillbar__text'),
						buttons([{ label: 'About SecPlus', href: url('/about/') }]),
					]),
				],
			},
		]),
	]);

const audiences = () => [
	{
		icon: 'chart', title: 'Kenyan Businesses',
		text: 'From first registration to everyday corporate responsibilities, for founders, growing SMEs and established companies.',
		link: { label: 'Support for Kenyan businesses', href: url('/who-we-help/kenyan-businesses/') },
	},
	{
		icon: 'globe', title: 'International Investors & Diaspora',
		text: 'Exploring a company or corporate presence in Kenya from abroad? Understand the structures, documents and obligations involved.',
		link: { label: 'Support for international clients', href: url('/who-we-help/international-investors/') },
	},
	{
		icon: 'presentation', title: 'Corporate Boards & Established Companies',
		text: 'Company secretarial, board administration and governance advisory support for directors and leadership teams.',
		link: { label: 'Support for boards', href: url('/who-we-help/corporate-boards/') },
	},
	{
		icon: 'handshake', title: 'Professional Referral Partners',
		text: 'A Kenyan point of contact for legal, accounting and advisory firms supporting clients with Kenyan corporate matters.',
		link: { label: 'Support for professional partners', href: url('/who-we-help/professional-partners/') },
	},
];

export const internationalBanner = () =>
	flow('sp-banner', [
		icon('globe', 'dark', 'lg'),
		flow('sp-banner__text', [
			h(3, 'Establishing a business in Kenya from abroad?'),
			p('Explore the considerations for non-resident founders, foreign investors and international companies seeking a Kenyan presence.'),
		]),
		buttons([{ label: 'Explore International Business Support', href: url('/who-we-help/international-investors/'), style: 'navy' }]),
	]);

export const homeAudiences = () =>
	section('sp-section--mist sp-audiences', [
		sectionHead({
			eb: 'Who We Help',
			title: 'Corporate support shaped around your situation.',
			intro: 'SecPlus works with founders, established companies, boards and professional advisers. Choose the path that best describes you.',
			c: 'is-centered',
		}),
		cardGrid(audiences(), '15rem', 'sp-card-grid sp-card-grid--4'),
		internationalBanner(),
	]);

const serviceCards = () => [
	{
		tag: 'Establish', icon: 'building', title: 'Company Registration & Entity Setup',
		text: 'Guidance on choosing a suitable structure and completing registration for Kenyan and international founders.',
		link: { label: 'Explore registration support', href: url('/services/company-registration/') },
	},
	{
		tag: 'Maintain', icon: 'shield-check', title: 'Corporate Compliance & Statutory Filings',
		text: 'Annual returns, statutory health checks, corporate records and company changes kept in view.',
		link: { label: 'Explore compliance support', href: url('/services/corporate-compliance/') },
	},
	{
		tag: 'Govern', icon: 'register', title: 'Company Secretarial Services',
		text: 'Dependable corporate administration, statutory registers, resolutions and meeting support beyond registration.',
		link: { label: 'Explore company secretarial support', href: url('/services/company-secretarial/') },
	},
	{
		tag: 'Govern', icon: 'landmark', title: 'Corporate Governance & Board Support',
		text: 'Board meeting support, governance documents and reviews that help your board govern with confidence.',
		link: { label: 'Explore governance support', href: url('/services/corporate-governance/') },
	},
	{
		tag: 'Advance', icon: 'restructure', title: 'Corporate Advisory & Restructuring',
		text: 'Support when ownership, share capital or corporate structures need to change.',
		link: { label: 'Explore corporate advisory', href: url('/services/corporate-advisory/') },
	},
];

export const servicesGrid = (withIntro = true) =>
	grid('sp-card-grid sp-services-grid', '17rem', [
		withIntro &&
			flow('sp-services-intro', [
				eyebrow('Our Services'),
				h(2, 'Corporate support for every stage of your business.'),
				p('Establish, maintain, govern and advance. Explore professional support for company establishment, statutory compliance, corporate governance and important corporate changes.'),
				buttons([{ label: 'View All Services', href: url('/services/'), style: 'navy' }]),
			]),
		...serviceCards().map((s) => card(s)),
	].filter(Boolean));

export const homeServices = () => section('sp-services', [servicesGrid(true)]);

export const whyItems = () => [
	{ icon: 'award', title: 'Specialist corporate focus', text: 'Our work centres on corporate secretarial, compliance and governance matters: the requirements that keep an organization properly structured and administered.' },
	{ icon: 'compass', title: 'Practical professional guidance', text: 'Plain-English explanations of what applies to your organization, what is needed from you and what happens next.' },
	{ icon: 'user-check', title: 'Client-focused service', text: 'We start with your circumstances and agree a defined scope before work begins, so responsibilities are clear from the outset.' },
	{ icon: 'refresh', title: 'Support across the business lifecycle', text: 'From formation and annual filings to board administration and corporate changes, support can continue as your organization develops.' },
	{ icon: 'globe', title: 'Local knowledge, international reach', text: 'Based in Kenya, supporting local organizations and international clients who need a dependable Kenyan corporate services partner.' },
	{ icon: 'lock', title: 'Confidentiality by design', text: 'Sensitive identity and corporate documents are only requested once an appropriate, secure process has been agreed with you.' },
];

export const homeWhy = () =>
	section('sp-section--navy sp-why', [
		columns({ cls: 'sp-why__cols' }, [
			{
				width: '38%',
				inner: [
					eyebrow('Why Work With SecPlus'),
					h(2, 'Professional guidance grounded in your business needs.'),
					p('Every company is different. SecPlus works to understand your circumstances, clarify the relevant requirements and provide support matched to the assignment.'),
					buttons([{ label: 'Meet SecPlus', href: url('/about/'), style: 'ghost' }]),
				],
			},
			{
				width: '62%',
				inner: [
					grid('sp-why__grid', '15rem', whyItems().map((w) => flow('sp-why-item', [icon(w.icon, 'solid', 'sm'), h(3, w.title), p(w.text)]))),
				],
			},
		]),
	]);

export const processSteps = () => [
	{ title: 'Tell us what you need', text: 'Share your company stage, location and the challenge or requirement you are facing.' },
	{ title: 'Receive guidance and a tailored proposal', text: 'We discuss scope, requirements and documentation, then propose a suitable approach and terms.' },
	{ title: 'Work with SecPlus through the agreed process', text: 'We carry out the agreed work, keep you informed and explain what we need from you.' },
	{ title: 'Access ongoing support where required', text: 'Understand your continuing obligations and retain support for filings, records and governance as needed.' },
];

export const homeProcess = () =>
	section('sp-process', [
		sectionHead({
			eb: 'How We Work',
			title: 'A clear process from first enquiry to ongoing support.',
			intro: 'Know what to expect when you discuss your corporate requirements with SecPlus.',
			c: 'is-centered',
		}),
		steps(processSteps()),
		flow('sp-center', [arrowLink('Learn how we work', url('/about/how-we-work/'))]),
	]);

export const homeInsights = () =>
	section('sp-section--mist sp-insights', [
		row('sp-section-head sp-section-head--row', [
			flow('sp-section-head__main', [
				eyebrow('Insights & Resources'),
				h(2, 'Answers to the questions businesses ask.'),
				p('Practical guides on company registration, statutory compliance, corporate governance, foreign investment and corporate change in Kenya.'),
			]),
			buttons([{ label: 'View All Insights', href: url('/insights/'), style: 'navy' }]),
		]),
		latestPosts(3, 1),
	]);

export const finalCta = () =>
	ctaBand({
		title: 'Let’s Discuss What Your Business Needs.',
		text: 'Whether your organization is new, established or navigating change, in Kenya or abroad, tell us what support you need and we will discuss an appropriate next step.',
		primary: { label: 'Request a Consultation', href: url('/contact/#enquiry') },
		secondary: { label: 'Explore Our Services', href: url('/services/') },
	});

// Client logo strip: [file, organization, official website (verified; omitted when unconfirmed)]. Each logo is a normal Image block, so editors can add, remove
// or replace logos in the block editor; the theme script turns the row into a
// seamless auto-scrolling marquee on the front end.
export const clientLogoList = [
	['cfao-motors.jpg', 'CFAO Motors', 'https://cfaomobility.co.ke/'],
	['dt-dobie.jpg', 'DT Dobie'],
	['bata.jpg', 'Bata', 'https://www.bata.com/ke/'],
	['visionfund-kenya.jpg', 'VisionFund Kenya', 'https://www.visionfund.org/'],
	['ihg.jpg', 'InterContinental Hotels Group', 'https://www.ihg.com/'],
	['pearson.jpg', 'Pearson', 'https://www.pearson.com/'],
	['directline.jpg', 'Directline Assurance'],
	['rider-levett-bucknall.jpg', 'Rider Levett Bucknall', 'https://www.rlb.com/africa/'],
	['hayer-group.jpg', 'Hayer Group'],
	['kvm.jpg', 'KVM', 'https://www.kvm.co.ke/'],
	['tisa.jpg', 'The Institute for Social Accountability', 'https://www.tisa.or.ke/'],
	['ebonylife-tv.jpg', 'EbonyLife TV'],
	['unifi.jpg', 'Unifi', 'https://unifi.credit/ke/'],
	['norfolk-towers.jpg', 'Norfolk Towers PLC'],
	['karunguru.jpg', 'Karunguru Gated Community', 'https://karungurugatedcommunity.com/'],
	['zaribee.jpg', 'Zaribee', 'https://zaribee.com/'],
	['jr-accounting.svg', 'JR Accounting'],
];

export const clientLogos = () =>
	group({ tag: 'section', align: 'full', cls: 'sp-clients' }, [
		p('Organizations we have supported', 'sp-clients__label'),
		group(
			{ cls: 'sp-logo-marquee', layout: { type: 'flex', flexWrap: 'wrap', justifyContent: 'center' } },
			clientLogoList.map(([file, name, href]) => image(img(`clients/${file}`), name, 'sp-logo', href))
		),
	]);

export const homePage = () =>
	[homeHero(), homeRoutes(), clientLogos(), homeAbout(), homeAudiences(), homeServices(), homeWhy(), homeProcess(), homeInsights(), finalCta()].join('\n\n');
