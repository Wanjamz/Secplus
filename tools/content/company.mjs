// About, How We Work, People, Client Experiences, FAQs, Insights hub, Contact and legal pages.
import {
	url, group, flow, grid, row, columns, h, p, eyebrow, lead, buttons, icon, section, sectionHead,
	cardGrid, steps, faqList, ctaBand, pageHero, split, checklist, list, contactDetails, enquiryForm,
	topicCards, breadcrumbs, latestPosts, arrowLink, image, img,
} from '../lib/blocks.mjs';
import { whyItems } from './home.mjs';
import { photo } from './photos.mjs';

const pending = (text) => p(`<strong>Pending Client Confirmation:</strong> ${text}`, 'sp-pending');

/* ---------------- About ---------------- */

export const aboutPage = () =>
	[
		pageHero({
			eb: 'About SecPlus',
			photo: photo('about'),
			title: 'Professional Corporate Support, Built Around Your Business.',
			text: 'SecPlus Consulting supports businesses with corporate secretarial, compliance, governance and advisory requirements in Kenya.',
			primary: { label: 'Meet With Our Team', href: url('/contact/#enquiry') },
			secondary: { label: 'Our Services', href: url('/services/') },
			asideTitle: 'SecPlus at a glance',
			asideIcon: 'award',
			asideItems: [
				'Corporate secretarial, compliance and governance consultancy',
				'Certified Secretaries (Kenya)',
				'Supporting Kenyan and international clients',
				'From company formation to ongoing governance',
			],
		}),
		split({
			eb: 'Who we are',
			title: 'A specialist partner for your corporate responsibilities.',
			paras: [
				'SecPlus Consulting is a Kenyan consultancy specializing in corporate secretarial, compliance and governance services. We support organizations with the corporate requirements that come with establishing, operating and governing an entity in Kenya, from company formation and statutory filings to board administration and corporate change.',
				'We work with Kenyan founders, SMEs and established companies, as well as international investors and professional advisers who need a dependable Kenyan partner. Our role is to make corporate requirements understandable and manageable, so our clients can focus on running their organizations.',
			],
		}),
		section('sp-section--mist sp-values', [
			sectionHead({ eb: 'What we believe', title: 'The principles behind our work.', intro: 'Corporate matters are often sensitive and always important. These principles guide how we work with every client.', c: 'is-centered' }),
			cardGrid(
				[
					{ icon: 'compass', title: 'Clarity', text: 'We explain requirements in plain language and define technical terms, so you understand what applies and why.' },
					{ icon: 'scale', title: 'Integrity', text: 'We give honest guidance about what is required, what we can help with and where other advisers are needed.' },
					{ icon: 'clock', title: 'Responsiveness', text: 'We communicate clearly about progress and next steps throughout an engagement.' },
					{ icon: 'lock', title: 'Confidentiality', text: 'We treat corporate and personal information with care and agree secure channels for sensitive documents.' },
					{ icon: 'award', title: 'Professional responsibility', text: 'We take ownership of the work we agree to deliver and the standards it must meet.' },
				],
				'13rem',
				'sp-card-grid sp-card-grid--5'
			),
		]),
		section('sp-expertise', [
			columns({ cls: 'sp-expertise__cols' }, [
				{
					width: '45%',
					inner: [
						eyebrow('Expertise'),
						h(2, 'Focused on the requirements that keep organizations in order.'),
						p('Our work spans the corporate lifecycle. When you engage SecPlus, we introduce the professional responsible for your matter and explain their role, so you always know who is overseeing your work.'),
						arrowLink('Learn how we work', url('/about/how-we-work/')),
					],
				},
				{
					width: '55%',
					inner: [
						grid('sp-mini-grid', '14rem', [
							flow('sp-mini-card', [icon('building', 'tint', 'sm'), h(3, 'Company registration'), p('Business names, companies and foreign company registration.')]),
							flow('sp-mini-card', [icon('shield-check', 'tint', 'sm'), h(3, 'Statutory compliance'), p('Annual returns, records, health checks and company changes.')]),
							flow('sp-mini-card', [icon('register', 'tint', 'sm'), h(3, 'Company secretarial'), p('Registers, resolutions, meetings and corporate administration.')]),
							flow('sp-mini-card', [icon('landmark', 'tint', 'sm'), h(3, 'Corporate governance'), p('Board support, governance documents and reviews.')]),
							flow('sp-mini-card', [icon('restructure', 'tint', 'sm'), h(3, 'Corporate advisory'), p('Share capital, restructuring and corporate change.')]),
							flow('sp-mini-card', [icon('globe', 'tint', 'sm'), h(3, 'International clients'), p('A Kenyan partner for investors and overseas advisers.')]),
						]),
					],
				},
			]),
		]),
		section('sp-section--navy', [
			sectionHead({ eb: 'Our approach', title: 'How we support every engagement.', intro: 'A consistent approach, whatever the size of the assignment.' }),
			steps(
				[
					{ title: 'Understand the need', text: 'We listen to your situation and objectives before recommending anything.' },
					{ title: 'Define the scope', text: 'We agree what will be done, by whom and on what terms.' },
					{ title: 'Explain requirements', text: 'We clarify the documents, approvals and filings involved.' },
					{ title: 'Deliver agreed services', text: 'We carry out the agreed work and keep you informed.' },
					{ title: 'Support ongoing responsibilities', text: 'We explain what continues and support it where you need us.' },
				],
				'sp-steps sp-steps--5'
			),
		]),
		section('sp-why-light', [
			sectionHead({ eb: 'Why clients choose SecPlus', title: 'Professional guidance grounded in your business needs.', c: 'is-centered' }),
			grid('sp-why__grid sp-why__grid--light', '16rem', whyItems().map((w) => flow('sp-why-item', [icon(w.icon, 'tint', 'sm'), h(3, w.title), p(w.text)]))),
		]),
		section('sp-section--mist sp-location', [
			columns({ cls: 'sp-location__cols', valign: 'center' }, [
				{ width: '45%', inner: [eyebrow('Location and contact'), h(2, 'Based in Kenya, available to clients locally and abroad.'), p('Kenyan and international clients can reach us using the details here or by sending an enquiry online.'), buttons([{ label: 'Contact SecPlus', href: url('/contact/') }])] },
				{ width: '55%', inner: [contactDetails('card')] },
			]),
		]),
		ctaBand({
			title: 'Meet with our team.',
			text: 'Tell us about your organization and what you need, and we will arrange a conversation about the next step.',
			primary: { label: 'Meet With Our Team', href: url('/contact/#enquiry') },
			secondary: { label: 'Explore Our Services', href: url('/services/') },
		}),
	].join('\n\n');

