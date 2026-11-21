// Static sanity checks for generated block markup: balanced block comments,
// balanced HTML wrappers per block, and valid JSON attributes.
// Usage: node tools/check-markup.mjs
import { readFileSync, readdirSync } from 'node:fs';
import { join, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = join(dirname(fileURLToPath(import.meta.url)), '..', 'wordpress');
const files = [];
const walk = (d) => {
	for (const f of readdirSync(d, { withFileTypes: true })) {
		const p = join(d, f.name);
		if (f.isDirectory()) walk(p);
		else if (/\.(html|php)$/.test(f.name) && (p.includes('patterns') || p.includes('templates') || p.includes('parts') || p.includes('content'))) files.push(p);
	}
};
walk(root);

let problems = 0;
for (const file of files) {
	let src = readFileSync(file, 'utf8');
	src = src.replace(/<\?php[\s\S]*?\?>/g, 'X'); // neutralize PHP
	const re = /<!--\s+(\/)?wp:([a-z0-9-]+(?:\/[a-z0-9-]+)?)(\s+(\{[\s\S]*?\}))?\s*(\/)?-->/g;
	const stack = [];
	let m;
	while ((m = re.exec(src))) {
		const [, closing, name, , json, selfClosing] = m;
		if (json) {
			try {
				JSON.parse(json);
			} catch (e) {
				console.log(`${file}: invalid JSON in ${name}: ${json.slice(0, 80)}`);
				problems++;
			}
		}
		if (selfClosing) continue;
		if (closing) {
			const top = stack.pop();
			if (!top || top.name !== name) {
				console.log(`${file}: closing wp:${name} but open is ${top && top.name}`);
				problems++;
			} else {
				// HTML between open and close should have balanced tags.
				const inner = src.slice(top.end, m.index).replace(/<!--[\s\S]*?-->/g, '');
				const opens = (inner.match(/<(div|section|main|article|figure|details|ul|ol|li|p|h[1-6]|a|summary|header|footer)\b[^>]*>/g) || []).length;
				const closes = (inner.match(/<\/(div|section|main|article|figure|details|ul|ol|li|p|h[1-6]|a|summary|header|footer)>/g) || []).length;
				if (opens !== closes) {
					console.log(`${file}: unbalanced HTML inside wp:${name} (${opens} open / ${closes} close)`);
					problems++;
				}
			}
		} else {
			stack.push({ name, end: re.lastIndex });
		}
	}
	if (stack.length) {
		console.log(`${file}: unclosed blocks: ${stack.map((s) => s.name).join(', ')}`);
		problems++;
	}
}
console.log(`Checked ${files.length} files, ${problems} problem(s).`);
process.exit(problems ? 1 : 0);
