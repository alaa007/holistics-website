@php($seo = \App\Support\Seo::resolve())
<title>{{ $seo['title'] }}</title>
@if ($seo['description'])
<meta name="description" content="{{ $seo['description'] }}">
@endif
<meta name="robots" content="{{ $seo['noindex'] ? 'noindex, nofollow' : 'index, follow' }}">
@if ($seo['canonical'])
<link rel="canonical" href="{{ $seo['canonical'] }}">
@endif

{{-- Each language gets its own URL, so hreflang has something real to point at. --}}
@foreach ($seo['alternates'] as $altLocale => $altUrl)
<link rel="alternate" hreflang="{{ $altLocale }}" href="{{ $altUrl }}">
@endforeach
@if (isset($seo['alternates']['en']))
<link rel="alternate" hreflang="x-default" href="{{ $seo['alternates']['en'] }}">
@endif

<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $siteSettings->brand_name }}">
<meta property="og:title" content="{{ $seo['title'] }}">
@if ($seo['description'])
<meta property="og:description" content="{{ $seo['description'] }}">
@endif
@if ($seo['canonical'])
<meta property="og:url" content="{{ $seo['canonical'] }}">
@endif
<meta property="og:locale" content="{{ $seo['og_locale'] }}">
@foreach ($seo['og_locale_alternate'] as $ogAlternate)
<meta property="og:locale:alternate" content="{{ $ogAlternate }}">
@endforeach
@if ($seo['image'])
<meta property="og:image" content="{{ $seo['image'] }}">
@endif

<meta name="twitter:card" content="{{ $seo['image'] ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $seo['title'] }}">
@if ($seo['description'])
<meta name="twitter:description" content="{{ $seo['description'] }}">
@endif
@if ($seo['image'])
<meta name="twitter:image" content="{{ $seo['image'] }}">
@endif