/* ---------------- How We Work ---------------- */

export const howWeWorkPage = () =>
	[
		pageHero({
			eb: 'How We Work',
			photo: photo('how-we-work'),
			title: 'A Clear Process From First Enquiry to Ongoing Support.',
			text: 'Know what to expect when discussing corporate requirements with SecPlus.',
			primary: { label: 'Start an Enquiry', href: url('/contact/#enquiry') },
			secondary: { label: 'Our Services', href: url('/services/') },
			asideItems: ['What information is needed initially?', 'Will I receive a proposal?', 'How are confidential documents handled?'],
			asideIcon: 'compass',
		}),
		section('sp-timeline-section', [
			sectionHead({ eb: 'Five clear stages', title: 'What happens at each step.', c: 'is-centered' }),
			flow('sp-timeline', [
				...[
					['message', 'First contact', 'Submit a concise description of your company and requirement using our enquiry form. You do not need to send documents at this stage, and please do not send confidential identity or corporate documents through the form.'],
					['users', 'Initial discussion', 'SecPlus clarifies the scope, urgency, documents and the appropriate service. This is your opportunity to ask questions and understand the options that may apply.'],
					['file-check', 'Proposal', 'You receive a defined scope, assumptions, deliverables and commercial terms, so you know exactly what is included before you decide to proceed.'],
					['lock', 'Engagement', 'Once you accept the proposal, we agree instructions and you provide documents through an appropriate secure channel.'],
					['refresh', 'Delivery and follow-up', 'You receive progress communication, the agreed outputs and an explanation of your continuing responsibilities. Ongoing support can be agreed where it is useful.'],
				].map(([ic, title, text], i) =>
					flow('sp-timeline__item', [p(String(i + 1).padStart(2, '0'), 'sp-step__num'), icon(ic, 'tint'), flow('sp-timeline__body', [h(3, title), p(text)])])
				),
			]),
		]),
		section('sp-section--mist', [
			columns({ cls: 'sp-prepare__cols' }, [
				{
					width: '50%',
					inner: [eyebrow('Getting started'), h(2, 'What we need to begin.'), p('A short description is enough for your first enquiry. It helps to include:'), checklist(['Your organization’s name, or your plans if it is not yet registered', 'Where you and the organization are based', 'The service or requirement you need help with', 'Any deadline you are working towards', 'How you prefer to be contacted'])],
				},
				{
					width: '50%',
					inner: [flow('is-style-card sp-card sp-reassure', [icon('lock', 'dark'), h(3, 'Handling confidential documents'), p('Identity documents, registers and other corporate records are sensitive. We request them only after an engagement is agreed, and only through a secure channel agreed with you.'), p('Information you provide is handled in line with our <a href="' + url('/privacy-policy/') + '">Privacy Policy</a>.')])],
				},
			]),
		]),
		section('sp-faqs', [
			columns({ cls: 'sp-faqs__cols' }, [
				{ width: '36%', inner: [eyebrow('Frequently asked questions'), h(2, 'Working with SecPlus.'), arrowLink('View all FAQs', url('/faqs/'))] },
				{
					width: '64%',
					inner: [
						faqList([
							{ q: 'What information is needed initially?', a: 'A brief description of your organization and what you need. We may ask follow-up questions during our initial discussion.' },
							{ q: 'Will I receive a proposal?', a: 'Yes. Where we can help, you will receive a proposal setting out the scope, assumptions, deliverables and commercial terms before any work begins.' },
							{ q: 'How are confidential documents handled?', a: 'We request confidential documents only after an engagement is agreed, through an appropriate secure channel. Please do not send them through the website enquiry form.' },
							{ q: 'How will I know who is responsible for my matter?', a: 'We introduce the professional responsible for your matter at the start of the engagement and explain how to reach them.' },
						]),
					],
				},
			]),
		]),
		ctaBand({
			title: 'Start an enquiry.',
			text: 'Tell us what you need and we will contact you about the appropriate next step.',
			primary: { label: 'Start an Enquiry', href: url('/contact/#enquiry') },
			secondary: { label: 'Explore Our Services', href: url('/services/') },
		}),
	].join('\n\n');

