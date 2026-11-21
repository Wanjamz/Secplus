// Page hero photos (AI-generated with Higgsfield, stored in wordpress/secplus/assets/images/pages/).
// Alt text describes what is shown; people pictured are not SecPlus staff.
export const PHOTOS = {
	'who-we-help': 'Kenyan professionals in conversation in a bright Nairobi office',
	'kenyan-businesses': 'A Kenyan entrepreneur reviewing company documents beside a laptop',
	'international-investors': 'An investor abroad on a video call with a Kenyan corporate adviser',
	'corporate-boards': 'Directors in a board meeting in a Nairobi boardroom',
	'professional-partners': 'Two advisers shaking hands in a modern office',
	services: 'Company documents, a certificate, a pen and a laptop on an executive desk',
	'company-registration': 'A founder signing company registration documents with an adviser',
	'corporate-compliance': 'A compliance officer organising statutory files and binders',
	'company-secretarial': 'A company secretary writing in a minute book beside statutory registers',
	'corporate-governance': 'A board chair leading a discussion with fellow directors',
	'corporate-advisory': 'Two executives discussing a company structure diagram on a glass wall',
	about: 'Corporate advisers at work in a modern Nairobi office',
	'how-we-work': 'An adviser listening to a client during a first consultation',
	faqs: 'A businessman reading answers on a tablet',
	insights: 'A printed business guide, a notebook and a laptop on a desk in morning light',
	contact: 'A corporate adviser taking a client call at her desk',
	legal: 'A fountain pen on formal documents beside a seal stamp',
};

export const photo = (slug) => ({ file: `pages/${slug}.jpg`, alt: PHOTOS[slug] });
