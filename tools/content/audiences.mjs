// "Who We Help" hub and the four audience landing pages.
import {
	url, flow, grid, columns, h, p, eyebrow, buttons, icon, section, sectionHead, card, cardGrid,
	steps, faqList, ctaBand, pageHero, split, checklist, guideLinks, arrowLink,
} from '../lib/blocks.mjs';
import { internationalBanner } from './home.mjs';
import { photo } from './photos.mjs';

const AUDIENCE_SLUG = { 'kenyan-business': 'kenyan-businesses', 'international-investor': 'international-investors', 'corporate-board': 'corporate-boards', 'professional-partner': 'professional-partners' };

const svc = {
	reg: { icon: 'building', title: 'Company Registration & Entity Setup', path: '/services/company-registration/' },
	comp: { icon: 'shield-check', title: 'Corporate Compliance & Statutory Filings', path: '/services/corporate-compliance/' },
	sec: { icon: 'register', title: 'Company Secretarial Services', path: '/services/company-secretarial/' },
	gov: { icon: 'landmark', title: 'Corporate Governance & Board Support', path: '/services/corporate-governance/' },
	adv: { icon: 'restructure', title: 'Corporate Advisory & Restructuring', path: '/services/corporate-advisory/' },
};
const svcCard = (key, text) => ({ icon: svc[key].icon, title: svc[key].title, text, link: { label: 'Explore the service', href: url(svc[key].path) } });

function audiencePage(d) {
	return [
		pageHero({
			eb: d.eyebrow,
			title: d.h1,
			text: d.lead,
			primary: { label: d.cta, href: url(`/contact/?audience=${d.audience}#enquiry`) },
			secondary: d.secondary,
			asideItems: d.questions,
			asideIcon: d.icon,
			photo: photo(AUDIENCE_SLUG[d.audience]),
		}),
		split({ eb: d.intro.eb, title: d.intro.title, paras: d.intro.paras }),
		section('sp-section--mist', [
			sectionHead({ eb: d.situations.eb, title: d.situations.title, intro: d.situations.intro }),
			cardGrid(d.situations.items, '15rem', 'sp-card-grid sp-card-grid--4'),
		]),
		section('sp-challenges', [
			columns({ cls: 'sp-challenges__cols' }, [
				{ width: '45%', inner: [eyebrow(d.challenges.eb), h(2, d.challenges.title), p(d.challenges.text)] },
				{ width: '55%', inner: [flow('is-style-card sp-card sp-card--flat', [checklist(d.challenges.items)])] },
			]),
		]),
		section('sp-section--navy', [
			sectionHead({ eb: 'How SecPlus helps', title: d.approach.title, intro: d.approach.intro }),
			steps(d.approach.steps, d.approach.steps.length === 5 ? 'sp-steps sp-steps--5' : 'sp-steps'),
		]),
		section('sp-audience-services', [
			sectionHead({ eb: 'Relevant services', title: d.services.title, intro: d.services.intro }),
			cardGrid(d.services.items, '16rem', 'sp-card-grid sp-card-grid--3'),
		]),
		section('sp-section--mist sp-trust', [
			columns({ cls: 'sp-trust__cols' }, [
				{ width: '40%', inner: [eyebrow(d.trust.eb || 'Working with SecPlus'), h(2, d.trust.title), p(d.trust.text), arrowLink('About SecPlus', url('/about/'))] },
				{ width: '60%', inner: [grid('sp-mini-grid', '14rem', d.trust.items.map((t) => flow('sp-mini-card', [icon(t.icon, 'tint', 'sm'), h(3, t.title), p(t.text)])))] },
			]),
		]),
		section('sp-faqs', [
			columns({ cls: 'sp-faqs__cols' }, [
				{ width: '36%', inner: [eyebrow('Frequently asked questions'), h(2, 'Questions we often hear.'), p('General information only. We will confirm what applies once we understand your circumstances.'), arrowLink('View all FAQs', url('/faqs/'))] },
				{ width: '64%', inner: [faqList(d.faqs), guideLinks(d.guides, 'Related guides')] },
			]),
		]),
		ctaBand({
			title: d.ctaTitle,
			text: d.ctaText,
			primary: { label: d.cta, href: url(`/contact/?audience=${d.audience}#enquiry`) },
			secondary: { label: 'Explore Our Services', href: url('/services/') },
		}),
	].join('\n\n');
}