/* ---------------- People (draft until profiles are approved) ---------------- */

export const peoplePage = () =>
	[
		pageHero({
			eb: 'Our People & Credentials',
			title: 'Meet the Professionals Behind SecPlus.',
			text: 'Corporate decisions deserve support from people whose expertise and responsibilities you can understand.',
			primary: { label: 'Discuss Your Requirements', href: url('/contact/#enquiry') },
		}),
		section('', [
			sectionHead({ eb: 'Our team', title: 'Expertise and professional oversight.' }),
			pending('Describe the types of expertise available at SecPlus and how professional oversight works. Confirm wording with the SecPlus owner.'),
			pending('Add verified team profiles below. Each profile needs: full name; title; professional qualifications; registrations and memberships; years of relevant experience (only if verified); areas of expertise; a short professional statement; and written consent to publish.'),
			grid('sp-card-grid sp-card-grid--3', '16rem', [
				flow('is-style-card sp-card sp-profile', [icon('user-check'), h(3, 'Name (pending)'), p('Title (pending)', 'sp-tag'), p('Qualifications, registrations and areas of expertise to be confirmed.')]),
			]),
		]),
		section('sp-section--mist', [
			sectionHead({ eb: 'Professional standards', title: 'How we maintain quality.' }),
			pending('Describe confidentiality, review and quality assurance practices only if they are actually used.'),
		]),
		ctaBand({
			title: 'Discuss which professional would oversee your matter.',
			text: 'Tell us what you need and we will introduce the right person.',
			primary: { label: 'Discuss Your Requirements', href: url('/contact/#enquiry') },
		}),
	].join('\n\n');

