<?php
/**
 * Garage 37 theme functions.
 * Cała treść strony jest edytowalna w: Wygląd → Dostosuj (Customizer).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'G37_VER', '1.0.0' );

/* -------------------------------------------------------------------------
 * Theme setup
 * ---------------------------------------------------------------------- */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'style', 'script' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
} );

add_action( 'wp_enqueue_scripts', function () {
	// CSS jest inline'owany w <head> (g37 wp_head) — bez osobnego, blokującego żądania.
	// JS w stopce; w trybie SCRIPT_DEBUG ładujemy źródło zamiast .min.
	$min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	$uri = get_template_directory_uri();
	wp_enqueue_script( 'garage37-cookie', $uri . "/assets/js/cookie{$min}.js", array(), G37_VER, true );
	wp_localize_script( 'garage37-cookie', 'G37', array(
		'gtmId' => trim( (string) g37( 'gtm_id' ) ),
		'gaId'  => trim( (string) g37( 'ga_id' ) ),
	) );
} );

// Ładujemy skrypt stopki z atrybutem defer.
add_filter( 'script_loader_tag', function ( $tag, $handle ) {
	if ( 'garage37-cookie' === $handle && false === strpos( $tag, ' defer' ) ) {
		$tag = str_replace( ' src=', ' defer src=', $tag );
	}
	return $tag;
}, 10, 2 );

/* -------------------------------------------------------------------------
 * Content fields (single source of truth: defaults + Customizer registration)
 * ---------------------------------------------------------------------- */
