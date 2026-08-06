@extends('layouts.app')

@section('title', $service->trans('title') . ' — Holistics')
@section('description', $service->trans('short'))

@section('content')

  <section class="page-hero">
    <div class="container">
      @include('partials.breadcrumb', ['trail' => [
        ['label' => __('site.breadcrumb_home'), 'url' => route('home')],
        ['label' => __('site.nav.services'), 'url' => route('services.index')],
        ['label' => $service->trans('title'), 'url' => null],
      ]])
      <div class="eyebrow">{{ __('site.nav.services') }}</div>
      <h1>{{ $service->trans('title') }}</h1>
      <p>{{ $service->trans('short') }}</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="detail-body">
        <div>
          <div class="detail-icon-block"><x-icon :name="$service->icon" /></div>
          <h2>{{ __('site.services.overview') }}</h2>
          <p>{{ $service->trans('overview') }}</p>
          <h2>{{ __('site.services.included') }}</h2>
          <ul class="check-list">
            @foreach($service->transLines('included') as $line)
              <li><x-icon name="check-circle" /><span>{{ $line }}</span></li>
            @endforeach
          </ul>
          <h2>{{ __('site.services.who') }}</h2>
          <p>{{ $service->trans('who') }}</p>
        </div>
        <aside>
          <div class="sidebar-card sidebar-cta">
            <h4 style="color:#fff;">{{ __('site.services.get_started') }}</h4>
            <p>{{ __('site.services.get_started_text') }}</p>
            <a href="https://wa.me/{{ $siteSettings->whatsapp_number }}" target="_blank" rel="noopener" class="btn btn-primary btn-block"><x-icon name="whatsapp" :filled="true" /> {{ __('site.home.whatsapp_us') }}</a>
            <a href="{{ $siteSettings->phone_href }}" class="btn btn-outline btn-block"><x-icon name="phone" :filled="true" /> {{ __('site.services.call') }} {{ $siteSettings->phone_display }}</a>
          </div>
          <div class="sidebar-card">
            <h4>{{ __('site.services.other_services') }}</h4>
            <ul>
              @foreach($others as $o)
                <li><a href="{{ route('services.show', $o->slug) }}">{{ $o->trans('title') }} <x-icon name="chevron-right" /></a></li>
              @endforeach
            </ul>
          </div>
        </aside>
      </div>
    </div>
  </section>

@endsection
