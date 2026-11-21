<?php
/**
 * Starter answers for the SecPlus chat assistant. Imported once as editable
 * "Chat answers" in WordPress admin (SecPlus → Chat answers).
 *
 * Tone: warm, plain English, honest about what depends on circumstances.
 * No prices, timelines, credentials or guarantees are promised.
 *
 * Each entry: title (the visitor's question), quick (show as a starter topic),
 * keywords (comma-separated), service (enquiry form preselect), link (path + label), answer
 * (blank lines start a new chat bubble).
 *
 * @package SecPlusCore
 */

defined( 'ABSPATH' ) || exit;

return array(
	array(
		'title'    => 'I want to register a company',
		'quick'    => true,
		'keywords' => 'register, registration, incorporate, incorporation, start a company, new company, start a business, set up, setup, form a company, open a company, limited company',
		'service'  => 'company-registration',
		'link'     => array( '/services/company-registration/', 'Company registration' ),
		'answer'   => "That's exciting, congratulations on taking the step!\n\nIn Kenya most founders choose between registering a business name and incorporating a private limited company. The right one depends on things like who will own it, how much personal risk you're comfortable with and whether you plan to bring in investors.\n\nWe can talk you through the options, the documents you'll need and what happens after registration. Would you like to chat with one of our advisers?",
	),
	array(
		'title'    => 'Business name or limited company?',
		'quick'    => false,
		'keywords' => 'business name, sole proprietor, sole trader, partnership, limited, ltd, difference, which structure, structure, liability',
		'service'  => 'company-registration',
		'link'     => array( '/insights/business-name-or-limited-company-in-kenya/', 'Read the guide' ),
		'answer'   => "Good question, and one we hear a lot.\n\nA business name registration lets you trade under a name, but it isn't a separate legal entity, so the owners carry the business's obligations personally. A limited company is its own legal person: shareholders' liability is generally limited, and it's easier to bring in partners or investors, though there are more records and filings to keep.\n\nThere's no one right answer. If you tell us a little about your plans, we'll help you weigh it up.",
	),
	array(
		'title'    => 'What documents do I need?',
		'quick'    => false,
		'keywords' => 'documents, document, paperwork, requirements, what do i need, id, passport, kra pin, papers',
		'service'  => 'company-registration',
		'link'     => array( '/services/company-registration/', 'Registration support' ),
		'answer'   => "Usually it's things like identification and contact details for the proposed directors and shareholders, a few name options, a description of what the business will do and a registered office address in Kenya.\n\nIf any shareholders are based abroad or are companies themselves, a few extra documents may be needed, and some may need certifying.\n\nPlease don't send any documents here in the chat. Once we know your situation, we'll confirm the exact list and agree a secure way to share them.",
	),
	array(
		'title'    => 'How much does it cost and how long does it take?',
		'quick'    => true,
		'keywords' => 'cost, price, prices, pricing, fee, fees, charge, charges, how much, quote, quotation, budget, timeline, how long, duration, time, days, weeks',
		'service'  => 'not-sure',
		'link'     => array( '/about/how-we-work/', 'How we work' ),
		'answer'   => "Honest answer: it depends on what you need.\n\nCost and timing vary with the type of entity or filing, how many people are involved, where they're based, how quickly documents are ready and how long the authorities take.\n\nThe good news is you won't be left guessing. After a short chat about your requirements, we send a proposal with a clear scope and terms before any work starts.",
	),
	array(
		'title'    => 'Annual returns and staying compliant',
		'quick'    => true,
		'keywords' => 'annual return, annual returns, compliance, compliant, filing, filings, file, statutory, registrar, up to date, brs, records',
		'service'  => 'corporate-compliance',
		'link'     => array( '/services/corporate-compliance/', 'Compliance support' ),
		'answer'   => "Keeping on top of filings is one of those things that's easy to let slip when you're busy running a business, so you're in good company.\n\nEvery Kenyan company files an annual return, keeps its statutory registers up to date and notifies the Registrar of certain changes. We can check where your company stands with a statutory health check and help you stay on track from there.\n\nWant us to take a look at your position?",
	),
	array(
		'title'    => 'My filings are overdue',
		'quick'    => false,
		'keywords' => 'overdue, late, behind, missed, penalty, penalties, catch up, outstanding, not filed, returns are overdue, overdue annual returns, filings are overdue, late filing, late returns, behind on filings, what do i do',
		'service'  => 'corporate-compliance',
		'link'     => array( '/insights/company-annual-returns-in-kenya/', 'Annual returns guide' ),
		'answer'   => "Don't worry, this happens more often than you'd think, and it's usually fixable.\n\nWe start by reviewing your records and filing history to see exactly what's outstanding, then explain the steps to bring everything up to date and any penalties that may apply. Acting sooner rather than later normally keeps things simpler.\n\nShall we connect you with an adviser to take a look?",
	),
	array(
		'title'    => 'Changing directors or shareholders',
		'quick'    => false,
		'keywords' => 'change director, new director, remove director, resign, shareholder, shares, share transfer, transfer shares, ownership, change of ownership, allot',
		'service'  => 'corporate-advisory',
		'link'     => array( '/insights/changing-directors-or-shareholders-kenya/', 'Read the guide' ),
		'answer'   => "Sure. Changes like these usually need the right approvals under your company's constitution, updated registers and a notification to the Registrar within the time the law allows. Share transfers can also involve stamp duty and other advice.\n\nTell us what's changing and we'll walk you through the steps involved.",
	),
	array(
		'title'    => 'Do I need a company secretary?',
		'quick'    => true,
		'keywords' => 'company secretary, secretary, secretarial, outsource, outsourced, registers, minutes, resolutions',
		'service'  => 'company-secretarial',
		'link'     => array( '/services/company-secretarial/', 'Company secretarial services' ),
		'answer'   => "It depends on the type of company. Public companies must have a qualified company secretary, and private companies above a certain paid-up capital threshold must appoint one too.\n\nPlenty of smaller companies choose secretarial support anyway: it keeps registers, minutes, resolutions and filings in order so the directors can focus on the business.\n\nHappy to explain what applies to your company. Just say the word!",
	),
	array(
		'title'    => 'Board and governance support',
		'quick'    => false,
		'keywords' => 'board, governance, directors, board meeting, board meetings, board papers, charter, policies, governance review, board evaluation, training',
		'service'  => 'corporate-governance',
		'link'     => array( '/services/corporate-governance/', 'Governance support' ),
		'answer'   => "Great boards run on good processes, and that's where we come in.\n\nWe can help with board calendars, agendas and papers, minutes and action tracking, governance documents such as charters and policies, and governance reviews or board evaluation where that fits your needs.\n\nWould you like to talk it through with an adviser?",
	),
	array(
		'title'    => "I'm outside Kenya",
		'quick'    => true,
		'keywords' => 'abroad, outside kenya, foreign, foreigner, diaspora, international, overseas, non-resident, non resident, investor, remote, remotely, visit kenya, travel, travel to kenya, need to travel, come to kenya, be in kenya, from abroad, live abroad',
		'service'  => 'company-registration',
		'link'     => array( '/who-we-help/international-investors/', 'Support for international clients' ),
		'answer'   => "Welcome, and thanks for thinking of Kenya!\n\nYou can absolutely get in touch from wherever you are. Much of the company setup process can be coordinated remotely, though documents signed abroad sometimes need certifying, and a few steps (like opening a bank account) may need extra verification.\n\nTell us a bit about your plans and we'll explain the structure, documents and next steps that apply to you.",
	),
	array(
		'title'    => 'Can foreigners own a Kenyan company?',
		'quick'    => false,
		'keywords' => 'foreign ownership, foreigners own, own a company, foreign shareholder, foreign shareholders, local ownership, branch, subsidiary',
		'service'  => 'company-registration',
		'link'     => array( '/insights/branch-or-subsidiary-kenya/', 'Branch or subsidiary guide' ),
		'answer'   => "Generally, yes. Foreign individuals and companies can own shares in and be directors of Kenyan companies. Some sectors do have local ownership requirements or licensing conditions, so it's worth checking for your particular activity before you register.\n\nIf you're an established company, you might also be weighing up a branch versus a subsidiary. We're happy to talk that through.",
	),
	array(
		'title'    => 'Restructuring or share capital',
		'quick'    => false,
		'keywords' => 'restructure, restructuring, reorganise, reorganize, share capital, new shares, issue shares, convert, conversion, merger, group, employee share',
		'service'  => 'corporate-advisory',
		'link'     => array( '/services/corporate-advisory/', 'Corporate advisory' ),
		'answer'   => "Big changes deserve careful planning, and we can help you map out the corporate side.\n\nMost changes involve board or shareholder approvals, updated registers and filings, and sometimes regulatory approvals or input from lawyers or tax advisers. If you share an outline of what you're planning and your timing, we'll explain the steps and who needs to be involved.",
	),
	array(
		'title'    => "I'm an adviser referring a client",
		'quick'    => false,
		'keywords' => 'refer, referral, referring, my client, law firm, accountant, accounting firm, advisory firm, partner, introduce',
		'service'  => 'not-sure',
		'link'     => array( '/who-we-help/professional-partners/', 'Professional partners' ),
		'answer'   => "Thanks for thinking of us!\n\nThe best way to start is with a short, non-sensitive outline of what your client needs. We'll run conflict checks, then agree scope, roles and how information will be shared securely. Please hold off on sending client documents until that's in place.",
	),
	array(
		'title'    => 'Is my information kept confidential?',
		'quick'    => false,
		'keywords' => 'confidential, confidentiality, private, privacy, secure, security, data, safe, documents safe',
		'service'  => 'not-sure',
		'link'     => array( '/privacy-policy/', 'Privacy policy' ),
		'answer'   => "Absolutely, we take that seriously.\n\nWe only ask for identity or company documents once an engagement is agreed, and then through a secure channel we agree with you. That's also why we ask you not to share documents in this chat.",
	),
	array(
		'title'    => 'What happens after I get in touch?',
		'quick'    => false,
		'keywords' => 'next step, next steps, what happens, process, how does it work, how do you work, proposal, get started, start, begin',
		'service'  => 'not-sure',
		'link'     => array( '/about/how-we-work/', 'How we work' ),
		'answer'   => "It's simple:\n\n1. You tell us what you need.\n2. We have a short conversation to understand your situation.\n3. You receive a proposal with a clear scope and terms.\n4. Once you're happy, we get to work and keep you posted.\n\nNo obligation until you've seen the proposal.",
	),
	array(
		'title'    => 'Talk to an adviser',
		'quick'    => true,
		'keywords' => 'adviser, advisor, human, person, someone, talk, speak, call, contact, consultation, appointment, meeting, phone, whatsapp, real person',
		'service'  => 'not-sure',
		'link'     => array( '/contact/', 'Contact page' ),
		'answer'   => "Of course! Our advisers would be glad to help.\n\nTap the button below and we'll continue the conversation with a real person.",
	),
);
