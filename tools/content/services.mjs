// Services hub and the five detailed service pages.
import {
	url, flow, grid, columns, h, p, eyebrow, lead, buttons, icon, section, sectionHead, card,
	cardGrid, steps, faqList, ctaBand, pageHero, split, checklist, guideLinks, arrowLink, row,
} from '../lib/blocks.mjs';
import { servicesGrid } from './home.mjs';
import { photo } from './photos.mjs';

const SERVICES = {
	'company-registration': { title: 'Company Registration & Entity Setup', icon: 'building' },
	'corporate-compliance': { title: 'Corporate Compliance & Statutory Filings', icon: 'shield-check' },
	'company-secretarial': { title: 'Company Secretarial Services', icon: 'register' },
	'corporate-governance': { title: 'Corporate Governance & Board Support', icon: 'landmark' },
	'corporate-advisory': { title: 'Corporate Advisory & Restructuring', icon: 'restructure' },
};
const SERVICE_BLURB = {
	'company-registration': 'Choosing a structure and completing registration for Kenyan and international founders.',
	'corporate-compliance': 'Annual returns, statutory health checks, records and company changes.',
	'company-secretarial': 'Ongoing corporate administration, registers, resolutions and meetings.',
	'corporate-governance': 'Board meeting support, governance documents, reviews and training.',
	'corporate-advisory': 'Share capital, restructuring and other important corporate changes.',
};

export const engagementSteps = () => [
	{ title: 'Discuss your context', text: 'Tell us about the organization and what you need to achieve.' },
	{ title: 'Identify scope and documents', text: 'We clarify the requirements, the information needed and any other advisers involved.' },
	{ title: 'Agree the proposal', text: 'You receive a defined scope, responsibilities and commercial terms before work starts.' },
	{ title: 'Carry out the agreed work', text: 'We complete the agreed tasks and keep you informed of progress.' },
	{ title: 'Explain what follows', text: 'We explain the relevant follow-up obligations so nothing important is overlooked.' },
];

const prepareList = [
	'Your organization’s details, or the proposed structure if it is not yet registered',
	'Relevant corporate records you already hold, such as certificates, registers or resolutions',
	'A short description of the change, filing or requirement you need help with',
	'Any deadlines, regulator correspondence or dates you are working towards',
	'Your preferred contact method and the best time to reach you',
];

const contactUrl = (slug) => url(`/contact/?service=${slug}#enquiry`);

function relatedServices(current, list) {
	return cardGrid(
		list.map((slug) => ({
			icon: SERVICES[slug].icon,
			title: SERVICES[slug].title,
			text: SERVICE_BLURB[slug],
			link: { label: 'Explore the service', href: url(`/services/${slug}/`) },
		})),
		'16rem',
		'sp-card-grid sp-card-grid--3'
	);
}

