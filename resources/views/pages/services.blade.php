@extends('layouts.app')

@section('content')

  <section class="page-hero">
    <div class="container">
      @include('partials.breadcrumb', ['trail' => [
        ['label' => __('site.breadcrumb_home'), 'url' => localized_route('home')],
        ['label' => __('site.nav.services'), 'url' => null],
      ]])
      <div class="eyebrow">{{ __('site.services.eyebrow') }}</div>
      <h1>{{ __('site.services.title') }}</h1>
      <p>{{ __('site.services.lead') }}</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="grid grid-3">
        @foreach($services as $s)
          <div class="card service-card">
            <div class="icon"><x-icon :name="$s->icon" /></div>
            <h3>{{ $s->trans('title') }}</h3>
            <p>{{ $s->trans('short') }}</p>
            <a href="{{ localized_route('services.show', $s->slug) }}" class="link">{{ __('site.home.learn_more_short') }} <x-icon name="arrow-right" /></a>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section class="section-tight section-alt">
    <div class="container">
      <div class="cta-band">
        <div>
          <h3>{{ __('site.services.cta_title') }}</h3>
          <p>{{ __('site.services.cta_text') }}</p>
        </div>
        <div class="cta-actions">
          <a href="{{ localized_route('services.show', 'healthcare-consultation') }}" class="btn btn-primary"><x-icon name="message-circle" :filled="true" /> {{ __('site.services.consult') }}</a>
          <a href="{{ localized_route('contact') }}" class="btn btn-outline"><x-icon name="arrow-right" :filled="true" /> {{ __('site.services.contact') }}</a>
        </div>
      </div>
    </div>
  </section>

@endsection
