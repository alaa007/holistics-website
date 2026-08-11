<header class="site-header">
  <div class="container header-inner">
    <a href="{{ route('home') }}" class="brand">
      <img src="{{ asset('assets/img/icon-mark.png') }}" alt="Holistics logo">
      <span class="brand-text">
        <span class="name">{{ $siteSettings->brand_name ?? 'HOLISTICS' }}</span>
        <span class="tag">{{ $siteSettings->trans('tagline') ?? 'Healing the whole you' }}</span>
      </span>
    </a>
    <nav class="main-nav" aria-label="Primary">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('site.nav.home') }}</a>
      <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">{{ __('site.nav.about') }}</a>
      <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">{{ __('site.nav.services') }}</a>
      <a href="{{ route('team') }}" class="{{ request()->routeIs('team') ? 'active' : '' }}">{{ __('site.nav.team') }}</a>
      <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">{{ __('site.nav.contact') }}</a>
    </nav>
    <div class="header-actions">
      @php($altLocale = app()->getLocale() === 'ar' ? 'en' : 'ar')
      {{-- Point at this same page in the other language, so the switcher is a
           real crawlable link rather than a session toggle. --}}
      <a class="icon-btn lang-switch" href="{{ \App\Support\Seo::localizedUrl($altLocale) ?? route('locale.switch', $altLocale) }}" hreflang="{{ $altLocale }}" aria-label="{{ app()->getLocale() === 'ar' ? 'English' : 'العربية' }}" title="{{ app()->getLocale() === 'ar' ? 'English' : 'العربية' }}">
        {{ app()->getLocale() === 'ar' ? 'EN' : 'AR' }}
      </a>
      <a class="icon-btn" href="https://wa.me/{{ $siteSettings->whatsapp_number ?? '962781818211' }}" target="_blank" rel="noopener" aria-label="{{ __('site.header.whatsapp') }}" title="{{ __('site.header.whatsapp') }}">
        <x-icon name="whatsapp" class="icon-wa" :filled="true" />
      </a>
      <a class="icon-btn" href="{{ $siteSettings->phone_href ?? 'tel:+962781818211' }}" aria-label="{{ __('site.header.call') }}" title="{{ __('site.header.call') }}">
        <x-icon name="phone" :filled="true" />
      </a>
      <button class="nav-toggle" aria-label="{{ __('site.header.menu') }}" aria-expanded="false">
        <x-icon name="menu" :filled="true" />
      </button>
    </div>
  </div>
</header>