/* ---------------- Client experiences (draft until consent) ---------------- */

export const caseStudiesPage = () =>
	[
		pageHero({
			eb: 'Client Experiences',
			title: 'How Businesses Have Worked Through Corporate Challenges.',
			text: 'Illustrative assignments can help clients understand the types of issues SecPlus supports and the approach taken.',
			primary: { label: 'Discuss a Similar Requirement', href: url('/contact/#enquiry') },
		}),
		section('', [
			sectionHead({ eb: 'Case-study format', title: 'Context, challenge, approach and outcome.' }),
			pending('Publish only approved, anonymized case studies or those with explicit client permission. Format: client context, challenge, scope, work undertaken, verifiable outcome, lessons.'),
			pending('Suggested cases: new Kenyan company registration; foreign investor entry; statutory compliance clean-up; board governance support.'),
			pending('Testimonials: use verbatim approved client statements only, with client identity shown only with permission.'),
		]),
		ctaBand({
			title: 'Facing a similar requirement?',
			text: 'Tell us about your situation and we will discuss how we could help.',
			primary: { label: 'Discuss a Similar Requirement', href: url('/contact/#enquiry') },
		}),
	].join('\n\n');

/* ---------------- FAQs ---------------- */

const faqGroups = () => [
	{
		id: 'registration', icon: 'building', title: 'Company registration',
		items: [
			{ q: 'What entity types can SecPlus help establish?', a: 'SecPlus can discuss business name registration, private and public companies, companies limited by guarantee and foreign company registration, as well as entity conversions.' },
			{ q: 'What documents should I prepare?', a: 'Usually identification and contact details for proposed directors and shareholders, proposed names, intended activities and a registered office address. Additional documents may apply to foreign or corporate shareholders. We confirm the exact list for your situation.' },
			{ q: 'What determines the cost and timeline?', a: 'The entity type, the number and location of directors and shareholders, how quickly documents are available and the processing times of the relevant authorities. Your proposal will explain what applies.' },
			{ q: 'What obligations continue after registration?', a: 'Companies must maintain statutory registers, file annual returns, keep beneficial ownership information current and notify certain changes. Tax and licensing obligations may also apply.' },
		],
	},
	{
		id: 'international', icon: 'globe', title: 'International clients',
		items: [
			{ q: 'Can I enquire from outside Kenya?', a: 'Yes. You can enquire online from anywhere, and we will agree a practical way to communicate and share documents.' },
			{ q: 'Do I need a Kenyan address or representative?', a: 'Kenyan companies must have a registered office in Kenya, and a foreign company registering a branch must appoint a local authorized representative. Other requirements depend on your structure and sector.' },
			{ q: 'Can foreign shareholders own a Kenyan company?', a: 'Foreign ownership is generally permitted, but some sectors have local ownership requirements or licensing conditions that should be checked for your proposed activity.' },
			{ q: 'Will I need separate tax, immigration or banking advice?', a: 'Often, yes. We explain where specialist advisers are needed and coordinate within the agreed scope.' },
		],
	},
	{
		id: 'compliance', icon: 'shield-check', title: 'Compliance',
		items: [
			{ q: 'How can I check whether my company is up to date?', a: 'A statutory health check compares your records and registers with your filings and identifies anything outstanding.' },
			{ q: 'What records should my company maintain?', a: 'Kenyan companies are generally required to keep statutory registers, such as registers of members, directors and beneficial owners, together with minutes and resolutions.' },
			{ q: 'Can overdue filings be reviewed?', a: 'Yes. We can review your position, explain the steps to bring filings up to date and discuss any penalties that may apply.' },
			{ q: 'Can I request ongoing support?', a: 'Ongoing compliance and company secretarial support can be discussed and scoped to suit your organization.' },
		],
	},
	{
		id: 'governance', icon: 'landmark', title: 'Governance',
		items: [
			{ q: 'What does a company secretary do?', a: 'A company secretary maintains statutory registers, prepares filings, supports board and shareholder meetings, keeps minutes and resolutions, and helps directors follow proper procedure.' },
			{ q: 'What is involved in board meeting support?', a: 'Planning the annual calendar, preparing agendas and notices, collating board papers, attending meetings, drafting minutes and tracking actions.' },
			{ q: 'How do governance reviews work?', a: 'We agree the scope, review your structures, policies, processes and records, and report our observations and suggested improvements.' },
			{ q: 'Can SecPlus help prepare governance documents?', a: 'Yes. We can discuss board charters, committee terms of reference, conflict of interest policies and other governance documents.' },
		],
	},
	{
		id: 'working-with-secplus', icon: 'handshake', title: 'Working with SecPlus',
		items: [
			{ q: 'How do I request a proposal?', a: 'Send an enquiry describing your organization and what you need. After an initial discussion, we will send a proposal where we can help.' },
			{ q: 'What happens after my enquiry?', a: 'Our team reviews the information and contacts you about the appropriate next step.' },
			{ q: 'How is confidential information handled?', a: 'Confidential documents are requested only after an engagement is agreed, through a secure channel. Please do not send them through the website form.' },
			{ q: 'How will I know who is responsible for my matter?', a: 'We introduce the professional responsible for your matter at the start of the engagement.' },
		],
	},
];

