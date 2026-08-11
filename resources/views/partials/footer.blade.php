<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-col">
        <a href="{{ localized_route('home') }}" class="footer-brand">
          <img src="{{ asset('assets/img/icon-mark.png') }}" alt="Holistics">
          <span>{{ $siteSettings->brand_name ?? 'HOLISTICS' }}</span>
        </a>
        <p>{{ $siteSettings->trans('footer_about') }}</p>
        <div class="footer-social">
          <a href="https://wa.me/{{ $siteSettings->whatsapp_number ?? '962781818211' }}" target="_blank" rel="noopener" aria-label="WhatsApp"><x-icon name="whatsapp" :filled="true" /></a>
          <a href="{{ $siteSettings->phone_href ?? 'tel:+962781818211' }}" aria-label="Call"><x-icon name="phone" :filled="true" /></a>
          <a href="mailto:{{ $siteSettings->email ?? 'info@holistics-care.com' }}" aria-label="Email"><x-icon name="mail" :filled="true" /></a>
        </div>
      </div>
      <div class="footer-col">
        <h4>{{ __('site.footer.quick_links') }}</h4>
        <ul>
          <li><a href="{{ localized_route('about') }}">{{ __('site.nav.about') }}</a></li>
          <li><a href="{{ localized_route('services.index') }}">{{ __('site.nav.services') }}</a></li>
          <li><a href="{{ localized_route('team') }}">{{ __('site.nav.team') }}</a></li>
          <li><a href="{{ localized_route('contact') }}">{{ __('site.nav.contact') }}</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>{{ __('site.footer.services') }}</h4>
        <ul>
          @foreach($footerServices ?? [] as $s)
            <li><a href="{{ localized_route('services.show', $s->slug) }}">{{ $s->trans('title') }}</a></li>
          @endforeach
        </ul>
      </div>
      <div class="footer-col">
        <h4>{{ __('site.footer.get_in_touch') }}</h4>
        <ul class="footer-contact">
          <li><x-icon name="map-pin" :filled="true" /> <span>{{ $siteSettings->trans('address') }}</span></li>
          <li><x-icon name="phone" :filled="true" /> <a href="{{ $siteSettings->phone_href ?? '#' }}">{{ $siteSettings->phone_display ?? '' }}</a></li>
          <li><x-icon name="mail" :filled="true" /> <a href="mailto:{{ $siteSettings->email ?? '' }}">{{ $siteSettings->email ?? '' }}</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>&copy; <span data-year></span> {{ $siteSettings->brand_name ?? 'Holistics' }} — {{ $siteSettings->trans('tagline') }}. {{ __('site.footer.rights') }}</span>
    </div>
  </div>
</footer>