function servicePage(d) {
	return [
		pageHero({
			eb: d.eyebrow,
			title: d.h1,
			text: d.lead,
			primary: { label: d.cta, href: contactUrl(d.slug) },
			secondary: { label: 'Speak to an Adviser', href: url('/contact/') },
			asideItems: d.questions,
			asideIcon: SERVICES[d.slug].icon,
			photo: photo(d.slug),
		}),
		split({ eb: 'The situation', title: d.situation.title, paras: d.situation.paras }),
		section('sp-section--mist', [
			sectionHead({ eb: 'What SecPlus can support', title: d.supportTitle, intro: d.supportIntro }),
			cardGrid(d.supports, '15rem', 'sp-card-grid sp-card-grid--3'),
			d.scopeNote && p(d.scopeNote, 'sp-note'),
		]),
		section('sp-who', [
			columns({ cls: 'sp-who__cols' }, [
				{
					width: '42%',
					inner: [eyebrow('Who this service is for'), h(2, d.forTitle), p(d.forIntro)],
				},
				{
					width: '58%',
					inner: [grid('sp-mini-grid', '15rem', d.forWho.map((w) => flow('sp-mini-card', [icon(w.icon, 'tint', 'sm'), h(3, w.title), p(w.text), w.href && arrowLink(w.label || 'Learn more', w.href)])))],
				},
			]),
		]),
		section('sp-section--navy sp-engage', [
			sectionHead({ eb: 'What the engagement involves', title: 'A clear, agreed process.', intro: 'Every assignment starts with understanding your situation. Scope, responsibilities and terms are agreed before work begins.' }),
			steps(engagementSteps(), 'sp-steps sp-steps--5'),
		]),
		section('sp-prepare', [
			columns({ cls: 'sp-prepare__cols' }, [
				{
					width: '50%',
					inner: [eyebrow('Before you get in touch'), h(2, 'What to prepare.'), p('You do not need everything in place to make an enquiry. These details help us understand your needs and suggest the right next step.'), checklist(prepareList)],
				},
				{
					width: '50%',
					inner: [
						flow('is-style-card sp-card sp-reassure', [
							icon('lock', 'dark'),
							h(3, 'How we keep your matter clear and confidential'),
							checklist([
								'A defined scope, assumptions and deliverables before work starts',
								'A clear explanation of what you are responsible for and what we handle',
								'Confidential documents requested only through an agreed, secure channel',
								'Involvement of other professionals, such as advocates or tax advisers, explained up front where it is needed',
							]),
							arrowLink('Learn how we work', url('/about/how-we-work/')),
						]),
					],
				},
			]),
		]),
		section('sp-section--mist sp-faqs', [
			columns({ cls: 'sp-faqs__cols' }, [
				{ width: '36%', inner: [eyebrow('Frequently asked questions'), h(2, d.faqTitle || 'Common questions.'), p('General information only. The right approach depends on your entity, circumstances and current legal requirements.'), arrowLink('View all FAQs', url('/faqs/'))] },
				{ width: '64%', inner: [faqList(d.faqs)] },
			]),
		]),
		section('sp-related-section', [
			sectionHead({ eb: 'Related services', title: 'Support that often goes together.' }),
			relatedServices(d.slug, d.related),
			guideLinks(d.guides, 'Related guides'),
		]),
		ctaBand({
			title: d.ctaTitle,
			text: d.ctaText,
			primary: { label: d.cta, href: contactUrl(d.slug) },
			secondary: { label: 'Explore All Services', href: url('/services/') },
		}),
	].filter(Boolean).join('\n\n');
}