export const faqPage = () =>
	[
		pageHero({
			eb: 'Frequently Asked Questions',
			photo: photo('faqs'),
			title: 'Answers to Common Corporate Questions.',
			text: 'General information about company registration, compliance, governance and working with SecPlus. The right approach always depends on your entity and circumstances.',
			primary: { label: 'Ask Us a Question', href: url('/contact/#enquiry') },
			secondary: { label: 'Insights & Resources', href: url('/insights/') },
		}),
		section('sp-faq-page', [
			columns({ cls: 'sp-faq-page__cols' }, [
				{
					width: '28%',
					cls: 'sp-faq-nav-col',
					inner: [flow('sp-faq-nav', [p('Topics', 'sp-tag'), list(faqGroups().map((g) => `<a href="#${g.id}">${g.title}</a>`), 'sp-faq-nav__list')])],
				},
				{
					width: '72%',
					inner: faqGroups().map((g) => group({ cls: 'sp-faq-group', id: g.id, layout: { type: 'default' } }, [row('sp-faq-group__head', [icon(g.icon, 'tint', 'sm'), h(2, g.title)]), faqList(g.items)])),
				},
			]),
			p('This information is general and does not constitute legal advice. Requirements can change; please contact us to discuss your specific circumstances.', 'sp-note'),
		]),
		ctaBand({
			title: 'Have a question we haven’t answered?',
			text: 'Tell us about your situation and we will be happy to help.',
			primary: { label: 'Discuss Your Requirements', href: url('/contact/#enquiry') },
		}),
	].join('\n\n');

/* ---------------- Insights hub ---------------- */

