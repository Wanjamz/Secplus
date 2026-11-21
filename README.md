# SecPlus Consulting: WordPress website

## Preview the website

**[Open the live preview](https://playground.wordpress.net/?blueprint-url=https://raw.githubusercontent.com/Wanjamz/Secplus/main/preview/blueprint.json)**

The link runs the complete website in your own browser using WordPress Playground. Nothing needs installing and no account is needed. It takes about 30–60 seconds to load the first time. You can click through every page, open the chat assistant and look around the admin area (you're signed in automatically).

Please note:
- The preview is temporary: anything changed there is lost when the tab closes.
- The contact form and WhatsApp hand-over are for demonstration; enquiries aren't emailed from the preview.
- Contact details, team profiles and some other items are intentionally blank until confirmed (see the launch checklist under **SecPlus → Launch checklist** in the admin area).
- Insight guides are shown published for review; on the live site they stay as "Pending Review" until approved.
- Photos are AI-generated placeholders for approval; the people shown are not SecPlus staff.

---

A custom, lightweight WordPress **block theme** (`secplus`) plus a small companion plugin (`secplus-core`). Everything is built from the approved content blueprint, the homepage design reference and the original SecPlus logo.

| Folder | What it is |
|---|---|
| `dist/secplus-theme.zip` | The theme. Upload under **Appearance → Themes → Add New → Upload**. |
| `dist/secplus-core.zip` | The plugin. Upload under **Plugins → Add New → Upload**. |
| `wordpress/` | Source for both (identical to the zips). |
| `tools/` | Developer tools: content generator, markup checker, local test setup. |

## Installing on a WordPress site

Requirements: WordPress 6.6 or later (tested on 7.1) and PHP 7.4 or later. No page builder and no other plugins are needed.

1. Upload and **activate the theme** (`secplus-theme.zip`).
2. Upload and **activate the plugin** (`secplus-core.zip`).
3. Go to **SecPlus → Import content** and click **Import website content**. This creates:
   - all pages (Home, Who We Help + 4 audience pages, Our Services + 5 service pages, Insights & Resources, FAQs, About Us, How We Work, Contact, Privacy Policy, Terms of Use, Cookie Notice);
   - two **draft** pages waiting for client information (Our People & Credentials, Client Experiences);
   - 10 insight guides in 5 categories, imported as **Pending Review** (see below);
   - the static front page, the original logo as Site Logo, SEO-friendly permalinks (`/services/company-registration/`, `/insights/guide-name/`), and closed comments.
4. Go to **SecPlus → Site settings** and enter the verified phone, email, office address and enquiry recipient. Fields left blank stay hidden on the site.
5. Work through **SecPlus → Launch checklist**. It lists every item that is *Pending Client Confirmation*.

Running the import again is safe: it only adds missing items unless you tick "Overwrite".
With WP-CLI: `wp secplus import` (add `--publish-guides` to publish the guides).

## Editing the website (no code needed)

- **Page content** (homepage sections, hero text, service and audience pages): **Pages → edit** in the block editor. Every section is made of standard blocks.
- **Header, navigation and footer:** **Appearance → Editor → Patterns → Template parts**.
- **Reusable sections:** in the block inserter, open **Patterns → "SecPlus: …"** to add the hero, the "What brings you to SecPlus?" routes, service cards, the process steps, the CTA band, or a whole new service or audience page.
- **Icons:** select a SecPlus Icon block and choose from 37 icons in the sidebar.
- **SEO title and meta description:** the **"SEO & review"** panel in the page/post sidebar. It steps aside automatically if Yoast, Rank Math or a similar plugin is installed.
- **Contact details and social links:** **SecPlus → Site settings** (used in the footer, Contact page, About page and search-engine data).
- **Enquiries:** **SecPlus → Enquiries**. Each submission is stored privately, emailed to the recipient in Site settings and has a follow-up status. Enquiries can be exported or erased under **Tools → Export/Erase Personal Data**.

## Content rules that are built in

- No testimonials, qualifications, client numbers, years of experience, awards, prices or timelines have been invented.
- Unverified details are **not published**. They are either hidden (blank settings), kept in draft pages marked *Pending Client Confirmation*, or listed on the launch checklist.
- **Insight guides** contain general guidance written against official Kenyan sources, but they must be checked by a qualified SecPlus reviewer first. Add the reviewer and review date in the "SEO & review" panel, then publish. Until a guide is published, links to it are hidden automatically, so there are no broken links.
- The "Certified Secretaries (Kenya)" wording comes from the original logo. The checklist asks for the registration details behind it to be confirmed.

## Images

- **Homepage:** `hero-nairobi-skyline.jpg` (Nairobi skyline with KICC) and `about-consultation.jpg` (adviser with clients).
- **Every other page:** a matching photo in `wordpress/secplus/assets/images/pages/`, one per page: each audience page, each service page, the Who We Help and Services hubs, About, How We Work, FAQs, Insights and Contact. Guides and guide categories share `insights.jpg`; legal, search, 404 and other generic pages share `legal.jpg`.

All photos were **AI-generated with Higgsfield (GPT Image 2.6)** for this site. The people shown are not SecPlus staff: never caption or present them as the team. The launch checklist includes an item to approve them or replace them with your own photography. To swap a page photo, select the image at the top of the page in the editor and click **Replace**; the list of photos and their descriptions is in `tools/content/photos.mjs`.

The logo is the original supplied PNG, unaltered. A high-resolution or SVG version would look sharper on high-density screens.

## Client logo strip

The homepage shows an auto-scrolling strip of 17 client logos ("Organizations we have supported") directly below the "What brings you to SecPlus?" panel. The logos come from `Clients logo/`, trimmed and stored in `wordpress/secplus/assets/images/clients/`.

- **Editing:** each logo is an ordinary Image block. In the Home page editor, select a logo to replace or delete it, or duplicate one to add another. The strip is also available as the pattern **"Client logo strip (auto-scrolling)"**, so it can be added to other pages.
- **Behaviour:** logos show in greyscale and turn full colour on hover. The strip pauses on hover or keyboard focus, has a pause/play button, and stays still for visitors who have reduced motion switched on. Without JavaScript, the logos show as a tidy wrapped grid.
- **Links:** 11 logos link to the organization's verified official website (opening in a new tab): CFAO (now CFAO Mobility), Bata, VisionFund, IHG, Pearson, Rider Levett Bucknall, KVM, TISA, Unifi, Karunguru and Zaribee. DT Dobie (in liquidation), Directline (placeholder site), Hayer Group (no matching site found), EbonyLife TV (site currently down), Norfolk Towers and JR Accounting are not linked. To add or change a link, select the logo in the Home page editor and use the link button in the toolbar.
- **Before launch:** confirm permission to display each organization's logo (this is on the launch checklist).

## Motion

Motion follows one idea, progression through the corporate lifecycle (Establish, Maintain, Govern, Advance):

- **"What brings you to SecPlus?"**: a line draws across the four stages and each stage lights up in turn (horizontal on desktop, vertical on phones).
- **Process steps** (homepage, service pages, About): number badges fill in order, joined by drawn connectors.
- **Services lifecycle**: stages arrive left to right with arrows sliding in between.
- **How We Work**: a vertical progress rail fills as you scroll through the five stages.
- **Supporting touches**: the hero copy rises in and the skyline photo settles, the About photo is revealed with a horizontal wipe, card lists rise in, the "+" marks on the call-to-action panel drift slowly, the header gains a soft shadow on scroll and FAQ answers open smoothly.

Content is always visible by default, so nothing stays hidden if a script fails. Visitors who have "reduce motion" switched on see a still page. Ongoing loops pause when off screen. The code is in `wordpress/secplus/assets/js/motion.js` and section 19b of `style.css`.

## Chat assistant (WhatsApp hand-over)

A "Chat with us" button on every page opens a WhatsApp-style chat:

- It greets the visitor and offers popular topics, and visitors can also type their own question.
- Answers are written in a warm, conversational tone from the blueprint's FAQs, with a link to the relevant page. No prices, timelines or guarantees are promised.
- Topics SecPlus does not handle (for example trademarks, visas, tax returns, audits) get an honest "an adviser can tell you if we can help" reply.
- Every answer ends with **"Chat with an adviser on WhatsApp"**, which opens WhatsApp with the visitor's question pre-filled. Until a WhatsApp number is entered in **SecPlus → Site settings**, the button sends visitors to the enquiry form instead (with the right service preselected).
- Nothing typed in the chat is stored or sent anywhere unless the visitor taps the hand-over button. The Privacy Policy explains this.

**Editing answers:** go to **SecPlus → Chat answers**. Each answer has the question (which also labels the topic button), the reply (a blank line starts a new chat bubble), keywords the visitor might type, a "starter topic" tick box, a related service and an optional link. Drag order is set with "Order" in Page Attributes. Switch the chat off or rename it in **SecPlus → Site settings → Chat assistant**.

## Editorial page style (optional)

The theme includes a second landing template, **"Editorial landing"**, inspired by large-format corporate sites:
- a full-bleed skyline photo hero with a navy overlay and white headline;
- floating white "capsule" navigation;
- regular-weight serif headlines (Newsreader, self-hosted) with Manrope body text;
- larger intro text, roomier section spacing, "headline left, intro right" section openings;
- no small labels above headings, and plain buttons without arrows.

A third template, **"Editorial landing (sans headlines)"**, uses the same editorial layout but keeps the original bold Manrope headlines instead of the serif.

**The site now uses the editorial style with sans headlines everywhere by default.** Change the whole site's look under **SecPlus → Site settings → Site style** (Editorial sans, Editorial serif or Classic). A page set to one of the editorial templates keeps that template's style. In the editorial styles, each page's photo becomes a full-bleed background behind the headline; in the Classic style it appears as a rounded photo with the question card overlapping it. Switching back to "Landing page" restores the original look; the content is the same either way.

## Design system

- Colours from the logo: navy-purple `#1F1A3D`, bright blue `#26ABE2`, plus white, light blue `#EAF6FC` and cool grey `#F4F6FA`. Text links use `#0E6F9E` to meet contrast standards.
- A subtle gold accent (`#F2B634`, lighter `#F7CB62` on navy) appears sparingly: the stage labels and step numbers on navy, the end of the lifecycle line, the tagline highlight, one of the brand "+" marks, the "+" in small heading labels and text selection. Blue remains the main accent.
- Typeface: Manrope, self-hosted (no Google Fonts requests).
- All colours, font sizes and spacing are editable in **Appearance → Editor → Styles**.

## For developers

```
node tools/build.mjs          # regenerate theme patterns + importer content from tools/content/*.mjs
node tools/templates.mjs      # regenerate block templates and template parts
node tools/check-markup.mjs   # static check of all block markup
```

Local preview with WordPress Playground (Node 20+; downloads WordPress on first run):

```
npx @wp-playground/cli@latest server --port=9400 --mount=./wordpress/secplus:/wordpress/wp-content/themes/secplus --mount=./wordpress/secplus-core:/wordpress/wp-content/plugins/secplus-core --blueprint=./tools/playground/blueprint.json --login
```

Then open http://127.0.0.1:9400/. The local blueprint publishes the guides so every layout can be reviewed.