export const servicePages = () => [
	{
		slug: 'company-registration',
		title: 'Company Registration & Entity Setup',
		meta: 'Company registration and entity setup support in Kenya: business names, private and public companies, companies limited by guarantee and foreign company registration.',
		content: servicePage({
			slug: 'company-registration',
			eyebrow: 'Company Registration & Entity Setup',
			h1: 'Start Your Business in Kenya on the Right Foundation.',
			lead: 'Whether establishing a new company or considering another legal structure, get guidance on the relevant registration steps and requirements.',
			cta: 'Request Registration Guidance',
			questions: [
				'What structure is appropriate for my business?',
				'What information and documents are required?',
				'What happens after registration?',
			],
			situation: {
				title: 'The structure you choose shapes what comes next.',
				paras: [
					'Founders need to choose a suitable structure, prepare the right documents and understand the obligations that continue after registration.',
					'The choice between a business name, a private company, a company limited by guarantee or a foreign company registration affects ownership, liability, governance and ongoing filings. Getting the foundation right makes it easier to open accounts, bring in investors and stay compliant as you grow.',
				],
			},
			supportTitle: 'Registration and setup support.',
			supportIntro: 'SecPlus can discuss the registration route that fits your plans and support the agreed steps.',
			supports: [
				{ icon: 'file-check', title: 'Business name registration', text: 'Registering the name under which a sole proprietor or partnership trades.' },
				{ icon: 'building', title: 'Private and public companies', text: 'Incorporating companies limited by shares, including the constitution and officer details.' },
				{ icon: 'users', title: 'Companies limited by guarantee', text: 'Setting up guarantee companies, often used by non-profit and membership organizations.' },
				{ icon: 'globe', title: 'Foreign company registration', text: 'Registering an overseas company’s Kenyan presence as a foreign company (branch).' },
				{ icon: 'layers', title: 'Entity conversions and setup advisory', text: 'Discussing changes of entity type and the practical setup steps that follow registration.' },
			],
			scopeNote: 'The exact scope of each assignment, and any third-party professional involvement, is confirmed in writing before work begins.',
			forTitle: 'Founders, investors and organizations getting started.',
			forIntro: 'Registration support is relevant whether you are starting locally, investing from abroad or setting up a new entity within an existing group.',
			forWho: [
				{ icon: 'chart', title: 'Kenyan founders and SMEs', text: 'Starting a business or moving from a business name to a company.', href: url('/who-we-help/kenyan-businesses/'), label: 'Kenyan businesses' },
				{ icon: 'globe', title: 'International investors and diaspora', text: 'Establishing a Kenyan company or presence from abroad.', href: url('/who-we-help/international-investors/'), label: 'International investors' },
				{ icon: 'building', title: 'Groups and established companies', text: 'Adding a subsidiary or new entity to an existing structure.', href: url('/who-we-help/corporate-boards/'), label: 'Corporate boards' },
				{ icon: 'handshake', title: 'Professional advisers', text: 'Firms needing local support for a client’s Kenyan entity.', href: url('/who-we-help/professional-partners/'), label: 'Professional partners' },
			],
			faqs: [
				{ q: 'What entity types can SecPlus help establish?', a: 'SecPlus can discuss business name registration, private and public companies, companies limited by guarantee and foreign company registration, as well as entity conversions. The right option depends on your ownership plans, activities and long-term goals.' },
				{ q: 'What documents should I prepare?', a: 'Typically, identification and contact details for the proposed directors and shareholders, proposed company names, the intended business activities and a registered office address. Additional documents may apply to foreign shareholders or corporate shareholders. We confirm the exact list once we understand your situation.' },
				{ q: 'What determines the cost and timeline?', a: 'Cost and timing depend on the entity type, the number and location of shareholders and directors, how quickly documents are available and the processing time of the relevant authorities. We will explain what applies to your case in our proposal.' },
				{ q: 'What obligations continue after registration?', a: 'Companies have continuing obligations, including maintaining statutory registers, filing annual returns, keeping beneficial ownership information current and notifying changes to the Registrar. Tax and licensing obligations may also apply. We explain the relevant follow-up obligations when registration is complete.' },
			],
			related: ['corporate-compliance', 'company-secretarial', 'corporate-advisory'],
			guides: ['registering-a-company-in-kenya', 'business-name-or-limited-company-in-kenya', 'registering-a-company-in-kenya-as-a-non-resident', 'branch-or-subsidiary-kenya'],
			ctaTitle: 'Ready to discuss your registration?',
			ctaText: 'Tell us about your plans and we will discuss the structure, documents and next steps that apply.',
		}),
	},
	{
		slug: 'corporate-compliance',
		title: 'Corporate Compliance & Statutory Filings',
		meta: 'Corporate compliance support in Kenya: annual returns, statutory health checks, changes in directors and shareholders, statutory meetings and records.',
		content: servicePage({
			slug: 'corporate-compliance',
			eyebrow: 'Corporate Compliance & Statutory Filings',
			h1: 'Keep Your Company’s Statutory Obligations in View.',
			lead: 'Support for maintaining corporate records, handling statutory filings and managing important company changes.',
			cta: 'Request a Compliance Review',
			questions: [
				'How can I check my company’s filing position?',
				'What happens when company details change?',
				'Can SecPlus provide continuing support?',
			],
			situation: {
				title: 'Growing companies can lose track of the details.',
				paras: [
					'A growing company can lose track of filings, records and changes, creating avoidable uncertainty for directors and shareholders.',
					'Missed annual returns, outdated registers or unrecorded changes in directors and shareholders can cause delays when you open accounts, raise finance, tender for work or undergo due diligence. A clear view of your statutory position helps you act early and with confidence.',
				],
			},
			supportTitle: 'Compliance and filing support.',
			supportIntro: 'Practical help to understand where your company stands and keep it up to date.',
			supports: [
				{ icon: 'calendar', title: 'Annual returns', text: 'Preparing and filing annual returns that reflect your company’s current information.' },
				{ icon: 'search', title: 'Statutory health checks', text: 'Reviewing records and filings to identify gaps and the steps needed to correct them.' },
				{ icon: 'users', title: 'Changes in directors, shareholders and registered office', text: 'Recording changes properly and making the related filings.' },
				{ icon: 'register', title: 'Statutory meetings and records', text: 'Supporting meetings, minutes and the statutory registers your company must keep.' },
				{ icon: 'shield-check', title: 'Regulatory compliance support', text: 'Helping you understand and organize recurring corporate compliance obligations.' },
			],
			scopeNote: 'Tax filings and sector-specific licensing may require other specialists. Where relevant, we explain this up front and coordinate as agreed.',
			forTitle: 'Companies that want certainty about their records.',
			forIntro: 'Compliance support is relevant to SMEs, established companies and foreign-owned entities with Kenyan obligations.',
			forWho: [
				{ icon: 'chart', title: 'Growing SMEs', text: 'Businesses with overdue filings, changes to record or unclear registers.', href: url('/who-we-help/kenyan-businesses/'), label: 'Kenyan businesses' },
				{ icon: 'globe', title: 'Foreign-owned companies', text: 'Kenyan entities managed from abroad that need local continuity.', href: url('/who-we-help/international-investors/'), label: 'International investors' },
				{ icon: 'presentation', title: 'Boards and company officers', text: 'Directors who want assurance that statutory obligations are being met.', href: url('/who-we-help/corporate-boards/'), label: 'Corporate boards' },
			],
			faqs: [
				{ q: 'How can I check whether my company is up to date?', a: 'A statutory health check compares your company’s records and registers with what has been filed, and identifies any outstanding returns or unrecorded changes. Share your company details and we can discuss a suitable review.' },
				{ q: 'What records should my company maintain?', a: 'Kenyan companies are generally required to keep statutory registers, such as registers of members, directors and beneficial owners, together with minutes and resolutions. The exact requirements depend on your company type.' },
				{ q: 'Can overdue filings be reviewed?', a: 'Yes. We can review your position, explain the steps required to bring filings up to date and discuss any penalties that may apply. Acting early usually makes corrections simpler.' },
				{ q: 'What happens when company details change?', a: 'Changes such as new directors, share transfers or a new registered office usually need to be approved in line with your constitution, recorded in your registers and notified to the Registrar within the period required by law.' },
				{ q: 'Can I request ongoing support?', a: 'Ongoing compliance and company secretarial support can be discussed where it suits your organization. The scope is agreed with you in advance.' },
			],
			related: ['company-secretarial', 'corporate-governance', 'corporate-advisory'],
			guides: ['company-annual-returns-in-kenya', 'changing-directors-or-shareholders-kenya', 'corporate-compliance-checklist'],
			ctaTitle: 'Want a clear view of your compliance position?',
			ctaText: 'Share your company details and the concern you have, and we will discuss a suitable review.',
		}),
	},
	{
		slug: 'company-secretarial',
		title: 'Company Secretarial Services',
		meta: 'Company secretarial services in Kenya: company secretary support, registered office support, statutory registers, resolutions and meeting support.',
		content: servicePage({
			slug: 'company-secretarial',
			eyebrow: 'Company Secretarial Services',
			h1: 'Dependable Corporate Administration, Beyond Registration.',
			lead: 'Support the ongoing statutory and administrative requirements of your company with specialist company secretarial services.',
			cta: 'Discuss Secretarial Support',
			questions: [
				'Does my company need a company secretary?',
				'Which company secretarial tasks can be outsourced?',
				'How does ongoing support work?',
			],
			situation: {
				title: 'Continuity, organized records and clear responsibilities.',
				paras: [
					'Company officers need continuity, organized records and clarity about responsibilities.',
					'When registers, resolutions and meeting records are handled informally, important details are easily lost as people change roles. A dedicated company secretarial function keeps the corporate record accurate and gives directors the procedural support they need.',
				],
			},
			supportTitle: 'Ongoing company secretarial support.',
			supportIntro: 'Specialist support for the statutory and administrative side of running a company.',
			supports: [
				{ icon: 'user-check', title: 'Company secretary services', text: 'Acting in, or supporting, the company secretary role as agreed with your board.' },
				{ icon: 'office', title: 'Registered office support', text: 'Registered office arrangements, subject to confirmation of scope.' },
				{ icon: 'register', title: 'Statutory registers and records', text: 'Maintaining the registers and records your company is required to keep.' },
				{ icon: 'pen', title: 'Corporate resolutions and meeting support', text: 'Preparing resolutions, notices and minutes and supporting meetings.' },
				{ icon: 'users', title: 'Local director or representative services', text: 'Considered case by case, only where legally appropriate and specifically confirmed.' },
			],
			scopeNote: 'Some services, such as local director or representative arrangements, are only offered where legally appropriate and specifically confirmed for your matter.',
			forTitle: 'Organizations that want dependable administration.',
			forIntro: 'Company secretarial support suits companies that need continuity, whether they are growing locally or managed from abroad.',
			forWho: [
				{ icon: 'chart', title: 'Growing companies', text: 'Businesses that have outgrown informal record keeping.', href: url('/who-we-help/kenyan-businesses/'), label: 'Kenyan businesses' },
				{ icon: 'presentation', title: 'Boards and established companies', text: 'Organizations that need a reliable secretarial function.', href: url('/who-we-help/corporate-boards/'), label: 'Corporate boards' },
				{ icon: 'globe', title: 'International groups', text: 'Kenyan subsidiaries and entities that need local continuity.', href: url('/who-we-help/international-investors/'), label: 'International investors' },
			],
			faqs: [
				{ q: 'Does my entity need a company secretary?', a: 'Under the Companies Act, 2015, public companies must have a qualified company secretary, and private companies above a specified paid-up capital threshold must also appoint one. Many smaller companies choose secretarial support anyway. We can discuss what applies to your company.' },
				{ q: 'What does a company secretary do?', a: 'A company secretary typically maintains the statutory registers, prepares and files returns, supports board and shareholder meetings, keeps minutes and resolutions, and helps directors follow proper procedure.' },
				{ q: 'What can be outsourced?', a: 'Most company secretarial tasks can be supported externally, including register maintenance, filings, meeting administration and resolutions. The board remains responsible for its decisions, and responsibilities are agreed clearly at the start.' },
				{ q: 'How does ongoing support work?', a: 'Ongoing support is usually organized around your company’s calendar of meetings and filings. The scope, reporting arrangements and terms are agreed in advance.' },
			],
			related: ['corporate-compliance', 'corporate-governance', 'company-registration'],
			guides: ['when-does-a-kenyan-company-need-a-company-secretary', 'company-annual-returns-in-kenya', 'board-governance-checklist'],
			ctaTitle: 'Looking for dependable company secretarial support?',
			ctaText: 'Tell us about your company and current arrangements, and we will discuss the support that fits.',
		}),
	},
	{
		slug: 'corporate-governance',
		title: 'Corporate Governance & Board Support',
		meta: 'Corporate governance and board support in Kenya: board meeting support, governance policies, governance reviews, board evaluation and training.',
		content: servicePage({
			slug: 'corporate-governance',
			eyebrow: 'Corporate Governance & Board Support',
			h1: 'Help Your Board Govern With Confidence.',
			lead: 'Strengthen governance processes, documentation and board administration through professional advisory and secretarial support.',
			cta: 'Discuss Governance Needs',
			questions: [
				'What does a governance review cover?',
				'How are board meetings supported?',
				'What information is needed to scope an assignment?',
			],
			situation: {
				title: 'Good governance requires more than good intentions.',
				paras: [
					'Boards need sound processes and clear documentation to support responsible oversight.',
					'Well-prepared board papers, accurate minutes, clear policies and regular review help directors make, record and follow through on decisions. Governance support gives your board the structure to focus on the decisions that matter.',
					'Ongoing statutory administration is covered by our <a href="' + url('/services/company-secretarial/') + '">company secretarial services</a>, which often work alongside governance support.',
				],
			},
			supportTitle: 'Governance and board support.',
			supportIntro: 'Advisory and administrative support for boards and leadership teams.',
			supports: [
				{ icon: 'presentation', title: 'Board meeting support', text: 'Calendars, agendas, board papers, minutes and action tracking.' },
				{ icon: 'clipboard', title: 'Governance policies and documents', text: 'Board charters, committee terms of reference and governance policies.' },
				{ icon: 'search', title: 'Governance audits or reviews', text: 'Reviewing governance structures, processes and documentation.' },
				{ icon: 'training', title: 'Board evaluation and training', text: 'Supporting board evaluation and director development.' },
				{ icon: 'landmark', title: 'Regulatory liaison where within scope', text: 'Supporting communication with relevant regulators where agreed.' },
			],
			scopeNote: 'Governance reviews, board evaluation and regulatory liaison are scoped individually and confirmed in writing before work begins.',
			forTitle: 'Boards and the people who support them.',
			forIntro: 'Governance support is designed for boards, executive teams, legal and compliance functions, and company administrators.',
			forWho: [
				{ icon: 'presentation', title: 'Boards of directors', text: 'Boards that want stronger processes, papers and records.', href: url('/who-we-help/corporate-boards/'), label: 'Corporate boards' },
				{ icon: 'shield-check', title: 'Legal and compliance teams', text: 'In-house teams that need specialist governance support.' },
				{ icon: 'users', title: 'Non-profit and membership organizations', text: 'Companies limited by guarantee with boards and members to serve.' },
			],
			faqs: [
				{ q: 'What does a governance review cover?', a: 'A governance review typically looks at board structure and composition, committee arrangements, policies, meeting processes and the quality of records. The scope is agreed with you at the start and depends on your organization’s needs and any sector requirements.' },
				{ q: 'What is involved in board meeting support?', a: 'Board meeting support can include planning the annual board calendar, preparing agendas and notices, collating board papers, attending meetings, drafting minutes and tracking agreed actions.' },
				{ q: 'Can SecPlus help prepare governance documents?', a: 'Yes. We can discuss board charters, committee terms of reference, conflict of interest policies and other governance documents suited to your organization.' },
				{ q: 'What information is needed to scope an assignment?', a: 'Usually your constitution, current board and committee structure, existing policies, recent minutes and a description of what prompted the review. We will confirm what is needed during our initial discussion.' },
			],
			related: ['company-secretarial', 'corporate-compliance', 'corporate-advisory'],
			guides: ['board-governance-checklist', 'when-does-a-kenyan-company-need-a-company-secretary'],
			ctaTitle: 'Discuss how to strengthen your board’s governance.',
			ctaText: 'Tell us about your board and what prompted the conversation, and we will suggest an appropriate next step.',
		}),
	},
	{
		slug: 'corporate-advisory',
		title: 'Corporate Advisory & Restructuring',
		meta: 'Corporate advisory and restructuring support in Kenya: share capital matters, restructuring and conversions, corporate documentation and regulator liaison.',
		content: servicePage({
			slug: 'corporate-advisory',
			eyebrow: 'Corporate Advisory & Restructuring',
			h1: 'Navigate Important Corporate Changes With Clarity.',
			lead: 'Get professional support when company ownership, capital arrangements or corporate structures need to change.',
			cta: 'Discuss a Corporate Matter',
			questions: [
				'What details should I provide about a restructuring?',
				'Which advisers may need to be involved?',
				'What approvals or filings could apply?',
			],
			situation: {
				title: 'Corporate changes need careful coordination.',
				paras: [
					'Corporate changes can have legal, governance and filing implications that require careful coordination.',
					'Issuing new shares, transferring ownership, converting an entity or reorganizing a group usually involves resolutions, updated registers, filings and sometimes regulatory approvals. Understanding the steps early helps you plan the change and avoid delays.',
				],
			},
			supportTitle: 'Advisory and restructuring support.',
			supportIntro: 'Support for the corporate secretarial side of important changes.',
			supports: [
				{ icon: 'coins', title: 'Share capital matters', text: 'Allotments, transfers and changes to share capital, with the related records and filings.' },
				{ icon: 'restructure', title: 'Corporate restructuring and conversions', text: 'Supporting the corporate steps involved in reorganizing or converting entities.' },
				{ icon: 'briefcase', title: 'Loans and employee share schemes', text: 'Corporate documentation for these matters where within confirmed expertise.' },
				{ icon: 'pen', title: 'Corporate documentation and statutory communication', text: 'Resolutions, notices and statutory communication for the change.' },
				{ icon: 'landmark', title: 'Liaison with relevant regulators', text: 'Supporting communication with relevant regulators as appropriate.' },
			],
			scopeNote: 'Some corporate changes also need legal, tax or valuation advice. Where this applies, we explain it early and coordinate with your advisers as agreed.',
			forTitle: 'Organizations planning a significant change.',
			forIntro: 'Corporate advisory support is relevant whenever ownership, capital or structure is about to change.',
			forWho: [
				{ icon: 'chart', title: 'Growing companies', text: 'Bringing in investors, issuing shares or changing ownership.', href: url('/who-we-help/kenyan-businesses/'), label: 'Kenyan businesses' },
				{ icon: 'globe', title: 'International groups', text: 'Reorganizing Kenyan entities within a wider group.', href: url('/who-we-help/international-investors/'), label: 'International investors' },
				{ icon: 'handshake', title: 'Professional advisers', text: 'Firms coordinating the Kenyan corporate steps of a transaction.', href: url('/who-we-help/professional-partners/'), label: 'Professional partners' },
			],
			faqs: [
				{ q: 'What details should I provide about a restructuring?', a: 'A summary of the current structure, the change you are planning, the parties involved, your target timing and any constraints. Your constitution and any shareholder agreement are also helpful.' },
				{ q: 'Which advisers may need to be involved?', a: 'Depending on the change, advocates, tax advisers, auditors or valuers may need to be involved. We explain where this is likely and coordinate within the agreed scope.' },
				{ q: 'What approvals or filings could apply?', a: 'Most changes need board and, in some cases, shareholder approval, updated registers and filings with the Registrar. Some transactions also need regulatory approval. The requirements depend on the specific change and your sector.' },
			],
			related: ['corporate-compliance', 'company-secretarial', 'corporate-governance'],
			guides: ['changing-directors-or-shareholders-kenya', 'branch-or-subsidiary-kenya'],
			ctaTitle: 'Planning an important corporate change?',
			ctaText: 'Share an outline of the change and your timing, and we will discuss the steps and support involved.',
		}),
	},
];