export const insightsPage = () =>
	[
		pageHero({
			eb: 'Insights & Resources',
			photo: photo('insights'),
			title: 'Clear Answers to Important Corporate Questions.',
			text: 'Explore practical guides on establishing companies, meeting statutory obligations and strengthening governance in Kenya.',
			primary: { label: 'Explore Our Services', href: url('/services/') },
			secondary: { label: 'Frequently Asked Questions', href: url('/faqs/') },
		}),
		section('sp-topics-section', [sectionHead({ eb: 'Browse by topic', title: 'Guides for every stage.' }), topicCards()]),
		section('sp-section--mist sp-insights', [
			sectionHead({ eb: 'Latest guides', title: 'Recently published.' }),
			[
				`<!-- wp:query {"queryId":2,"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"sp-latest"} -->`,
				`<div class="wp-block-query sp-latest">`,
				`<!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->`,
				flow('sp-post-card', [
					`<!-- wp:post-terms {"term":"category","className":"sp-post-card__cat"} /-->`,
					`<!-- wp:post-title {"level":3,"isLink":true,"className":"sp-post-card__title"} /-->`,
					`<!-- wp:post-excerpt {"excerptLength":24,"className":"sp-post-card__excerpt"} /-->`,
					`<!-- wp:read-more {"content":"Read the guide","className":"sp-post-card__more"} /-->`,
				]),
				`<!-- /wp:post-template -->`,
				`<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->`,
				`<!-- wp:query-pagination-previous /-->`,
				`<!-- wp:query-pagination-numbers /-->`,
				`<!-- wp:query-pagination-next /-->`,
				`<!-- /wp:query-pagination -->`,
				`<!-- wp:query-no-results -->`,
				p(`New practical guides are being prepared and professionally reviewed. In the meantime, <a href="${url('/faqs/')}">read our FAQs</a> or <a href="${url('/contact/')}">ask us a question directly</a>.`, 'sp-empty-note'),
				`<!-- /wp:query-no-results -->`,
				`</div>`,
				`<!-- /wp:query -->`,
			].join('\n'),
		]),
		split({
			eb: 'Editorial standards',
			title: 'How we prepare our guides.',
			paras: [
				'Each guide answers a specific question in plain language, distinguishes legal requirements from general guidance and points to official Kenyan sources where you can verify the position.',
				'Guides are reviewed by a qualified professional before publication and show when they were last reviewed. Requirements change, so guides are general information rather than legal advice for your circumstances.',
			],
		}),
		ctaBand({
			title: 'Need guidance on your situation?',
			text: 'Our guides explain the general position. For advice on your organization, speak to SecPlus.',
			primary: { label: 'Explore Our Services', href: url('/services/') },
			secondary: { label: 'Request a Consultation', href: url('/contact/#enquiry') },
		}),
	].join('\n\n');

/* ---------------- Contact ---------------- */

export const contactPage = () =>
	[
		group({ tag: 'section', align: 'full', cls: 'sp-contact-hero has-photo' }, [
			image(img(photo('contact').file), photo('contact').alt, 'sp-page-hero__photo sp-contact-hero__photo'),
			columns({ cls: 'sp-contact__cols' }, [
				{
					width: '42%',
					cls: 'sp-contact__intro',
					inner: [
						breadcrumbs(),
						eyebrow('Request a Consultation'),
						h(1, 'Let’s Discuss What Your Business Needs.'),
						lead('Whether your organization is new, established or navigating change, in Kenya or abroad, tell us what support you need and we will discuss an appropriate next step.'),
						flow('sp-next-steps', [
							h(2, 'What happens next', 'sp-next-steps__title'),
							list(
								[
									'<strong>We review your enquiry</strong> and the support you have asked about.',
									'<strong>We contact you</strong> to discuss your needs and clarify the scope.',
									'<strong>You receive a proposal</strong> setting out scope and terms, where we can help.',
								],
								'sp-numbered',
								true
							),
						]),
						contactDetails('stack'),
					],
				},
				{
					width: '58%',
					inner: [
						group({ cls: 'sp-form-card', id: 'enquiry', layout: { type: 'default' } }, [
							h(2, 'Send us an enquiry', 'sp-form-card__title'),
							p('Fields marked * are required. Please do not include confidential identity or corporate documents; we will agree a secure process if they are needed.', 'sp-form-card__intro'),
							enquiryForm(),
						]),
					],
				},
			]),
		]),
		section('sp-section--mist sp-faqs', [
			columns({ cls: 'sp-faqs__cols' }, [
				{ width: '36%', inner: [eyebrow('Before you enquire'), h(2, 'Working with SecPlus.'), arrowLink('Learn how we work', url('/about/how-we-work/'))] },
				{
					width: '64%',
					inner: [
						faqList([
							{ q: 'Can I enquire from outside Kenya?', a: 'Yes. Kenyan and international clients can enquire online. Let us know your location and preferred contact method.' },
							{ q: 'What happens after my enquiry?', a: 'Our team reviews the information and contacts you about the appropriate next step.' },
							{ q: 'How do I request a proposal?', a: 'Describe what you need in the form. After an initial discussion, we will send a proposal where we can help.' },
							{ q: 'How is confidential information handled?', a: 'Please do not send confidential documents through this form. If documents are needed, we will agree a secure channel. See our Privacy Policy for how enquiry information is used.' },
						]),
					],
				},
			]),
		]),
	].join('\n\n');

