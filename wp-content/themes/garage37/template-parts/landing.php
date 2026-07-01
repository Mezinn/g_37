<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$tel      = g37_tel();
$asset    = get_template_directory_uri() . '/assets/img';
$onas_custom = ( '' !== trim( (string) g37( 'onas_image' ) ) );
$onas_img    = $onas_custom ? trim( (string) g37( 'onas_image' ) ) : $asset . '/about.jpg';

// Zbierz widoczne usługi (pusty tytuł = ukryta pozycja).
$services = array();
for ( $i = 1; $i <= 8; $i++ ) {
	$t = g37( "srv{$i}_title" );
	if ( '' === trim( (string) $t ) ) {
		continue;
	}
	$services[] = array( 'title' => $t, 'desc' => g37( "srv{$i}_desc" ) );
}
$srv_count = count( $services );
?>
<div style="width:100%;max-width:1280px;margin:0 auto;background:#f1efea;overflow:hidden">

<!-- nav -->
<div class="g-sec" style="display:flex;align-items:center;justify-content:space-between;gap:20px;padding:18px 44px;border-bottom:2px solid #0d0d0d;position:sticky;top:0;background:#f1efea;z-index:20">
<svg height="34" viewBox="0 0 210 46" xmlns="http://www.w3.org/2000/svg" style="display:block" role="img" aria-label="Garage 37"><text x="0" y="35" textLength="206" lengthAdjust="spacingAndGlyphs" font-family="'Racing Sans One',Archivo,sans-serif" font-size="36" fill="#0d0d0d">GARAGE <tspan fill="#e10600">37</tspan></text></svg>
<div class="g-navlinks" style="display:flex;gap:26px;font:700 12px Archivo;text-transform:uppercase;letter-spacing:.05em">
<a class="g-link" href="#top">Główna</a><a class="g-link" href="#zalety">Zalety</a><a class="g-link" href="#uslugi">Usługi</a><a class="g-link" href="#onas">O nas</a><a class="g-link" href="#kontakt">Kontakt</a>
</div>
<a class="g-navcta g-cta" href="tel:<?php echo esc_attr( $tel ); ?>" style="background:#0d0d0d;color:#f1efea;padding:11px 20px;font:800 12px Archivo;text-transform:uppercase;letter-spacing:.04em;display:inline-block"><?php g37_e( 'phone' ); ?></a>
</div>

<!-- hero -->
<div id="top" class="g-sec g-hero" style="padding:56px 44px 44px;border-bottom:2px solid #0d0d0d">
<div class="g-eyebrow" style="display:inline-flex;align-items:flex-start;gap:10px;font:700 12px 'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:.12em;line-height:1.45;color:#5c584e;margin-bottom:22px"><span style="width:8px;height:8px;background:#e10600;display:inline-block;margin-top:3px;flex:none"></span><?php g37_e( 'hero_eyebrow' ); ?></div>
<h1 class="g-hero-h1" style="margin:0;font:900 clamp(46px,9vw,116px)/.88 Archivo;letter-spacing:-.04em;text-transform:uppercase"><?php g37_html( 'hero_title' ); ?></h1>
<div class="g-hero-row" style="display:flex;align-items:flex-end;justify-content:space-between;gap:40px;margin-top:34px;flex-wrap:wrap">
<p style="margin:0;font:500 clamp(16px,2vw,20px)/1.5 Archivo;color:#403d36;max-width:520px"><?php g37_e( 'hero_sub' ); ?></p>
<div style="display:flex;gap:12px;flex-wrap:wrap">
<a class="g-cta" href="#kontakt" style="background:#0d0d0d;color:#f1efea;padding:17px 32px;font:800 15px Archivo;text-transform:uppercase;letter-spacing:.04em"><?php g37_e( 'hero_btn1' ); ?></a>
<a class="g-cta" href="#uslugi" style="border:2px solid #0d0d0d;padding:15px 30px;font:800 15px Archivo;text-transform:uppercase;letter-spacing:.04em"><?php g37_e( 'hero_btn2' ); ?></a>
</div>
</div>
</div>

<!-- image band -->
<div class="g-band" style="height:340px;border-bottom:2px solid #0d0d0d;overflow:hidden;background:#e5e2db">
<picture>
<source srcset="<?php echo esc_url( $asset . '/hero.webp' ); ?>" type="image/webp">
<img src="<?php echo esc_url( $asset . '/hero.jpg' ); ?>" alt="Serwis Garage 37" width="1400" height="932" decoding="async" style="width:100%;height:100%;object-fit:cover;object-position:center 60%;display:block;filter:grayscale(1) contrast(1.06)" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&amp;fit=crop&amp;w=1700&amp;q=80'">
</picture>
</div>