export const servicesHub = () =>
	[
		pageHero({
			eb: 'Our Services',
			photo: photo('services'),
			title: 'Corporate Support for Every Stage of Your Business.',
			text: 'Explore professional support for company establishment, statutory compliance, corporate governance and important corporate changes.',
			primary: { label: 'Tell Us What You Need', href: url('/contact/#enquiry') },
			secondary: { label: 'Speak to an Adviser', href: url('/contact/') },
			asideTitle: 'Find your service',
			asideIcon: 'compass',
			asideItems: [
				'I need to establish an entity: <a href="' + url('/services/company-registration/') + '">Company Registration</a>',
				'I need to keep records and filings current: <a href="' + url('/services/corporate-compliance/') + '">Compliance</a>',
				'I need ongoing company administration: <a href="' + url('/services/company-secretarial/') + '">Company Secretarial</a>',
				'I need board and governance support: <a href="' + url('/services/corporate-governance/') + '">Governance</a>',
				'I need advice on corporate changes: <a href="' + url('/services/corporate-advisory/') + '">Advisory</a>',
			],
		}),
		section('sp-services', [
			sectionHead({ eb: 'Service overview', title: 'Five service lines, one consistent approach.', intro: 'Each service starts with your situation and a clearly agreed scope.' }),
			servicesGrid(false),
		]),
		section('sp-section--mist sp-lifecycle', [
			sectionHead({ eb: 'How services connect', title: 'Support that grows with your organization.', intro: 'Registration is the beginning. As a company develops, it takes on filings, statutory administration and governance responsibilities, and sometimes needs to change its structure.', c: 'is-centered' }),
			grid('sp-lifecycle__grid', '12rem', [
				flow('sp-stage', [p('Establish', 'sp-tag'), icon('building', 'solid'), h(3, 'Set up the right entity'), p('Choose a structure and complete registration.')]),
				flow('sp-stage', [p('Maintain', 'sp-tag'), icon('shield-check', 'solid'), h(3, 'Keep records current'), p('File annual returns and record changes.')]),
				flow('sp-stage', [p('Govern', 'sp-tag'), icon('landmark', 'solid'), h(3, 'Support the board'), p('Administration, meetings and governance documents.')]),
				flow('sp-stage', [p('Advance', 'sp-tag'), icon('restructure', 'solid'), h(3, 'Manage change'), p('Share capital, ownership and restructuring.')]),
			]),
		]),
		split({
			eb: 'Decision support',
			title: 'Not sure which service you need?',
			paras: [
				'The right service depends on your entity type, your circumstances and the legal requirements that apply. Many clients start with one need and discover related obligations along the way.',
				'Tell us what you are trying to achieve. We will clarify the requirements, suggest the relevant service and explain the scope before any work begins.',
			],
			aside: buttons([{ label: 'Tell Us What You Need', href: url('/contact/#enquiry') }, { label: 'Who We Help', href: url('/who-we-help/'), style: 'navy' }]),
		}),
		ctaBand({
			title: 'Tell us what you need.',
			text: 'Kenyan and international clients can enquire online. We will review your requirements and contact you about an appropriate next step.',
			primary: { label: 'Request a Consultation', href: url('/contact/#enquiry') },
			secondary: { label: 'Learn How We Work', href: url('/about/how-we-work/') },
		}),
	].join('\n\n');
