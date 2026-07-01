# Garage 37 — strona (WordPress)

Landing autoserwisu **Garage 37** (Gliwice) jako motyw WordPress. Cała treść
edytowalna w panelu (**Wygląd → Dostosuj → „Treść — Garage 37”**), meta-tagi/SEO
również. Fonty i zdjęcia hostowane lokalnie (bez Google CDN), Google Analytics
ładuje się wyłącznie po zgodzie w banerze cookie.

## Struktura

```
docker-compose.yml            # lokalne środowisko: WordPress php8.3 + MariaDB + wp-cli
init.sh                       # jednorazowa instalacja + aktywacja motywu
package.json / build.mjs      # minifikacja CSS+JS (esbuild)
package.sh                    # budowa instalowalnego pakietu → dist/garage37.zip
wp-content/themes/garage37/   # MOTYW (to jest produkt)
  style.css                   #   nagłówek motywu WP
  functions.php               #   pola treści + Customizer + meta/OG + favicon + GA
  header.php / footer.php
  front-page.php / index.php  #   → template-parts/landing.php
  template-parts/landing.php  #   cała treść landingu
  assets/
    css/main.css  main.min.css      # źródło + build
    js/cookie.js  cookie.min.js     # źródło + build (baner cookie + GA)
    fonts/*.woff2                    # Archivo / JetBrains Mono / Racing Sans One
    img/{hero.jpg, about.jpg, favicon.svg}
```

W produkcji ładowane są pliki `*.min`. Przy `define('SCRIPT_DEBUG', true)`
(wp-config.php) ładują się nieskompresowane źródła — do lokalnej edycji.

## Lokalny podgląd (Docker)

```bash
./init.sh              # pierwszy raz: instalacja WP + aktywacja motywu
docker compose up -d   # kolejne uruchomienia
```

- Strona: http://localhost:8095
- Panel:  http://localhost:8095/wp-admin  (`admin` / `admin`)
- Edycja treści: **Wygląd → Dostosuj → „Treść — Garage 37”**
- Google Analytics: sekcja **Analityka Google** → wpisać ID `G-…`
- Stop: `docker compose down` (dane zostają) / `down -v` (kasuje bazę i rdzeń WP)

## Build i pakiet

```bash
npm install            # raz — pobiera esbuild
npm run build          # minifikacja CSS + JS
npm run package        # build + dist/garage37.zip
```

## Instalacja na dowolnym WordPressie

`dist/garage37.zip` → **Wygląd → Motywy → Dodaj nowy → Wyślij motyw** →
zainstaluj i aktywuj. Treść i SEO ustawia się w **Dostosuj**.

Wymagania: WordPress ≥ 6.0, PHP ≥ 7.4. Bez płatnych wtyczek.
