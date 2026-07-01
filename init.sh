#!/usr/bin/env bash
# Pierwszy start: podnosi kontenery, instaluje WordPressa, aktywuje motyw Garage 37.
# Idempotentne — można uruchamiać wielokrotnie.
set -euo pipefail
cd "$(dirname "$0")"

URL="http://localhost:8095"
ADMIN_USER="admin"
ADMIN_PASS="admin"
ADMIN_EMAIL="admin@garage37.local"

cli() { docker compose run --rm -T wpcli "$@"; }

echo "→ Podnoszę kontenery (db, wordpress)…"
docker compose up -d db wordpress

echo "→ Czekam na wp-config.php…"
for _ in $(seq 1 60); do cli config path >/dev/null 2>&1 && break; sleep 2; done

echo "→ Czekam na bazę danych…"
for _ in $(seq 1 60); do cli db check >/dev/null 2>&1 && break; sleep 2; done

if cli core is-installed >/dev/null 2>&1; then
  echo "→ WordPress już zainstalowany."
else
  echo "→ Instaluję WordPressa…"
  cli core install \
    --url="$URL" \
    --title="Garage 37" \
    --admin_user="$ADMIN_USER" \
    --admin_password="$ADMIN_PASS" \
    --admin_email="$ADMIN_EMAIL" \
    --skip-email
fi

echo "→ Aktywuję motyw…"
cli theme activate garage37

echo "→ Przyjazne odnośniki + język polski…"
cli rewrite structure '/%postname%/' --hard >/dev/null 2>&1 || true
cli language core install pl_PL >/dev/null 2>&1 || true
cli site switch-language pl_PL >/dev/null 2>&1 || true

echo
echo "✔ Gotowe."
echo "  Strona:  $URL"
echo "  Admin:   $URL/wp-admin  ($ADMIN_USER / $ADMIN_PASS)"
echo "  Treść:   Wygląd → Dostosuj → „Treść — Garage 37”"
