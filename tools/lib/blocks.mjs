// Block-markup helpers. Output is valid, editor-compatible Gutenberg markup.
// Two output modes:
//  - 'content': links/images use {{home}} / {{theme}} tokens (replaced by the importer)
//  - 'php':     links/images use PHP (for theme pattern files)

export const ctx = { mode: 'content' };

export const url = (p) =>
	ctx.mode === 'php' ? `<?php echo esc_url( home_url( '${p}' ) ); ?>` : `{{home}}${p}`;
export const img = (f) =>
	ctx.mode === 'php'
		? `<?php echo esc_url( get_theme_file_uri( 'assets/images/${f}' ) ); ?>`
		: `{{theme}}/assets/images/${f}`;

// Escape bare ampersands; inline HTML (links, strong, em) is allowed in text.
export const tx = (s) => String(s).replace(/&(?![a-zA-Z]+;|#\d+;)/g, '&amp;');

const json = (o) => {
	const keys = Object.keys(o).filter((k) => o[k] !== undefined && o[k] !== '' && o[k] !== null);
	if (!keys.length) return '';
	const clean = {};
	keys.forEach((k) => (clean[k] = o[k]));
	return ' ' + JSON.stringify(clean);
};
const cls = (...c) => c.filter(Boolean).join(' ');
const join = (parts) => (Array.isArray(parts) ? parts.filter(Boolean).join('\n') : parts);

/* ---------- core blocks ---------- */

export function group(o = {}, inner = '') {
	const tag = o.tag || 'div';
	const a = {
		tagName: tag !== 'div' ? tag : undefined,
		align: o.align,
		className: o.cls,
		layout: o.layout || { type: 'constrained' },
	};
	const id = o.id ? ` id="${o.id}"` : '';
	const label = o.label ? ` aria-label="${o.label}"` : '';
	return `<!-- wp:group${json(a)} -->\n<${tag}${id}${label} class="${cls('wp-block-group', o.align && `align${o.align}`, o.cls)}">\n${join(inner)}\n</${tag}>\n<!-- /wp:group -->`;
}

export const flow = (c, inner, extra = {}) => group({ cls: c, layout: { type: 'default' }, ...extra }, inner);
export const grid = (c, min, inner, extra = {}) =>
	group({ cls: c, layout: { type: 'grid', minimumColumnWidth: min }, ...extra }, inner);
export const row = (c, inner, extra = {}) =>
	group({ cls: c, layout: { type: 'flex', flexWrap: 'wrap', verticalAlignment: 'center' }, ...extra }, inner);

export function columns(o = {}, cols = []) {
	const a = { verticalAlignment: o.valign, className: o.cls, align: o.align };
	const inner = cols
		.map((c) => {
			const ca = { verticalAlignment: c.valign, width: c.width, className: c.cls };
			const style = c.width ? ` style="flex-basis:${c.width}"` : '';
			return `<!-- wp:column${json(ca)} -->\n<div class="${cls('wp-block-column', c.valign && `is-vertically-aligned-${c.valign}`, c.cls)}"${style}>\n${join(c.inner)}\n</div>\n<!-- /wp:column -->`;
		})
		.join('\n');
	return `<!-- wp:columns${json(a)} -->\n<div class="${cls('wp-block-columns', o.align && `align${o.align}`, o.valign && `are-vertically-aligned-${o.valign}`, o.cls)}">\n${inner}\n</div>\n<!-- /wp:columns -->`;
}

export function h(level, text, c) {
	const a = { level: level !== 2 ? level : undefined, className: c };
	return `<!-- wp:heading${json(a)} -->\n<h${level} class="${cls('wp-block-heading', c)}">${tx(text)}</h${level}>\n<!-- /wp:heading -->`;
}

export function p(text, c) {
	const a = { className: c };
	const attr = c ? ` class="${c}"` : '';
	return `<!-- wp:paragraph${json(a)} -->\n<p${attr}>${tx(text)}</p>\n<!-- /wp:paragraph -->`;
}

export const eyebrow = (text) => p(text, 'is-style-eyebrow');
export const lead = (text) => p(text, 'is-style-lead');
export const arrowLink = (label, href) => p(`<a href="${href}">${tx(label)}</a>`, 'is-style-arrow-link');

export function list(items, c, ordered = false) {
	const a = { ordered: ordered || undefined, className: c };
	const tag = ordered ? 'ol' : 'ul';
	const lis = items.map((i) => `<!-- wp:list-item -->\n<li>${tx(i)}</li>\n<!-- /wp:list-item -->`).join('\n');
	return `<!-- wp:list${json(a)} -->\n<${tag} class="${cls('wp-block-list', c)}">${lis}</${tag}>\n<!-- /wp:list -->`;
}
export const checklist = (items, c) => list(items, cls('is-style-checklist', c));

// buttons([{ label, href, style: 'navy' | 'ghost' | 'text' }], className)
export function buttons(items, c) {
	const btns = items
		.map((b) => {
			const bc = b.style ? `is-style-${b.style}` : undefined;
			return `<!-- wp:button${json({ className: bc })} -->\n<div class="${cls('wp-block-button', bc)}"><a class="wp-block-button__link wp-element-button" href="${b.href}">${tx(b.label)}</a></div>\n<!-- /wp:button -->`;
		})
		.join('\n');
	return `<!-- wp:buttons${json({ className: c })} -->\n<div class="${cls('wp-block-buttons', c)}">${btns}</div>\n<!-- /wp:buttons -->`;
}

// image(src, alt, className, href?) — with href, the image links out in a new tab.
export function image(src, alt, c, href) {
	const a = { sizeSlug: 'full', linkDestination: href ? 'custom' : 'none', className: c };
	const img = `<img src="${src}" alt="${alt}"/>`;
	const inner = href ? `<a href="${href}" target="_blank" rel="noreferrer noopener">${img}</a>` : img;
	return `<!-- wp:image${json(a)} -->\n<figure class="${cls('wp-block-image size-full', c)}">${inner}</figure>\n<!-- /wp:image -->`;
}

export function details(summary, inner, c = 'sp-faq') {
	return `<!-- wp:details${json({ className: c })} -->\n<details class="${cls('wp-block-details', c)}"><summary>${tx(summary)}</summary>${join(inner)}</details>\n<!-- /wp:details -->`;
}

export const separator = () =>
	`<!-- wp:separator {"className":"is-style-wide"} -->\n<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>\n<!-- /wp:separator -->`;

/* ---------- custom dynamic blocks ---------- */

export const icon = (name, variant, size) =>
	`<!-- wp:secplus/icon${json({ icon: name, variant: variant && variant !== 'tint' ? variant : undefined, size: size && size !== 'md' ? size : undefined })} /-->`;
export const breadcrumbs = () => `<!-- wp:secplus/breadcrumbs /-->`;
export const guideLinks = (slugs, title) =>
	`<!-- wp:secplus/guide-links${json({ slugs, title })} /-->`;
export const topicCards = () => `<!-- wp:secplus/topic-cards /-->`;
export const enquiryForm = () => `<!-- wp:secplus/enquiry-form /-->`;
export const contactDetails = (layout) => `<!-- wp:secplus/contact-details${json({ layout })} /-->`;

export function latestPosts(n = 3, queryId = 1, c = 'sp-latest') {
	const q = {
		queryId,
		query: { perPage: n, pages: 0, offset: 0, postType: 'post', order: 'desc', orderBy: 'date', author: '', search: '', exclude: [], sticky: '', inherit: false },
		className: c,
	};
	return [
		`<!-- wp:query ${JSON.stringify(q)} -->`,
		`<div class="wp-block-query ${c}">`,
		`<!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->`,
		flow('sp-post-card', [
			`<!-- wp:post-terms {"term":"category","className":"sp-post-card__cat"} /-->`,
			`<!-- wp:post-title {"level":3,"isLink":true,"className":"sp-post-card__title"} /-->`,
			`<!-- wp:post-excerpt {"excerptLength":24,"className":"sp-post-card__excerpt"} /-->`,
			`<!-- wp:read-more {"content":"Read the guide","className":"sp-post-card__more"} /-->`,
		]),
		`<!-- /wp:post-template -->`,
		`<!-- wp:query-no-results -->`,
		p(
			`New practical guides are being prepared and professionally reviewed. In the meantime, <a href="${url('/services/')}">explore our services</a> or <a href="${url('/contact/')}">ask us a question directly</a>.`,
			'sp-empty-note'
		),
		`<!-- /wp:query-no-results -->`,
		`</div>`,
		`<!-- /wp:query -->`,
	].join('\n');
}

/* ---------- composite sections ---------- */

export const section = (c, inner, extra = {}) =>
	group({ tag: 'section', align: 'full', cls: cls('sp-section', c), ...extra }, inner);

export function sectionHead({ eyebrow: eb, title, intro, level = 2, c }) {
	return flow(cls('sp-section-head', c), [eb && eyebrow(eb), h(level, title), intro && lead(intro)]);
}

// card: { icon, title, text, link: { label, href }, tag }
export function card(cd, c = 'is-style-card sp-card') {
	return flow(c, [
		cd.tag && p(cd.tag, 'sp-tag'),
		cd.icon && icon(cd.icon, cd.iconVariant),
		h(cd.level || 3, cd.title),
		cd.text && p(cd.text),
		cd.list && checklist(cd.list),
		cd.link && arrowLink(cd.link.label, cd.link.href),
	]);
}

export const cardGrid = (cards, min = '16rem', c = 'sp-card-grid', cardClass) =>
	grid(c, min, cards.map((cd) => card(cd, cardClass)));

export function steps(items, c = 'sp-steps') {
	return grid(
		c,
		'13rem',
		items.map((s, i) =>
			flow('sp-step', [p(String(i + 1).padStart(2, '0'), 'sp-step__num'), h(3, s.title), p(s.text)])
		)
	);
}

export function faqList(items) {
	return flow(
		'sp-faq-list',
		items.map((f) => details(f.q, Array.isArray(f.a) ? f.a.map((t) => p(t)) : [p(f.a)]))
	);
}

export function ctaBand({ title, text, primary, secondary, eb }) {
	return section(
		'sp-section--cta',
		flow('sp-cta', [
			flow('sp-cta__text', [eb && eyebrow(eb), h(2, title), text && p(text)]),
			buttons(
				[primary && { label: primary.label, href: primary.href }, secondary && { label: secondary.label, href: secondary.href, style: 'ghost' }].filter(Boolean),
				'sp-cta__actions'
			),
		])
	);
}

// Inner-page hero with an optional photo and a question card on the right.
// photo: { file: 'pages/x.jpg', alt: '...' }
export function pageHero({ eb, title, text, primary, secondary, asideTitle, asideItems, asideIcon = 'message', c, photo }) {
	const left = [
		breadcrumbs(),
		eb && eyebrow(eb),
		h(1, title),
		lead(text),
		buttons(
			[primary && { label: primary.label, href: primary.href }, secondary && { label: secondary.label, href: secondary.href, style: 'navy' }].filter(Boolean)
		),
	];
	const card = asideItems
		? flow('sp-hero-card', [icon(asideIcon, 'solid'), h(2, asideTitle || 'Questions we can help you answer', 'sp-hero-card__title'), checklist(asideItems)])
		: '';
	const pic = photo ? image(img(photo.file), photo.alt, 'sp-page-hero__photo') : '';
	const right = pic || card ? [pic, card].filter(Boolean) : '';
	return group(
		{ tag: 'section', align: 'full', cls: cls('sp-page-hero', photo && 'has-photo', c) },
		columns({ valign: 'center', cls: 'sp-page-hero__cols' }, [
			{ width: right ? '58%' : '100%', inner: left },
			right && { width: '42%', inner: right },
		].filter(Boolean))
	);
}

// Two-column "situation" block: heading left, prose right.
export function split({ eb, title, paras, c, aside }) {
	return section(
		cls('sp-split', c),
		columns({ cls: 'sp-split__cols' }, [
			{ width: '42%', inner: [eb && eyebrow(eb), h(2, title)] },
			{ width: '58%', inner: [...paras.map((t) => p(t)), aside] },
		])
	);
}
