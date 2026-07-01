# Garage 37 — strona (statyczny front)

Landing autoserwisu **Garage 37** (Gliwice). Czysty statyczny front — bez
zaplecza, bazy i builda. Jeden plik `index.html` + `assets/`.

## Struktura

```
index.html            # cała strona: treść + krytyczny CSS inline
assets/
  fonts/*.woff2        # Archivo / JetBrains Mono / Racing Sans One (subset PL, variable)
  img/                 # hero.{webp,jpg}, about.{webp,jpg}, favicon.svg
  js/cookie.js         # baner zgody cookie + Google Tag Manager (po zgodzie)
```

## Edycja

- **Treść** (teksty, telefon, adres, usługi) — bezpośrednio w `index.html`.
- **Style** — sekcja `<style>` w `<head>` tego samego pliku.
- **Analityka** — GTM `GTM-5Q2V4J23` w `<script>window.G37=…` na końcu `index.html`
  (ładuje się dopiero po akceptacji banera cookie).

## Podgląd lokalny

Dowolny statyczny serwer, np.:

```bash
python3 -m http.server 8095      # → http://localhost:8095
```

(Otwarcie `index.html` przez `file://` też działa, ale fonty/WebP lepiej sprawdzać po HTTP.)

## Wdrożenie

Wrzucić zawartość katalogu na dowolny statyczny hosting — Netlify, Vercel,
GitHub Pages, Cloudflare Pages albo nginx/Apache. Nic do zbudowania.

## Wydajność

Fonty samohostowane (subset łaciński, 3 pliki variable), obrazy w WebP z
fallbackiem JPG (`<picture>`), CSS inline, preload fontów, `defer`/`lazy`.
Pierwszy ekran ~275 KB.
