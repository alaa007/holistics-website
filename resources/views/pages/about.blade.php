@extends('layouts.app')

@section('content')

  <section class="page-hero">
    <div class="container">
      @include('partials.breadcrumb', ['trail' => [
        ['label' => __('site.breadcrumb_home'), 'url' => localized_route('home')],
        ['label' => __('site.nav.about'), 'url' => null],
      ]])
      <div class="eyebrow">{{ __('site.about.eyebrow') }}</div>
      <h1>{{ $about->trans('hero_title') }}</h1>
      <p>{{ $about->trans('hero_text') }}</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="grid grid-2" style="align-items:center;gap:48px;">
        <div>
          <div class="section-tag">{{ __('site.about.story_tag') }}</div>
          <h2 class="section-title">{{ __('site.about.story_title') }}</h2>
          <p class="section-lead" style="margin-bottom:14px;">{{ $about->trans('who_we_are_p1') }}</p>
          <p class="section-lead">{{ $about->trans('who_we_are_p2') }}</p>
        </div>
        <div class="mv-grid" style="grid-template-columns:1fr;">
          <div class="mv-card">
            <div class="icon"><x-icon name="eye" /></div>
            <h3>{{ __('site.about.vision') }}</h3>
            <p>{{ $about->trans('vision') }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section section-alt">
    <div class="container">
      <div class="mv-grid">
        <div class="mv-card">
          <div class="icon"><x-icon name="target" /></div>
          <h3>{{ __('site.about.mission') }}</h3>
          <p>{{ $about->trans('mission') }}</p>
        </div>
        <div class="mv-card">
          <div class="icon"><x-icon name="shield" /></div>
          <h3>{{ __('site.about.commitment') }}</h3>
          <p>{{ $about->trans('commitment') }}</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="section-head center">
        <div class="section-tag">{{ __('site.about.values_tag') }}</div>
        <h2 class="section-title">{{ __('site.about.values_title') }}</h2>
      </div>
      <div class="grid grid-5">
        @foreach($values as $v)
          <div class="card value-card">
            <div class="icon"><x-icon :name="$v->icon" /></div>
            <h4>{{ $v->trans('title') }}</h4>
            <p>{{ $v->trans('text') }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section class="section section-alt">
    <div class="container">
      <div class="section-head center">
        <div class="section-tag">{{ __('site.about.leadership_tag') }}</div>
        <h2 class="section-title">{{ __('site.about.team_title') }}</h2>
        <p class="section-lead">{{ $about->trans('team_intro') }}</p>
      </div>
      <div class="grid grid-4">
        @foreach($leadership as $l)
          <div class="card team-card">
            <div class="avatar">
              @if($l->photoUrl())
                <img src="{{ $l->photoUrl() }}" alt="{{ $l->trans('name') }}">
              @else
                {{ $l->initials() }}
              @endif
            </div>
            <h3>{{ $l->trans('name') }}</h3>
            <div class="role">{{ $l->trans('role') }}</div>
            <p class="bio">{{ $l->trans('bio') }}</p>
            <span class="specialty-tag">{{ $l->credentials }}</span>
          </div>
        @endforeach
      </div>
      @if($about->trans('advisory_note'))
        <div class="commitment-block" style="margin-top:36px;text-align:left;">
          <div class="section-tag" style="margin-bottom:8px;">{{ __('site.about.advisory') }}</div>
          <p style="margin-inline:0;">{{ $about->trans('advisory_note') }}</p>
        </div>
      @endif
    </div>
  </section>

@endsection
