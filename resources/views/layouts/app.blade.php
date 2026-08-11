<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<x-seo />

<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon-32x32.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">
@if (app()->getLocale() === 'ar')
{{-- Rubik is self-hosted and declared in style.css; preload the Arabic
     subset so the text does not flash in a fallback face first. --}}
<link rel="preload" as="font" type="font/woff2" href="{{ asset('fonts/rubik/rubik-arabic.woff2') }}" crossorigin>
@endif
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<meta name="theme-color" content="#063b3f">
@stack('head')
</head>
<body>
@include('partials.header')

@yield('content')

@include('partials.footer')

<script src="{{ asset('assets/js/main.js') }}"></script>
@stack('scripts')
</body>
</html>