/* ---------------- Legal ---------------- */

export const privacyPage = () =>
	[
		p('This Privacy Policy explains how SecPlus Consulting (“SecPlus”, “we”, “us”) collects, uses and protects personal data when you use this website or contact us. We are committed to handling personal data in accordance with the Data Protection Act, 2019 of Kenya and its regulations.', 'is-style-lead'),
		h(2, 'Who we are'),
		p(`SecPlus Consulting is a corporate secretarial, compliance and governance consultancy based in Kenya. For any privacy question or request, contact us using the details on our <a href="${url('/contact/')}">Contact page</a>.`),
		h(2, 'Personal data we collect'),
		list([
			'<strong>Enquiry information</strong> you submit through our forms: your name, email address, telephone number (optional), organization, location, the type of support you are interested in and your message.',
			'<strong>Correspondence</strong> you send to us by email or telephone.',
			'<strong>Technical information</strong> needed to operate and secure the website, such as server logs that may include your IP address and browser type.',
		]),
		p('Please do not send confidential identity documents or corporate records through the website. If such documents are needed for an engagement, we will agree a secure process with you.'),
		h(2, 'Chat assistant'),
		p('The chat assistant on this website runs in your browser and answers general questions from information we have prepared. We do not store what you type into it. If you choose to continue a conversation on WhatsApp, WhatsApp’s own terms and privacy policy apply to that conversation, and we handle the information you send us there as described in this policy.'),
		h(2, 'How we use personal data'),
		list([
			'To respond to your enquiry and discuss your requirements',
			'To prepare proposals and, where you engage us, to deliver the agreed services',
			'To keep appropriate records of our communications',
			'To protect the website against spam, misuse and security threats',
			'To meet our legal and regulatory obligations',
		]),
		h(2, 'Lawful basis'),
		p('We process personal data on the basis of your consent (for example, when you submit an enquiry), to take steps at your request before entering into a contract, for our legitimate interests in operating and protecting our business, and where required by law.'),
		h(2, 'Sharing personal data'),
		p('We do not sell personal data. We share it only where necessary: with service providers who host or support our website and email systems, with professional advisers or authorities where required to deliver a service you have engaged us for, or where the law requires us to do so. Where personal data is transferred outside Kenya, we take steps to ensure appropriate safeguards are in place as required by the Data Protection Act, 2019.'),
		h(2, 'How long we keep personal data'),
		p('We keep enquiry information only for as long as needed to respond to you and for a reasonable period afterwards for record-keeping. Information relating to client engagements is retained for the periods required by law and professional obligations.'),
		h(2, 'Your rights'),
		p('Subject to the Data Protection Act, 2019, you have the right to be informed about the use of your personal data, to access it, to object to its processing, to request correction or deletion of false or misleading data, and to withdraw consent where processing is based on consent. To exercise these rights, contact us. You may also lodge a complaint with the Office of the Data Protection Commissioner.'),
		h(2, 'Security'),
		p('We use appropriate technical and organizational measures to protect personal data against loss, misuse and unauthorized access. No internet transmission is completely secure, which is why we ask you not to send confidential documents through the website.'),
		h(2, 'Cookies'),
		p(`Information about cookies is set out in our <a href="${url('/cookie-notice/')}">Cookie Notice</a>.`),
		h(2, 'Changes to this policy'),
		p('We may update this Privacy Policy from time to time. The current version will always be available on this page.'),
	].join('\n\n');

