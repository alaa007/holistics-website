@extends('layouts.app')

@section('title', 'Holistics — Integrated Home Healthcare & Medical Supplies in Amman, Jordan')
@section('description', 'Holistics provides home healthcare, professional nursing, physiotherapy, medical equipment and supplies in Amman, Jordan. Healing the whole you.')

@section('content')

  <section class="hero-slider">
    @foreach($slides as $i => $slide)
      <div class="hero-slide{{ $i === 0 ? ' active' : '' }}">
        <div class="slide-bg"></div>
        <div class="container hero-content">
          <div class="hero-copy">
            <div class="eyebrow">{{ $slide->trans('eyebrow') }}</div>
            <h1>{{ $slide->trans('heading_prefix') }} <span>{{ $slide->trans('heading_highlight') }}</span></h1>
            <p>{{ $slide->trans('text') }}</p>
            <div class="hero-actions">
              @if($slide->trans('cta1_label'))
                <a href="{{ $slide->cta1_url ?? '#' }}" class="btn btn-primary">{{ $slide->trans('cta1_label') }}</a>
              @endif
              @if($slide->trans('cta2_label'))
                <a href="{{ $slide->cta2_url ?? '#' }}" class="btn btn-outline">{{ $slide->trans('cta2_label') }}</a>
              @endif
            </div>
          </div>
          <div class="hero-visual">
            <div class="ring"><img src="{{ asset('assets/img/icon-mark.png') }}" alt="Holistics"></div>
          </div>
        </div>
      </div>
    @endforeach
    <button class="slider-arrow prev" aria-label="Previous slide"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg></button>
    <button class="slider-arrow next" aria-label="Next slide"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg></button>
    <div class="slider-dots"></div>
  </section>

  <section class="section section-alt">
    <div class="container">
      <div class="grid grid-2" style="align-items:center;gap:48px;">
        <div>
          <div class="section-tag">{{ __('site.home.about_tag') }}</div>
          <h2 class="section-title">{{ __('site.home.about_title') }}</h2>
          <p class="section-lead" style="margin-bottom:20px;">{{ __('site.home.about_text') }}</p>
          <a href="{{ route('about') }}" class="btn btn-dark">{{ __('site.home.learn_more') }} <x-icon name="arrow-right" /></a>
        </div>
        <div class="mv-card" style="margin:0;">
          <div class="icon"><x-icon name="target" /></div>
          <h3>{{ __('site.home.our_mission') }}</h3>
          <p>{{ $about->trans('mission') }}</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="section-head center">
        <div class="section-tag">{{ __('site.home.services_tag') }}</div>
        <h2 class="section-title">{{ __('site.home.services_title') }}</h2>
        <p class="section-lead">{{ __('site.home.services_lead') }}</p>
      </div>
      <div class="grid grid-4">
        @foreach($services as $s)
          <div class="card service-card">
            <div class="icon"><x-icon :name="$s->icon" /></div>
            <h3>{{ $s->trans('title') }}</h3>
            <p>{{ $s->trans('short') }}</p>
            <a href="{{ route('services.show', $s->slug) }}" class="link">{{ __('site.home.learn_more_short') }} <x-icon name="arrow-right" /></a>
          </div>
        @endforeach
      </div>
      <div class="text-center" style="margin-top:36px;">
        <a href="{{ route('services.index') }}" class="btn btn-dark">{{ __('site.home.view_all_services') }} <x-icon name="arrow-right" /></a>
      </div>
    </div>
  </section>

  <section class="section section-alt">
    <div class="container">
      <div class="section-head center">
        <div class="section-tag">{{ __('site.home.why_tag') }}</div>
        <h2 class="section-title">{{ __('site.home.why_title') }}</h2>
        <p class="section-lead">{{ __('site.home.why_lead') }}</p>
      </div>
      <div class="grid grid-3">
        @foreach($whyUs as $w)
          <div class="card why-card">
            <div class="icon"><x-icon :name="$w->icon" /></div>
            <p>{{ $w->trans('text') }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section class="section section-dark">
    <div class="container">
      <div class="section-head center">
        <div class="section-tag">{{ __('site.home.stats_tag') }}</div>
        <h2 class="section-title">{{ __('site.home.stats_title') }}</h2>
        <p class="section-lead">{{ __('site.home.stats_lead') }}</p>
      </div>
      <div class="stat-strip">
        @foreach($stats as $stat)
          <div class="stat-card">
            <div class="stat-icon"><x-icon :name="$stat->icon" /></div>
            <div class="stat-label">{{ $stat->trans('label') }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section class="section-tight">
    <div class="container">
      <div class="cta-band">
        <div>
          <h3>{{ __('site.home.cta_title') }}</h3>
          <p>{{ __('site.home.cta_text') }}</p>
        </div>
        <div class="cta-actions">
          <a href="https://wa.me/{{ $siteSettings->whatsapp_number }}" target="_blank" rel="noopener" class="btn btn-primary"><x-icon name="whatsapp" :filled="true" /> {{ __('site.home.whatsapp_us') }}</a>
          <a href="{{ $siteSettings->phone_href }}" class="btn btn-outline"><x-icon name="phone" :filled="true" /> {{ __('site.home.call_us') }}</a>
        </div>
      </div>
    </div>
  </section>

@endsection
