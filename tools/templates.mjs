// Writes the theme's block templates and template parts. Usage: node tools/templates.mjs
import { writeFileSync, mkdirSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const THEME = join(dirname(fileURLToPath(import.meta.url)), '..', 'wordpress', 'secplus');
const w = (rel, s) => {
	mkdirSync(dirname(join(THEME, rel)), { recursive: true });
	writeFileSync(join(THEME, rel), s.trim() + '\n', 'utf8');
};

const HEADER = '<!-- wp:template-part {"slug":"header","tagName":"header","className":"sp-site-header"} /-->';
const FOOTER = '<!-- wp:template-part {"slug":"footer","tagName":"footer","className":"sp-site-footer"} /-->';
const main = (inner) => `${HEADER}

<!-- wp:group {"tagName":"main","className":"sp-main","layout":{"type":"default"}} -->
<main class="wp-block-group sp-main">${inner}</main>
<!-- /wp:group -->

${FOOTER}`;

const sectionGroup = (tag, cls, inner, contentSize) => {
	const layout = contentSize ? { type: 'constrained', contentSize } : { type: 'constrained' };
	const attrs = { tagName: tag, align: 'full', className: cls, layout };
	return `<!-- wp:group ${JSON.stringify(attrs)} -->
<${tag} class="wp-block-group alignfull ${cls}">${inner}</${tag}>
<!-- /wp:group -->`;
};

w('parts/header.html', '<!-- wp:pattern {"slug":"secplus/header"} /-->');
w('parts/footer.html', '<!-- wp:pattern {"slug":"secplus/footer"} /-->');
w('parts/post-cta.html', '<!-- wp:pattern {"slug":"secplus/cta-final"} /-->');

const DOC_PHOTO = `
<!-- wp:pattern {"slug":"secplus/hero-photo-documents"} /-->`;
const INS_PHOTO = `
<!-- wp:pattern {"slug":"secplus/hero-photo-insights"} /-->`;

const landing = main('<!-- wp:post-content {"align":"full","layout":{"type":"constrained"}} /-->');
w('templates/front-page.html', landing);
w('templates/page-landing.html', landing);
w('templates/page-editorial.html', landing);
w('templates/page-editorial-sans.html', landing);

w(
	'templates/page.html',
	main(`
${sectionGroup('section', 'sp-page-hero sp-page-hero--simple has-photo', `<!-- wp:secplus/breadcrumbs /-->
<!-- wp:post-title {"level":1} /-->${DOC_PHOTO}`, '640px')}

${sectionGroup('div', 'sp-section sp-prose', '<!-- wp:post-content {"layout":{"type":"constrained","contentSize":"640px"}} /-->', '640px')}
`)
);

w(
	'templates/single.html',
	main(`
${sectionGroup('section', 'sp-page-hero sp-article-hero has-photo', `<!-- wp:secplus/breadcrumbs /-->
<!-- wp:post-title {"level":1,"className":"sp-article-hero__title"} /-->
<!-- wp:post-excerpt {"className":"sp-article-hero__excerpt"} /-->
<!-- wp:secplus/article-meta /-->${INS_PHOTO}`, '640px')}

${sectionGroup('article', 'sp-section sp-prose sp-article', `<!-- wp:post-content {"layout":{"type":"constrained","contentSize":"640px"}} /-->
<!-- wp:secplus/related-service /-->`, '640px')}

${sectionGroup('section', 'sp-section sp-section--mist', '<!-- wp:secplus/related-posts /-->')}

<!-- wp:template-part {"slug":"post-cta"} /-->
`)
);

const query = (postType = 'post') => `<!-- wp:query {"queryId":3,"query":{"perPage":9,"pages":0,"offset":0,"postType":"${postType}","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"className":"sp-latest"} -->
<div class="wp-block-query sp-latest"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"className":"sp-post-card","layout":{"type":"default"}} -->
<div class="wp-block-group sp-post-card"><!-- wp:post-terms {"term":"category","className":"sp-post-card__cat"} /-->
<!-- wp:post-title {"level":2,"isLink":true,"className":"sp-post-card__title"} /-->
<!-- wp:post-excerpt {"excerptLength":24,"className":"sp-post-card__excerpt"} /-->
<!-- wp:read-more {"content":"Read more","className":"sp-post-card__more"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->
<!-- wp:query-pagination-numbers /-->
<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"sp-empty-note"} -->
<p class="sp-empty-note">Nothing has been published here yet. Try another topic, read our frequently asked questions or contact us with your question.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->`;

const eyebrow = `<!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">Insights &amp; Resources</p>
<!-- /wp:paragraph -->`;

const listing = (hero, postType, pic = INS_PHOTO) =>
	main(`
${sectionGroup('section', 'sp-page-hero sp-page-hero--simple has-photo', hero + pic)}

${sectionGroup('section', 'sp-section sp-section--mist', query(postType))}

<!-- wp:template-part {"slug":"post-cta"} /-->
`);

w(
	'templates/archive.html',
	listing(`<!-- wp:secplus/breadcrumbs /-->
${eyebrow}
<!-- wp:query-title {"type":"archive","showPrefix":false} /-->
<!-- wp:term-description {"className":"sp-lead-text"} /-->`)
);

const homeHero = `${eyebrow}
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Latest guides and insights</h1>
<!-- /wp:heading -->`;
w('templates/home.html', listing(homeHero));
w('templates/index.html', listing(homeHero));

w(
	'templates/search.html',
	listing(
		`<!-- wp:secplus/breadcrumbs /-->
<!-- wp:query-title {"type":"search"} /-->
<!-- wp:search {"label":"Search","showLabel":false,"placeholder":"Search guides and pages","buttonText":"Search","className":"sp-search"} /-->`,
		'any',
		DOC_PHOTO
	)
);

w(
	'templates/404.html',
	main(`
${sectionGroup('section', 'sp-page-hero sp-page-hero--simple sp-404 has-photo', `<!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">Error 404</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">We couldn’t find that page.</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"is-style-lead"} -->
<p class="is-style-lead">The page may have moved. Search the site, or go straight to our services or contact page.</p>
<!-- /wp:paragraph -->
<!-- wp:search {"label":"Search","showLabel":false,"placeholder":"Search guides and pages","buttonText":"Search","className":"sp-search"} /-->
<!-- wp:pattern {"slug":"secplus/links-404"} /-->${DOC_PHOTO}`, '760px')}
`)
);

console.log('Templates written.');