const trustCommon = [
	{ icon: 'file-check', title: 'Defined scope', text: 'You receive a clear scope, assumptions and terms before work begins.' },
	{ icon: 'lock', title: 'Confidential handling', text: 'Sensitive documents are requested only through an agreed, secure channel.' },
	{ icon: 'message', title: 'Plain-English guidance', text: 'Requirements explained clearly, with technical terms defined.' },
	{ icon: 'refresh', title: 'Continuity', text: 'Ongoing support available where it suits your organization.' },
];

export const audiencePages = () => [
	{
		slug: 'kenyan-businesses',
		title: 'Kenyan Businesses',
		meta: 'Corporate support for Kenyan founders, SMEs and established companies: company registration, statutory compliance, company secretarial and corporate advisory.',
		content: audiencePage({
			audience: 'kenyan-business',
			icon: 'chart',
			eyebrow: 'For Kenyan Businesses',
			h1: 'Build Your Business on the Right Foundation.',
			lead: 'Whether you are registering a new company, managing statutory filings or preparing for the next stage of growth, SecPlus provides corporate support suited to your business needs.',
			cta: 'Discuss Your Business Needs',
			secondary: { label: 'Explore Our Services', href: url('/services/') },
			questions: [
				'Which type of business entity should I consider?',
				'Can SecPlus review my current compliance position?',
				'Do you offer ongoing company secretarial support?',
			],
			intro: {
				eb: 'Every stage of growth',
				title: 'From first registration to everyday corporate responsibilities.',
				paras: [
					'<strong>New founders</strong> need to choose the right structure and register it properly. <strong>Growing SMEs</strong> need to keep filings, registers and company changes in order as the business takes on staff, customers and investors. <strong>Established companies</strong> need dependable administration and governance that keeps pace with their responsibilities.',
					'SecPlus supports each of these stages, so you can focus on running and growing your business.',
				],
			},
			situations: {
				eb: 'Choose your situation',
				title: 'Where are you today?',
				intro: 'Start with the situation that best describes your business.',
				items: [
					{ icon: 'building', title: 'I want to register a business or company.', text: 'Understand the structures available and the registration steps.', link: { label: 'Company registration', href: url('/services/company-registration/') } },
					{ icon: 'calendar', title: 'My company needs statutory filings or record updates.', text: 'Bring annual returns, registers and changes up to date.', link: { label: 'Corporate compliance', href: url('/services/corporate-compliance/') } },
					{ icon: 'register', title: 'We need a company secretary or governance support.', text: 'Dependable administration, meetings and governance documents.', link: { label: 'Company secretarial', href: url('/services/company-secretarial/') } },
					{ icon: 'restructure', title: 'We are changing ownership, directors or structure.', text: 'Plan the resolutions, records and filings a change requires.', link: { label: 'Corporate advisory', href: url('/services/corporate-advisory/') } },
				],
			},
			challenges: {
				eb: 'Common challenges',
				title: 'The questions that slow businesses down.',
				text: 'Most corporate issues are manageable when they are identified early. These are the challenges Kenyan businesses most often bring to us.',
				items: [
					'Choosing between a business name, a private company or another structure',
					'Not knowing whether annual returns and other filings are up to date',
					'Statutory registers and minutes that are incomplete or hard to find',
					'Missing a filing deadline after a change in directors or shareholders',
					'Unclear internal responsibility for corporate compliance',
					'Finding reliable, professional guidance you can trust',
				],
			},
			approach: {
				title: 'A practical approach, tailored to your business.',
				intro: 'We start by understanding your business and agree a scope that fits before work begins.',
				steps: [
					{ title: 'Initial review', text: 'We discuss your business, its current position and what you want to achieve.' },
					{ title: 'Tailored scope', text: 'We recommend the relevant services and agree a defined scope and terms.' },
					{ title: 'Documentation', text: 'We explain the information and documents needed and how to share them securely.' },
					{ title: 'Agreed process', text: 'We carry out the agreed work and explain your continuing obligations.' },
				],
			},
			services: {
				title: 'Services for Kenyan businesses.',
				intro: 'The services Kenyan founders, SMEs and established companies use most.',
				items: [
					svcCard('reg', 'Registering a business name or company on the right foundation.'),
					svcCard('comp', 'Annual returns, health checks and company changes.'),
					svcCard('sec', 'Ongoing administration, registers and meeting support.'),
					svcCard('adv', 'Share capital, ownership changes and restructuring.'),
					svcCard('gov', 'Board support and governance documents as you grow.'),
				],
			},
			trust: { title: 'Professional support you can understand.', text: 'Corporate matters are sensitive. We are clear about scope, responsibilities and how your information is handled.', items: trustCommon },
			faqs: [
				{ q: 'Which type of business entity should I consider?', a: 'It depends on factors such as ownership, liability, how you plan to raise finance and the formalities you are prepared to maintain. A business name registration suits some sole traders and partnerships, while a limited company provides a separate legal entity. We can talk through the options for your situation.' },
				{ q: 'Can SecPlus review my current compliance position?', a: 'Yes. A statutory health check reviews your records and filings and identifies any gaps, together with the steps needed to correct them.' },
				{ q: 'Do you offer ongoing company secretarial support?', a: 'Ongoing company secretarial support can be discussed and scoped to suit your company, from register maintenance to meeting support.' },
				{ q: 'What information should I prepare before contacting you?', a: 'A short description of your business and what you need is enough to start. If you already have a company, its name and registration details are helpful. Please do not send confidential documents until a secure process has been agreed.' },
				{ q: 'What happens after I make an enquiry?', a: 'We review your enquiry and contact you to discuss your needs and an appropriate next step. Where relevant, we will then send a proposal setting out scope and terms.' },
			],
			guides: ['registering-a-company-in-kenya', 'business-name-or-limited-company-in-kenya', 'company-annual-returns-in-kenya', 'corporate-compliance-checklist'],
			ctaTitle: 'Let’s talk about your business.',
			ctaText: 'Whether you are starting out or keeping an established company in order, tell us what you need and we will discuss the next step.',
		}),
	},
	{
		slug: 'international-investors',
		title: 'International Investors & Diaspora',
		meta: 'Support for diaspora founders, foreign investors and international companies establishing a company or corporate presence in Kenya.',
		content: audiencePage({
			audience: 'international-investor',
			icon: 'globe',
			eyebrow: 'For International Investors & Diaspora',
			h1: 'Your Business Ambitions in Kenya, Supported Locally.',
			lead: 'Exploring company establishment or a corporate presence in Kenya from abroad? SecPlus can discuss the relevant entity setup, statutory and corporate administration requirements.',
			cta: 'Discuss Your Kenyan Business Plans',
			secondary: { label: 'How We Work', href: url('/about/how-we-work/') },
			questions: [
				'Can I establish a Kenyan company while outside Kenya?',
				'Do I need to visit Kenya?',
				'What documents may be needed?',
				'What is the difference between a branch and a subsidiary?',
				'Which post-registration obligations apply?',
			],
			intro: {
				eb: 'Entering a new market',
				title: 'Entering a new market raises important questions.',
				paras: [
					'Unfamiliar rules, documentation requirements and coordination across time zones can make establishing a Kenyan presence feel uncertain, especially when you cannot easily be on the ground.',
					'SecPlus provides a local point of contact for the corporate side of your plans: the structure, the registration steps, the documents and the obligations that continue once your entity is established.',
				],
			},
			situations: {
				eb: 'Who this is for',
				title: 'International clients we support.',
				intro: 'Whether you are an individual founder or an established group, the corporate questions are similar.',
				items: [
					{ icon: 'user-check', title: 'Diaspora founders', text: 'Kenyans abroad starting or formalizing a business at home.' },
					{ icon: 'globe', title: 'Foreign entrepreneurs', text: 'Individuals considering Kenyan incorporation for a new venture.' },
					{ icon: 'building', title: 'International companies', text: 'Groups evaluating branches, subsidiaries or other structures.' },
					{ icon: 'handshake', title: 'Overseas advisers', text: 'Firms requiring local corporate support for their clients.', link: { label: 'Professional partners', href: url('/who-we-help/professional-partners/') } },
				],
			},
			challenges: {
				eb: 'What to consider',
				title: 'Key considerations before you begin.',
				text: 'Every plan is different. These are the areas that usually need attention. Some, such as tax, banking and immigration, may require other specialists, and we will tell you where that is the case.',
				items: [
					'The most suitable entity structure for your plans',
					'Your proposed activities and any sector licensing',
					'Ownership, including any local ownership requirements for your sector',
					'Required documentation, and whether it must be certified or notarized abroad',
					'Applicable approvals from relevant authorities',
					'Coordination with tax, banking and immigration advisers',
				],
			},
			approach: {
				title: 'Proposed engagement steps.',
				intro: 'A structured process that works across borders.',
				steps: [
					{ title: 'Enquiry', text: 'Tell us about your plans, your location and your preferred communication channel.' },
					{ title: 'Initial assessment', text: 'We discuss your objectives and the structures and requirements that may apply.' },
					{ title: 'Scope and proposal', text: 'You receive a proposal with defined scope, responsibilities and terms.' },
					{ title: 'Documentation', text: 'We confirm the documents required and agree a secure way to share them.' },
					{ title: 'Support and obligations', text: 'We carry out the agreed work and explain your continuing obligations.' },
				],
			},
			services: {
				title: 'Services for international clients.',
				intro: 'Support for establishing and maintaining a Kenyan entity.',
				items: [
					svcCard('reg', 'Kenyan company incorporation and foreign company registration.'),
					svcCard('sec', 'Local administration, registers and meeting support.'),
					svcCard('comp', 'Annual returns and changes for foreign-owned entities.'),
				],
			},
			trust: {
				eb: 'Trust across borders',
				title: 'Clear communication, wherever you are.',
				text: 'Working at a distance depends on trust. We agree communication arrangements, responsibilities and document handling at the start.',
				items: [
					{ icon: 'message', title: 'Agreed communication', text: 'Channels and update frequency agreed with you in advance.' },
					{ icon: 'lock', title: 'Privacy safeguards', text: 'Identity and corporate documents shared only through an agreed secure process.' },
					{ icon: 'file-check', title: 'Defined scope', text: 'A clear statement of what we do and what other advisers handle.' },
					{ icon: 'map-pin', title: 'Kenyan point of contact', text: 'Local support for the corporate side of your plans.' },
				],
			},
			faqs: [
				{ q: 'Can I enquire from outside Kenya?', a: 'Yes. You can enquire online from anywhere. We will discuss your plans and the most practical way to communicate and share documents.' },
				{ q: 'Can I establish a Kenyan company while outside Kenya?', a: 'In many cases, much of the company registration process can be coordinated remotely, although documents signed abroad may need to be certified or notarized. Whether this works for you depends on your structure and circumstances, which we can discuss.' },
				{ q: 'Do I need to visit Kenya?', a: 'Not always. Some steps, such as opening a bank account or obtaining certain approvals, may require in-person attendance or additional verification. We will explain what applies to your plans.' },
				{ q: 'Do I need a Kenyan address or representative?', a: 'Kenyan companies must have a registered office in Kenya, and foreign companies registering a branch must appoint a local authorized representative. Other requirements depend on your structure and sector.' },
				{ q: 'Can foreign shareholders own a Kenyan company?', a: 'Foreign ownership of Kenyan companies is generally permitted, but some sectors have local ownership requirements or licensing conditions. These should be checked for your proposed activity before you register.' },
				{ q: 'Will I need separate tax, immigration or banking advice?', a: 'Often, yes. These areas can require specialist advice. We will explain where other advisers are needed and coordinate within the agreed scope.' },
			],
			guides: ['registering-a-company-in-kenya-as-a-non-resident', 'branch-or-subsidiary-kenya', 'company-annual-returns-in-kenya', 'choosing-a-kenyan-corporate-services-partner'],
			ctaTitle: 'Discuss your Kenyan business plans.',
			ctaText: 'Wherever you are based, tell us what you are planning and we will discuss the structure, requirements and next steps.',
		}),
	},
	{
		slug: 'corporate-boards',
		title: 'Corporate Boards & Established Companies',
		meta: 'Company secretarial, board administration and governance advisory support for boards, executive teams and established companies in Kenya.',
		content: audiencePage({
			audience: 'corporate-board',
			icon: 'presentation',
			eyebrow: 'For Corporate Boards & Established Companies',
			h1: 'Stronger Governance Starts With Reliable Support.',
			lead: 'Support your directors and leadership teams with professional company secretarial, board administration and governance advisory services.',
			cta: 'Discuss Governance Support',
			secondary: { label: 'Governance Services', href: url('/services/corporate-governance/') },
			questions: [
				'What does an outsourced company secretary do?',
				'Can support be retained on an ongoing basis?',
				'What documents are needed for a governance review?',
			],
			intro: {
				eb: 'The challenge',
				title: 'Good governance requires more than good intentions.',
				paras: [
					'Board papers, records, meetings, decisions and oversight all need consistent attention. When processes are informal, decisions can be poorly recorded, actions can be lost and directors can be less certain of their responsibilities.',
					'Reliable secretarial and governance support gives your board the structure it needs to focus on strategy and oversight.',
				],
			},
			situations: {
				eb: 'Who we support',
				title: 'Supporting the people who govern.',
				intro: 'Governance support works alongside your board and internal teams.',
				items: [
					{ icon: 'presentation', title: 'Boards', text: 'Directors who want well-run meetings and reliable records.' },
					{ icon: 'briefcase', title: 'Executive teams', text: 'Leaders who need governance processes that support decisions.' },
					{ icon: 'shield-check', title: 'Legal and compliance functions', text: 'In-house teams that need specialist secretarial support.' },
					{ icon: 'register', title: 'Company administrators', text: 'Teams responsible for statutory records and filings.' },
				],
			},
			challenges: {
				eb: 'Relevant solutions',
				title: 'Support matched to your board’s needs.',
				text: 'Governance support is scoped to your organization. Board or governance reviews are offered where within SecPlus capacity and confirmed for your matter.',
				items: [
					'Company secretary and statutory administration',
					'Board meeting support and records',
					'Governance documents and advisory',
					'Board or governance reviews',
				],
			},
			approach: {
				title: 'A clear working relationship.',
				intro: 'We agree scope, governance calendar, responsibilities and reporting at the start.',
				steps: [
					{ title: 'Understand the board', text: 'We review your structure, constitution, current practice and priorities.' },
					{ title: 'Agree scope', text: 'We agree the services, responsibilities and terms of the engagement.' },
					{ title: 'Set the calendar', text: 'We map meetings, filings and governance activities across the year.' },
					{ title: 'Report and review', text: 'We provide agreed reporting and review the arrangement as needs change.' },
				],
			},
			services: {
				title: 'Services for boards and established companies.',
				intro: 'The services most relevant to boards and the teams that support them.',
				items: [
					svcCard('gov', 'Board meeting support, governance documents and reviews.'),
					svcCard('sec', 'Dependable company secretarial administration.'),
					svcCard('comp', 'Statutory filings, records and company changes.'),
				],
			},
			trust: {
				eb: 'Professional assurance',
				title: 'Discretion and continuity for your board.',
				text: 'Board matters are confidential. We agree how information is handled and who is responsible for each part of the work.',
				items: [
					{ icon: 'lock', title: 'Confidentiality', text: 'Board information handled through agreed, secure channels.' },
					{ icon: 'calendar', title: 'Governance calendar', text: 'Meetings and filings planned across the year.' },
					{ icon: 'file-check', title: 'Defined responsibilities', text: 'Clear allocation of tasks between SecPlus and your team.' },
					{ icon: 'refresh', title: 'Continuity', text: 'Consistent support as directors and officers change.' },
				],
			},
			faqs: [
				{ q: 'What does an outsourced company secretary do?', a: 'An outsourced company secretary maintains statutory registers, prepares filings, supports board and shareholder meetings, keeps minutes and resolutions, and helps directors follow proper procedure, as agreed in the engagement.' },
				{ q: 'Can support be retained on an ongoing basis?', a: 'Ongoing support can be discussed and is usually organized around your governance calendar. Scope, reporting and terms are agreed in advance.' },
				{ q: 'What documents are needed for a governance review?', a: 'Typically your constitution, board and committee structure, governance policies, recent board papers and minutes, and a short description of what prompted the review. We confirm the list when scoping.' },
				{ q: 'How are board meetings supported?', a: 'Support can include the annual meeting calendar, agendas and notices, collating board papers, attending meetings, drafting minutes and tracking actions.' },
			],
			guides: ['board-governance-checklist', 'when-does-a-kenyan-company-need-a-company-secretary'],
			ctaTitle: 'Discuss governance support for your board.',
			ctaText: 'Tell us about your board and current arrangements, and we will discuss how SecPlus could support it.',
		}),
	},
	{
		slug: 'professional-partners',
		title: 'Professional Referral Partners',
		meta: 'A Kenyan corporate services partner for legal, accounting and advisory firms supporting clients with Kenyan corporate secretarial and compliance matters.',
		content: audiencePage({
			audience: 'professional-partner',
			icon: 'handshake',
			eyebrow: 'For Professional Referral Partners',
			h1: 'A Kenyan Corporate Services Partner for Your Clients.',
			lead: 'For legal, accounting and advisory firms supporting clients with Kenyan corporate matters, SecPlus offers a local point of contact for discussing relevant secretarial and compliance requirements.',
			cta: 'Discuss a Client Referral',
			secondary: { label: 'Our Services', href: url('/services/') },
			questions: [
				'How are referrals handled?',
				'Can SecPlus coordinate with overseas advisers?',
				'How are confidentiality and conflicts managed?',
			],
			intro: {
				eb: 'The referral situation',
				title: 'Your client needs support in Kenya. You need a dependable local professional.',
				paras: [
					'When a client’s plans or existing entity involve Kenya, you need a local partner who understands corporate secretarial and compliance requirements, communicates clearly and respects your client relationship.',
					'SecPlus can act as that point of contact for matters within our confirmed service scope.',
				],
			},
			situations: {
				eb: 'Matters to refer',
				title: 'Matters you can refer.',
				intro: 'Within our confirmed service scope, referrals typically involve:',
				items: [
					{ icon: 'building', title: 'Incorporation', text: 'Kenyan company formation and foreign company registration.', link: { label: 'Company registration', href: url('/services/company-registration/') } },
					{ icon: 'calendar', title: 'Filings', text: 'Annual returns and statutory notifications for Kenyan entities.', link: { label: 'Corporate compliance', href: url('/services/corporate-compliance/') } },
					{ icon: 'register', title: 'Governance administration', text: 'Company secretarial and board administration.', link: { label: 'Company secretarial', href: url('/services/company-secretarial/') } },
					{ icon: 'restructure', title: 'Corporate changes', text: 'Share capital, ownership and structural changes.', link: { label: 'Corporate advisory', href: url('/services/corporate-advisory/') } },
				],
			},
			challenges: {
				eb: 'Working principles',
				title: 'How we work with referring firms.',
				text: 'Clear principles protect your client relationship and ensure everyone understands their role.',
				items: [
					'Confidentiality for you and your client',
					'Defined roles between your firm and SecPlus',
					'Conflict checks before we accept instructions',
					'Scope clarity in writing',
					'Regular communication on progress',
				],
			},
			approach: {
				title: 'How to refer a matter.',
				intro: 'Introduce the matter in outline first. Please do not send sensitive client data until secure instructions are agreed.',
				steps: [
					{ title: 'Introduce the matter', text: 'Share a short, non-sensitive outline of what your client needs.' },
					{ title: 'Conflict check and scope', text: 'We complete conflict checks and discuss scope, roles and terms.' },
					{ title: 'Secure instructions', text: 'We agree how instructions and documents will be shared.' },
					{ title: 'Delivery and updates', text: 'We carry out the agreed work and keep you updated as agreed.' },
				],
			},
			services: {
				title: 'Services available to referred clients.',
				intro: 'Referred matters are handled within our confirmed service scope.',
				items: [
					svcCard('reg', 'Incorporation and foreign company registration.'),
					svcCard('comp', 'Filings and statutory notifications.'),
					svcCard('sec', 'Company secretarial and board administration.'),
				],
			},
			trust: {
				eb: 'Credentials',
				title: 'A professional you can introduce with confidence.',
				text: 'We will share the professional qualifications and registrations of the people overseeing your client’s matter as part of our engagement discussions.',
				items: trustCommon,
			},
			faqs: [
				{ q: 'How are referrals handled?', a: 'Start with a short outline of the matter. We complete conflict checks, then discuss scope, roles and terms with you and, where appropriate, your client.' },
				{ q: 'Can SecPlus coordinate with overseas advisers?', a: 'Yes. Coordination arrangements, communication channels and responsibilities are agreed at the start of each matter.' },
				{ q: 'How are confidentiality and conflicts managed?', a: 'We carry out conflict checks before accepting instructions and agree how confidential information will be shared and stored. Please do not send sensitive client data until this has been agreed.' },
			],
			guides: ['choosing-a-kenyan-corporate-services-partner', 'branch-or-subsidiary-kenya'],
			ctaTitle: 'Discuss a client referral.',
			ctaText: 'Introduce the matter in outline and we will discuss scope, roles and the next step.',
		}),
	},
];