<!-- stats -->
<div class="g-sec g-stats" style="display:flex;flex-wrap:wrap;gap:44px;padding:30px 44px;border-bottom:2px solid #0d0d0d;background:#0d0d0d;color:#f1efea">
<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
<div><div style="font:900 clamp(30px,4vw,44px) Archivo;letter-spacing:-.03em"><?php g37_html( "stat{$i}_num" ); ?></div><div style="font:600 12px 'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:.08em;color:#a8a396"><?php g37_e( "stat{$i}_label" ); ?></div></div>
<?php endfor; ?>
</div>

<!-- zalety -->
<div id="zalety" class="g-sec" style="padding:52px 44px 0">
<div style="display:flex;align-items:baseline;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:34px">
<h2 style="margin:0;font:900 clamp(34px,5vw,56px) Archivo;text-transform:uppercase;letter-spacing:-.03em"><?php g37_html( 'zalety_heading' ); ?></h2>
<span style="font:700 12px 'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:.08em;color:#8a8578">/ zalety</span>
</div>
</div>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:1px;background:#0d0d0d;border-top:2px solid #0d0d0d;border-bottom:2px solid #0d0d0d">
<?php for ( $i = 1; $i <= 4; $i++ ) :
	$dark = ( 4 === $i );
	$bg   = $dark ? '#0d0d0d' : '#f1efea';
	$col  = $dark ? 'color:#f1efea;' : '';
	$dcol = $dark ? '#a8a396' : '#5c584e';
?>
<div style="padding:34px 28px;background:<?php echo $bg; ?>;<?php echo $col; ?>"><div style="font:900 46px Archivo;letter-spacing:-.03em;color:#e10600"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></div><div style="font:800 19px Archivo;text-transform:uppercase;margin:14px 0 8px"><?php g37_e( "zaleta{$i}_title" ); ?></div><div style="font:500 14px/1.55 Archivo;color:<?php echo $dcol; ?>"><?php g37_e( "zaleta{$i}_desc" ); ?></div></div>
<?php endfor; ?>
</div>

<!-- uslugi -->
<div id="uslugi" class="g-sec" style="padding:52px 44px 6px">
<div style="display:flex;align-items:baseline;justify-content:space-between;flex-wrap:wrap;gap:12px">
<h2 style="margin:0;font:900 clamp(34px,5vw,56px) Archivo;text-transform:uppercase;letter-spacing:-.03em"><?php g37_e( 'uslugi_heading' ); ?></h2>
<span style="font:700 12px 'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:.08em;color:#8a8578">/ <?php echo esc_html( $srv_count ); ?> obszarów</span>
</div>
</div>
<div style="border-top:2px solid #0d0d0d">
<?php foreach ( $services as $idx => $s ) :
	$last = ( $idx === $srv_count - 1 );
	$bb   = $last ? 'border-bottom:2px solid #0d0d0d' : 'border-bottom:1px solid rgba(13,13,13,.18)';
?>
<a class="g-srv g-sec" style="display:flex;align-items:center;gap:24px;padding:22px 44px;<?php echo $bb; ?>"><span class="g-srv-num" style="font:900 22px Archivo;color:#bdb8ab;width:44px;flex:none"><?php echo esc_html( sprintf( '%02d', $idx + 1 ) ); ?></span><span class="g-srv-title" style="font:800 26px Archivo;text-transform:uppercase;letter-spacing:-.01em;flex:none"><?php echo esc_html( $s['title'] ); ?></span><span class="g-srv-desc" style="font:500 14px Archivo;color:#8a8578;flex:1"><?php echo esc_html( $s['desc'] ); ?></span><span class="g-srv-arrow" style="font:800 20px Archivo;flex:none">→</span></a>
<?php endforeach; ?>
</div>

<!-- o nas -->
<div id="onas" style="display:flex;flex-wrap:wrap;border-bottom:2px solid #0d0d0d">
<div class="g-onas-pad" style="flex:1 1 380px;padding:60px 48px;background:#0d0d0d;color:#f1efea;display:flex;flex-direction:column;justify-content:center">
<span style="font:700 12px 'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:.1em;color:#e10600">/ o nas</span>
<h2 style="margin:14px 0 0;font:900 clamp(32px,4.5vw,52px) Archivo;text-transform:uppercase;letter-spacing:-.03em"><?php g37_e( 'onas_heading' ); ?></h2>
<div style="width:56px;height:4px;background:#e10600;margin:22px 0 26px"></div>
<p style="margin:0 0 18px;font:500 16px/1.7 Archivo;color:#c8c3b6;max-width:520px"><?php g37_e( 'onas_p1' ); ?></p>
<p style="margin:0;font:500 16px/1.7 Archivo;color:#c8c3b6;max-width:520px"><?php g37_e( 'onas_p2' ); ?></p>
<div style="display:flex;flex-wrap:wrap;gap:16px 30px;margin-top:34px">
<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
<span style="display:flex;align-items:center;gap:10px;font:700 12px Archivo;text-transform:uppercase;letter-spacing:.06em"><span style="width:7px;height:7px;background:#e10600;display:inline-block"></span><?php g37_e( "onas_chip{$i}" ); ?></span>
<?php endfor; ?>
</div>
</div>
<div style="flex:1 1 380px;min-height:360px;overflow:hidden;background:#111"><picture>
<?php if ( ! $onas_custom ) : ?><source srcset="<?php echo esc_url( $asset . '/about.webp' ); ?>" type="image/webp"><?php endif; ?>
<img src="<?php echo esc_url( $onas_img ); ?>" alt="Garage 37" width="1100" height="1375" loading="lazy" decoding="async" style="width:100%;height:100%;min-height:360px;object-fit:cover;display:block;filter:grayscale(1) contrast(1.06)" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&amp;fit=crop&amp;w=1100&amp;q=80'"></picture></div>
</div>