function g37_fields() {
	static $fields = null;
	if ( null !== $fields ) {
		return $fields;
	}

	$fields = array(

		// --- Ogólne / kontakt ---
		'phone'       => array( 'section' => 'g37_general', 'type' => 'text',     'label' => 'Telefon',        'default' => '+48 607 305 480' ),
		'email'       => array( 'section' => 'g37_general', 'type' => 'email',    'label' => 'E-mail',         'default' => 'contact@garage37.pl' ),
		'address'     => array( 'section' => 'g37_general', 'type' => 'text',     'label' => 'Adres',          'default' => 'Tarnogórska 12, 44-100 Gliwice' ),
		'address_map' => array( 'section' => 'g37_general', 'type' => 'url',      'label' => 'Link do mapy (adres)', 'default' => 'https://maps.app.goo.gl/xZGYQCumGeS1xYcf6' ),
		'hours'       => array( 'section' => 'g37_general', 'type' => 'html',     'label' => 'Godziny otwarcia', 'default' => 'Pn–Pt&nbsp;07:00–18:00 · Sob&nbsp;08:00–13:00 · Niedziela&nbsp;nieczynne' ),
		'map_embed'   => array( 'section' => 'g37_general', 'type' => 'url',      'label' => 'Google Maps – adres osadzenia (embed src)', 'default' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2548.4738646874507!2d18.680977!3d50.30174840000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x471130531973a975%3A0x941722a42598af1a!2sTarnog%C3%B3rska%2012%2C%2044-102%20Gliwice%2C%20Polska!5e0!3m2!1spl!2sua!4v1743600722403!5m2!1spl!2sua' ),

		// --- Hero ---
		'hero_eyebrow' => array( 'section' => 'g37_hero', 'type' => 'text',     'label' => 'Nadtytuł',   'default' => 'Serwis samochodowy · Gliwice · od 2025' ),
		'hero_title'   => array( 'section' => 'g37_hero', 'type' => 'html',     'label' => 'Nagłówek (HTML: <br>, <span>)', 'default' => 'Niezawodny serwis<br>Twojego <span style="color:#e10600">auta.</span>' ),
		'hero_sub'     => array( 'section' => 'g37_hero', 'type' => 'textarea', 'label' => 'Opis',       'default' => 'Diagnostyka, naprawa i serwis — szybko, uczciwie i w dobrej cenie. Nowoczesny sprzęt i doświadczeni technicy w sercu Gliwic.' ),
		'hero_btn1'    => array( 'section' => 'g37_hero', 'type' => 'text',     'label' => 'Przycisk 1',  'default' => 'Umów wizytę' ),
		'hero_btn2'    => array( 'section' => 'g37_hero', 'type' => 'text',     'label' => 'Przycisk 2',  'default' => 'Zobacz usługi' ),

		// --- Statystyki ---
		'stat1_num'   => array( 'section' => 'g37_stats', 'type' => 'html', 'label' => 'Statystyka 1 – liczba', 'default' => '20<span style="color:#e10600">25</span>' ),
		'stat1_label' => array( 'section' => 'g37_stats', 'type' => 'text', 'label' => 'Statystyka 1 – opis',   'default' => 'rok otwarcia' ),
		'stat2_num'   => array( 'section' => 'g37_stats', 'type' => 'html', 'label' => 'Statystyka 2 – liczba', 'default' => '08' ),
		'stat2_label' => array( 'section' => 'g37_stats', 'type' => 'text', 'label' => 'Statystyka 2 – opis',   'default' => 'obszarów serwisu' ),
		'stat3_num'   => array( 'section' => 'g37_stats', 'type' => 'html', 'label' => 'Statystyka 3 – liczba', 'default' => '100<span style="color:#e10600">%</span>' ),
		'stat3_label' => array( 'section' => 'g37_stats', 'type' => 'text', 'label' => 'Statystyka 3 – opis',   'default' => 'gwarancji na pracę' ),
		'stat4_num'   => array( 'section' => 'g37_stats', 'type' => 'html', 'label' => 'Statystyka 4 – liczba', 'default' => '0' ),
		'stat4_label' => array( 'section' => 'g37_stats', 'type' => 'text', 'label' => 'Statystyka 4 – opis',   'default' => 'ukrytych opłat' ),

		// --- Zalety ---
		'zalety_heading' => array( 'section' => 'g37_zalety', 'type' => 'html',     'label' => 'Nagłówek (HTML)', 'default' => 'Dlaczego <span style="color:#e10600">Garage 37?</span>' ),
		'zaleta1_title'  => array( 'section' => 'g37_zalety', 'type' => 'text',     'label' => 'Zaleta 1 – tytuł', 'default' => 'Profesjonalizm' ),
		'zaleta1_desc'   => array( 'section' => 'g37_zalety', 'type' => 'textarea', 'label' => 'Zaleta 1 – opis',  'default' => 'Doświadczeni rzemieślnicy o wysokich kwalifikacjach.' ),
		'zaleta2_title'  => array( 'section' => 'g37_zalety', 'type' => 'text',     'label' => 'Zaleta 2 – tytuł', 'default' => 'Szybka obsługa' ),
		'zaleta2_desc'   => array( 'section' => 'g37_zalety', 'type' => 'textarea', 'label' => 'Zaleta 2 – opis',  'default' => 'Cenimy Twój czas i pracujemy terminowo.' ),
		'zaleta3_title'  => array( 'section' => 'g37_zalety', 'type' => 'text',     'label' => 'Zaleta 3 – tytuł', 'default' => 'Gwarancja' ),
		'zaleta3_desc'   => array( 'section' => 'g37_zalety', 'type' => 'textarea', 'label' => 'Zaleta 3 – opis',  'default' => 'Udzielamy gwarancji na każdą wykonaną pracę.' ),
		'zaleta4_title'  => array( 'section' => 'g37_zalety', 'type' => 'text',     'label' => 'Zaleta 4 – tytuł', 'default' => 'Uczciwa cena' ),
		'zaleta4_desc'   => array( 'section' => 'g37_zalety', 'type' => 'textarea', 'label' => 'Zaleta 4 – opis',  'default' => 'Jakość za rozsądne pieniądze, bez niespodzianek.' ),

		// --- Usługi (pusty tytuł = ukryta pozycja) ---
		'uslugi_heading' => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Nagłówek sekcji', 'default' => 'Zakres usług' ),
		'srv1_title' => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Usługa 1 – tytuł', 'default' => 'Diagnostyka komputerowa' ),
		'srv1_desc'  => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Usługa 1 – opis',  'default' => 'Odczyt błędów i pełna diagnostyka elektroniki.' ),
		'srv2_title' => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Usługa 2 – tytuł', 'default' => 'Wymiana oleju i filtrów' ),
		'srv2_desc'  => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Usługa 2 – opis',  'default' => 'Oleje i filtry dobrane do Twojego silnika.' ),
		'srv3_title' => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Usługa 3 – tytuł', 'default' => 'Naprawa silnika' ),
		'srv3_desc'  => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Usługa 3 – opis',  'default' => 'Diagnostyka i naprawa jednostki napędowej.' ),
		'srv4_title' => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Usługa 4 – tytuł', 'default' => 'Układ hamulcowy' ),
		'srv4_desc'  => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Usługa 4 – opis',  'default' => 'Klocki, tarcze i pełny serwis hamulców.' ),
		'srv5_title' => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Usługa 5 – tytuł', 'default' => 'Serwis zawieszenia' ),
		'srv5_desc'  => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Usługa 5 – opis',  'default' => 'Diagnostyka i naprawa układu zawieszenia.' ),
		'srv6_title' => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Usługa 6 – tytuł', 'default' => 'Autoelektryka' ),
		'srv6_desc'  => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Usługa 6 – opis',  'default' => 'Usterki elektryczne i montaż instalacji.' ),
		'srv7_title' => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Usługa 7 – tytuł', 'default' => 'Skrzynia biegów' ),
		'srv7_desc'  => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Usługa 7 – opis',  'default' => 'Diagnostyka, naprawa i serwis skrzyni.' ),
		'srv8_title' => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Usługa 8 – tytuł', 'default' => 'Klimatyzacja' ),
		'srv8_desc'  => array( 'section' => 'g37_uslugi', 'type' => 'text', 'label' => 'Usługa 8 – opis',  'default' => 'Napełnianie i odgrzybianie klimatyzacji.' ),

		// --- O nas ---
		'onas_heading' => array( 'section' => 'g37_onas', 'type' => 'text',     'label' => 'Nagłówek', 'default' => 'Kim jesteśmy?' ),
		'onas_p1'      => array( 'section' => 'g37_onas', 'type' => 'textarea', 'label' => 'Akapit 1', 'default' => 'Garage 37 to nowoczesny serwis samochodowy, w którym pracują doświadczeni technicy gotowi rozwiązać każdą usterkę w Twoim aucie. Zaawansowane technologie, nowoczesny sprzęt i wysokiej jakości części zamienne.' ),
		'onas_p2'      => array( 'section' => 'g37_onas', 'type' => 'textarea', 'label' => 'Akapit 2', 'default' => 'Naszym celem jest Twój komfort i pewność za kierownicą. Pracujemy uczciwie, bez ukrytych opłat, tłumacząc każdy etap naprawy.' ),
		'onas_chip1'   => array( 'section' => 'g37_onas', 'type' => 'text',     'label' => 'Znacznik 1', 'default' => 'Uczciwe ceny' ),
		'onas_chip2'   => array( 'section' => 'g37_onas', 'type' => 'text',     'label' => 'Znacznik 2', 'default' => 'Nowoczesny sprzęt' ),
		'onas_chip3'   => array( 'section' => 'g37_onas', 'type' => 'text',     'label' => 'Znacznik 3', 'default' => 'Gwarancja na pracę' ),
		'onas_image'   => array( 'section' => 'g37_onas', 'type' => 'image',    'label' => 'Zdjęcie (domyślnie wbudowane)', 'default' => '' ),

		// --- Pasek CTA ---
		'cta_text' => array( 'section' => 'g37_cta', 'type' => 'html', 'label' => 'Tekst (HTML)', 'default' => 'Oddaj auto<br>w <span style="color:#e10600">dobre ręce.</span>' ),

		// --- Stopka ---
		'footer_copy' => array( 'section' => 'g37_footer', 'type' => 'text', 'label' => 'Copyright', 'default' => '© 2025 Garage 37 — Wszelkie prawa zastrzeżone · Gliwice' ),

		// --- SEO / meta ---
		'seo_title' => array( 'section' => 'g37_seo', 'type' => 'text',     'label' => 'Tytuł strony (meta title)', 'default' => 'Garage 37 — Serwis samochodowy w Gliwicach' ),
		'seo_desc'  => array( 'section' => 'g37_seo', 'type' => 'textarea', 'label' => 'Opis (meta description)',   'default' => 'Garage 37 – nowoczesny serwis samochodowy w Gliwicach. Diagnostyka komputerowa, naprawa silnika, hamulce, zawieszenie, klimatyzacja. Uczciwe ceny, gwarancja na pracę.' ),
		'og_image'  => array( 'section' => 'g37_seo', 'type' => 'image',    'label' => 'Obraz do udostępniania (OG image)', 'default' => '' ),

		// --- Analityka ---
		'gtm_id' => array( 'section' => 'g37_analytics', 'type' => 'text', 'label' => 'ID Google Tag Manager (GTM-…)', 'default' => 'GTM-5Q2V4J23' ),
		'ga_id'  => array( 'section' => 'g37_analytics', 'type' => 'text', 'label' => 'ID Google Analytics 4 (G-…, opcjonalnie)', 'default' => '' ),
	);

	return $fields;
}

/** Get a field value (Customizer override or default). */
function g37( $key ) {
	$fields = g37_fields();
	$default = isset( $fields[ $key ]['default'] ) ? $fields[ $key ]['default'] : '';
	return get_theme_mod( $key, $default );
}
/** Escaped plain-text echo. */
function g37_e( $key ) {
	echo esc_html( g37( $key ) );
}
/** Sanitized inline-HTML echo (allows <br>, <span style>). */
function g37_html( $key ) {
	echo wp_kses_post( g37( $key ) );
}
/** tel: value derived from the phone field. */
function g37_tel() {
	return preg_replace( '/[^0-9+]/', '', g37( 'phone' ) );
}

/* -------------------------------------------------------------------------
 * Customizer registration
 * ---------------------------------------------------------------------- */
add_action( 'customize_register', function ( $wp ) {
	$wp->add_panel( 'g37', array( 'title' => 'Treść — Garage 37', 'priority' => 5 ) );

	$sections = array(
		'g37_general'   => 'Ogólne / kontakt',
		'g37_hero'      => 'Hero',
		'g37_stats'     => 'Statystyki',
		'g37_zalety'    => 'Zalety',
		'g37_uslugi'    => 'Usługi',
		'g37_onas'      => 'O nas',
		'g37_cta'       => 'Pasek CTA',
		'g37_footer'    => 'Stopka',
		'g37_seo'       => 'SEO / meta',
		'g37_analytics' => 'Analityka Google',
	);
	$i = 10;
	foreach ( $sections as $id => $title ) {
		$wp->add_section( $id, array( 'title' => $title, 'panel' => 'g37', 'priority' => $i ) );
		$i += 5;
	}

	$sanitizers = array(
		'text'     => 'sanitize_text_field',
		'textarea' => 'sanitize_textarea_field',
		'html'     => 'wp_kses_post',
		'url'      => 'esc_url_raw',
		'email'    => 'sanitize_email',
		'image'    => 'esc_url_raw',
	);

	foreach ( g37_fields() as $key => $cfg ) {
		$type = $cfg['type'];
		$wp->add_setting( $key, array(
			'default'           => $cfg['default'],
			'sanitize_callback' => isset( $sanitizers[ $type ] ) ? $sanitizers[ $type ] : 'sanitize_text_field',
			'transport'         => 'refresh',
		) );

		if ( 'image' === $type ) {
			$wp->add_control( new WP_Customize_Image_Control( $wp, $key, array(
				'label'   => $cfg['label'],
				'section' => $cfg['section'],
			) ) );
			continue;
		}

		$control_type = 'text';
		if ( in_array( $type, array( 'textarea', 'html' ), true ) ) {
			$control_type = 'textarea';
		} elseif ( 'email' === $type ) {
			$control_type = 'email';
		} elseif ( 'url' === $type ) {
			$control_type = 'url';
		}

		$wp->add_control( $key, array(
			'label'   => $cfg['label'],
			'section' => $cfg['section'],
			'type'    => $control_type,
		) );
	}
} );

/* -------------------------------------------------------------------------
 * Meta tags: title, description, Open Graph, Twitter, preconnect
 * ---------------------------------------------------------------------- */
add_filter( 'pre_get_document_title', function ( $title ) {
	$custom = trim( (string) g37( 'seo_title' ) );
	return $custom !== '' ? $custom : $title;
} );

add_action( 'wp_head', function () {
	$desc  = trim( (string) g37( 'seo_desc' ) );
	$title = trim( (string) g37( 'seo_title' ) );
	if ( '' === $title ) {
		$title = wp_get_document_title();
	}
	$og = g37( 'og_image' );
	if ( '' === trim( (string) $og ) ) {
		$og = get_template_directory_uri() . '/assets/img/hero.jpg';
	}
	$url = home_url( '/' );

	$uri = get_template_directory_uri();
	$tpl = get_template_directory();

	echo "\n";
	echo '<link rel="icon" type="image/svg+xml" href="' . esc_url( $uri . '/assets/img/favicon.svg' ) . '">' . "\n";

	// Preload samohostowanych fontów (subset łaciński), by tekst renderował się od razu.
	foreach ( array( 'archivo', 'jetbrainsmono', 'racingsans' ) as $font ) {
		echo '<link rel="preload" as="font" type="font/woff2" crossorigin href="'
			. esc_url( $uri . "/assets/fonts/{$font}.woff2" ) . '">' . "\n";
	}

	// Krytyczny CSS inline (~2 KB) — brak blokującego renderowanie żądania.
	$css_file = $tpl . '/assets/css/main.min.css';
	$css = is_readable( $css_file ) ? file_get_contents( $css_file ) : '';
	if ( '' !== $css ) {
		$css = str_replace( 'url(../fonts/', 'url(' . $uri . '/assets/fonts/', $css );
		echo '<style id="garage37-css">' . $css . "</style>\n";
	}

	if ( $desc !== '' ) {
		echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $desc !== '' ) {
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $og ) . '">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $desc !== '' ) {
		echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	echo '<meta name="twitter:image" content="' . esc_url( $og ) . '">' . "\n";
}, 1 );