export const termsPage = () =>
	[
		p('These Terms of Use govern your use of the SecPlus Consulting website. By using the website, you agree to these terms.', 'is-style-lead'),
		h(2, 'Information only, not professional advice'),
		p('Content on this website, including guides, FAQs and articles, is general information about corporate secretarial, compliance and governance matters in Kenya. It is not legal, tax or professional advice for your circumstances and should not be relied on as such. Requirements change, and the right approach depends on your entity and circumstances. Please contact us to discuss your specific situation.'),
		h(2, 'No client relationship'),
		p('Using this website or sending an enquiry does not create a client relationship with SecPlus. A client relationship begins only when we have agreed a written scope of work and terms with you.'),
		h(2, 'Accuracy of information'),
		p('We take care to keep website content accurate and up to date, and our guides show when they were last reviewed. However, we do not warrant that all information is complete, current or free from error.'),
		h(2, 'Intellectual property'),
		p('The SecPlus name, logo and the content of this website are owned by or licensed to SecPlus Consulting. You may view and print content for personal or internal business use, but you may not reproduce, distribute or modify it for commercial purposes without our written permission.'),
		h(2, 'Acceptable use'),
		p('You must not use the website in a way that is unlawful, that could damage or impair the website, or that involves sending unsolicited communications, malicious code or false information through our forms.'),
		h(2, 'Links to other websites'),
		p('The website links to official and third-party sources for your convenience. We are not responsible for the content or availability of those websites.'),
		h(2, 'Limitation of liability'),
		p('To the extent permitted by law, SecPlus is not liable for any loss arising from reliance on general information published on this website. Nothing in these terms limits any liability that cannot be excluded by law.'),
		h(2, 'Governing law'),
		p('These terms are governed by the laws of Kenya, and the courts of Kenya have jurisdiction over any dispute arising from them.'),
		h(2, 'Changes to these terms'),
		p(`We may update these terms from time to time. Questions about these terms can be sent to us through our <a href="${url('/contact/')}">Contact page</a>.`),
	].join('\n\n');

export const cookiePage = () =>
	[
		p('This Cookie Notice explains how this website uses cookies and similar technologies.', 'is-style-lead'),
		h(2, 'What are cookies?'),
		p('Cookies are small text files stored on your device when you visit a website. They help websites function and can remember information about your visit.'),
		h(2, 'Cookies we use'),
		p('This website is built to work without advertising or tracking cookies. We use only cookies that are strictly necessary for the website to operate:'),
		list([
			'<strong>WordPress session and security cookies</strong>, set only for website administrators and editors who log in to manage the site.',
			'<strong>Comment and preference cookies</strong> are not used, because comments are not enabled on this website.',
		]),
		p('If we introduce analytics or other non-essential cookies in future, we will update this notice and, where required, ask for your consent before setting them.'),
		h(2, 'Managing cookies'),
		p('You can control and delete cookies through your browser settings. Blocking strictly necessary cookies may affect how parts of the website work for logged-in users.'),
		h(2, 'More information'),
		p(`For more about how we handle personal data, see our <a href="${url('/privacy-policy/')}">Privacy Policy</a>.`),
	].join('\n\n');