<!-- CTA band -->
<div class="g-sec g-hero-row" style="display:flex;align-items:center;justify-content:space-between;gap:28px;flex-wrap:wrap;padding:52px 44px;border-bottom:2px solid #0d0d0d;background:#0d0d0d;color:#f1efea">
<div style="font:900 clamp(28px,4.2vw,48px)/1 Archivo;text-transform:uppercase;letter-spacing:-.03em"><?php g37_html( 'cta_text' ); ?></div>
<a class="g-cta" href="tel:<?php echo esc_attr( $tel ); ?>" style="background:#f1efea;color:#0d0d0d;padding:18px 36px;font:800 15px Archivo;text-transform:uppercase;letter-spacing:.04em;white-space:nowrap">Zadzwoń: <?php g37_e( 'phone' ); ?></a>
</div>

<!-- kontakt -->
<div id="kontakt" style="display:flex;flex-wrap:wrap">
<div class="g-onas-pad" style="flex:1 1 360px;padding:56px 44px;border-right:1px solid rgba(13,13,13,.2)">
<span style="font:700 12px 'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:.1em;color:#e10600">/ kontakt</span>
<h2 style="margin:14px 0 30px;font:900 clamp(32px,4.5vw,52px) Archivo;text-transform:uppercase;letter-spacing:-.03em">Kontakt z nami</h2>
<div style="display:flex;flex-direction:column;gap:24px">
<div><div style="font:700 12px 'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:.1em;color:#8a8578;margin-bottom:6px">Adres</div><a href="<?php echo esc_url( g37( 'address_map' ) ); ?>" style="font:700 20px Archivo"><?php g37_e( 'address' ); ?></a></div>
<div><div style="font:700 12px 'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:.1em;color:#8a8578;margin-bottom:6px">Godziny</div><div style="font:500 16px/1.6 Archivo;color:#403d36"><?php g37_html( 'hours' ); ?></div></div>
<div><div style="font:700 12px 'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:.1em;color:#8a8578;margin-bottom:6px">Telefon / e-mail</div><a href="tel:<?php echo esc_attr( $tel ); ?>" style="font:700 20px Archivo;display:block"><?php g37_e( 'phone' ); ?></a><a href="mailto:<?php echo esc_attr( g37( 'email' ) ); ?>" style="font:500 16px Archivo;color:#403d36"><?php g37_e( 'email' ); ?></a></div>
</div>
</div>
<div style="flex:1 1 360px;min-height:420px;position:relative;background:#111"><iframe src="<?php echo esc_url( g37( 'map_embed' ) ); ?>" style="width:100%;height:100%;min-height:420px;border:0;display:block;filter:grayscale(.35) contrast(1.05)" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Mapa — <?php echo esc_attr( g37( 'address' ) ); ?>"></iframe></div>
</div>

<!-- footer -->
<div class="g-sec g-hero-row" style="display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap;padding:30px 44px;border-top:2px solid #0d0d0d;background:#0d0d0d;color:#f1efea">
<svg height="40" viewBox="0 0 210 46" xmlns="http://www.w3.org/2000/svg" style="display:block" role="img" aria-label="Garage 37"><text x="0" y="35" textLength="206" lengthAdjust="spacingAndGlyphs" font-family="'Racing Sans One',Archivo,sans-serif" font-size="36" fill="#f1efea">GARAGE <tspan fill="#e10600">37</tspan></text></svg>
<div style="display:flex;flex-direction:column;gap:7px;align-items:flex-end">
<div style="font:600 12px 'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:.06em;color:#8a8578"><?php g37_e( 'footer_copy' ); ?></div>
<button id="g37-reopen" style="cursor:pointer;background:none;border:0;color:#8a8578;font:600 11px 'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:.06em;text-decoration:underline;padding:0">Ustawienia cookies</button>
</div>
</div>

</div>
