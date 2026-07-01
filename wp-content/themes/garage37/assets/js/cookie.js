(function () {
  'use strict';
  var KEY = 'garage37_cookie_consent';
  var cfg = window.G37 || {};
  var gaId = (cfg.gaId || '').trim();

  function store(get, val) {
    try { return get ? localStorage.getItem(KEY) : localStorage.setItem(KEY, val); }
    catch (e) { return null; }
  }

  function loadGA() {
    if (!gaId || gaId.indexOf('G-') !== 0 || gaId === 'G-XXXXXXXXXX') return; // brak realnego ID
    if (window.__ga37) return;
    window.__ga37 = true;
    var s = document.createElement('script');
    s.async = true;
    s.src = 'https://www.googletagmanager.com/gtag/js?id=' + gaId;
    document.head.appendChild(s);
    window.dataLayer = window.dataLayer || [];
    function gtag() { window.dataLayer.push(arguments); }
    window.gtag = gtag;
    gtag('js', new Date());
    gtag('config', gaId, { anonymize_ip: true });
  }

  document.addEventListener('DOMContentLoaded', function () {
    var banner  = document.getElementById('g37-cookie');
    var accept  = document.getElementById('g37-accept');
    var decline = document.getElementById('g37-decline');
    var reopen  = document.getElementById('g37-reopen');

    function show() { if (banner) banner.style.display = 'flex'; }
    function hide() { if (banner) banner.style.display = 'none'; }

    var consent = store(true);
    if (!consent) { show(); }
    else if (consent === 'granted') { loadGA(); }

    if (accept)  accept.addEventListener('click',  function () { store(false, 'granted'); hide(); loadGA(); });
    if (decline) decline.addEventListener('click', function () { store(false, 'denied');  hide(); });
    if (reopen)  reopen.addEventListener('click',  function (e) { e.preventDefault(); show(); });
  });
})();