export const audiencesHub = () =>
	[
		pageHero({
			eb: 'Who We Help',
			photo: photo('who-we-help'),
			title: 'Corporate Support Shaped Around Your Situation.',
			text: 'SecPlus works with Kenyan businesses, international investors, corporate boards and professional advisers. Choose the path that best describes you.',
			primary: { label: 'Request a Consultation', href: url('/contact/#enquiry') },
			secondary: { label: 'Explore Our Services', href: url('/services/') },
		}),
		section('sp-audience-hub', [
			cardGrid(
				[
					{ icon: 'chart', title: 'Kenyan Businesses', text: 'Founders, growing SMEs and established companies building on the right foundation, from first registration to everyday corporate responsibilities.', link: { label: 'Support for Kenyan businesses', href: url('/who-we-help/kenyan-businesses/') } },
					{ icon: 'globe', title: 'International Investors & Diaspora', text: 'Diaspora founders, foreign entrepreneurs and international companies establishing a company or presence in Kenya.', link: { label: 'Support for international clients', href: url('/who-we-help/international-investors/') } },
					{ icon: 'presentation', title: 'Corporate Boards & Established Companies', text: 'Boards, executive teams and company administrators who need reliable secretarial and governance support.', link: { label: 'Support for boards', href: url('/who-we-help/corporate-boards/') } },
					{ icon: 'handshake', title: 'Professional Referral Partners', text: 'Legal, accounting and advisory firms needing a Kenyan point of contact for client corporate matters.', link: { label: 'Support for professional partners', href: url('/who-we-help/professional-partners/') } },
				],
				'16rem',
				'sp-card-grid sp-card-grid--2'
			),
		]),
		section('sp-section--mist', [
			sectionHead({ eb: 'Or start with your need', title: 'What brings you to SecPlus?', intro: 'Each need leads to a dedicated service page with guidance for Kenyan and international clients.', c: 'is-centered' }),
			cardGrid(
				[
					{ icon: 'building', title: 'Establish a Business', text: 'Company formation, registration and entity setup.', link: { label: 'Company registration', href: url('/services/company-registration/') } },
					{ icon: 'shield-check', title: 'Maintain Compliance', text: 'Statutory filings, annual returns and corporate administration.', link: { label: 'Compliance services', href: url('/services/corporate-compliance/') } },
					{ icon: 'landmark', title: 'Strengthen Governance', text: 'Company secretarial, board administration and governance support.', link: { label: 'Governance support', href: url('/services/corporate-governance/') } },
					{ icon: 'restructure', title: 'Navigate Corporate Changes', text: 'Restructuring, share capital and specialist advisory.', link: { label: 'Corporate advisory', href: url('/services/corporate-advisory/') } },
				],
				'14rem',
				'sp-card-grid sp-card-grid--4'
			),
			internationalBanner(),
		]),
		ctaBand({
			title: 'Not sure where you fit?',
			text: 'Tell us about your organization and what you need. We will point you to the right support.',
			primary: { label: 'Request a Consultation', href: url('/contact/#enquiry') },
			secondary: { label: 'Learn How We Work', href: url('/about/how-we-work/') },
		}),
	].join('\n\n');
