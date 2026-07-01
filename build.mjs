// Minifikacja CSS i JS motywu przez esbuild.
// Źródła:  assets/css/main.css, assets/js/cookie.js
// Wynik:   assets/css/main.min.css, assets/js/cookie.min.js
import { build } from 'esbuild';
import { fileURLToPath } from 'node:url';
import path from 'node:path';

const root = path.dirname(fileURLToPath(import.meta.url));
const theme = path.join(root, 'wp-content/themes/garage37');

const targets = [
  { in: 'assets/css/main.css',  out: 'assets/css/main.min.css' },
  { in: 'assets/js/cookie.js',  out: 'assets/js/cookie.min.js' },
];

for (const t of targets) {
  await build({
    entryPoints: [path.join(theme, t.in)],
    outfile: path.join(theme, t.out),
    minify: true,
    legalComments: 'none',
    loader: { '.css': 'css' },
    logLevel: 'info',
  });
  console.log(`✓ ${t.in} → ${t.out}`);
}
