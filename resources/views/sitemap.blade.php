<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach ($entries as $entry)
@foreach ($entry['urls'] as $locale => $url)
    <url>
        <loc>{{ $url }}</loc>
@foreach ($entry['urls'] as $altLocale => $altUrl)
        <xhtml:link rel="alternate" hreflang="{{ $altLocale }}" href="{{ $altUrl }}"/>
@endforeach
@isset($entry['urls']['en'])
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $entry['urls']['en'] }}"/>
@endisset
@if ($entry['lastmod'])
        <lastmod>{{ $entry['lastmod'] }}</lastmod>
@endif
    </url>
@endforeach
@endforeach
</urlset>
