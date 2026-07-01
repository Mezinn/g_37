#!/usr/bin/env bash
# Buduje instalowalny pakiet motywu → dist/garage37.zip
# (Wygląd → Motywy → Dodaj nowy → Wyślij motyw). Wymaga wcześniejszego `npm run build`.
set -euo pipefail
cd "$(dirname "$0")"

OUT="dist/garage37.zip"
mkdir -p dist
rm -f "$OUT"

( cd wp-content/themes && zip -r -X "../../$OUT" garage37 \
    -x '*/.DS_Store' -x '*.map' ) >/dev/null

echo "✔ Pakiet motywu: $OUT"
ls -lh "$OUT"
