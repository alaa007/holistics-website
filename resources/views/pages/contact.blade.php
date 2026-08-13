@extends('layouts.app')

@section('content')

  <section class="page-hero">
    <div class="container">
      @include('partials.breadcrumb', ['trail' => [
        ['label' => __('site.breadcrumb_home'), 'url' => localized_route('home')],
        ['label' => __('site.nav.contact'), 'url' => null],
      ]])
      <div class="eyebrow">{{ __('site.contact.eyebrow') }}</div>
      <h1>{{ __('site.contact.title') }}</h1>
      <p>{{ __('site.contact.lead') }}</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="contact-grid">
        <div>
          <div class="contact-card">
            <div class="contact-item">
              <div class="icon"><x-icon name="map-pin" /></div>
              <div>
                <h4>{{ __('site.contact.address') }}</h4>
                <p>{{ $siteSettings->trans('address') }}</p>
              </div>
            </div>
            <div class="contact-item">
              <div class="icon"><x-icon name="phone" /></div>
              <div>
                <h4>{{ __('site.contact.call_whatsapp') }}</h4>
                <a href="{{ $siteSettings->phone_href }}" dir="ltr">{{ $siteSettings->phone_display }}</a>
              </div>
            </div>
            <div class="contact-item">
              <div class="icon"><x-icon name="mail" /></div>
              <div>
                <h4>{{ __('site.contact.email') }}</h4>
                <a href="mailto:{{ $siteSettings->email }}">{{ $siteSettings->email }}</a>
              </div>
            </div>
            <div class="contact-item">
              <div class="icon"><x-icon name="clock" /></div>
              <div>
                <h4>{{ __('site.contact.support') }}</h4>
                <p>{{ __('site.contact.support_text') }}</p>
              </div>
            </div>
          </div>
          <div class="map-frame">
            <iframe src="{{ $siteSettings->map_embed_src ?: 'https://www.google.com/maps?q=' . urlencode($siteSettings->map_query) . '&output=embed' }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
          </div>
        </div>
        <div>
          <div class="form-card">
            <h3 style="font-size:19px;font-weight:800;color:var(--teal-dark);margin-bottom:6px;">{{ __('site.contact.form_title') }}</h3>
            <p style="font-size:13.5px;color:var(--muted);margin-bottom:22px;">{{ __('site.contact.form_text') }}</p>

            @if(session('status') === 'sent')
              <div class="form-status">{{ __('site.contact.success') }}</div>
            @endif

            <form method="POST" action="{{ localized_route('contact.store') }}" data-inquiry-form>
              @csrf
              <div class="form-row">
                <div class="field">
                  <label for="f-name">{{ __('site.contact.name') }}</label>
                  <input type="text" id="f-name" name="name" required value="{{ old('name') }}" placeholder="{{ __('site.contact.name') }}">
                  @error('name')<div class="form-note">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                  <label for="f-phone">{{ __('site.contact.phone') }}</label>
                  <input type="tel" id="f-phone" name="phone" dir="ltr" required value="{{ old('phone') }}" placeholder="+962 xx xxx xxxx">
                  @error('phone')<div class="form-note">{{ $message }}</div>@enderror
                </div>
              </div>
              <div class="form-row">
                <div class="field">
                  <label for="f-email">{{ __('site.contact.email_field') }}</label>
                  <input type="email" id="f-email" name="email" required value="{{ old('email') }}" placeholder="you@example.com">
                  @error('email')<div class="form-note">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                  <label for="f-service">{{ __('site.contact.service_interest') }}</label>
                  <select id="f-service" name="service">
                    <option value="">{{ __('site.contact.general_inquiry') }}</option>
                    @foreach($services as $s)
                      <option value="{{ $s->slug }}" @selected(old('service') === $s->slug)>{{ $s->trans('title') }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="field">
                <label for="f-message">{{ __('site.contact.message') }}</label>
                <textarea id="f-message" name="message" required placeholder="{{ __('site.contact.form_text') }}">{{ old('message') }}</textarea>
                @error('message')<div class="form-note">{{ $message }}</div>@enderror
              </div>
              <button type="submit" class="btn btn-primary btn-block">{{ __('site.contact.send') }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
