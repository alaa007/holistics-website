@extends('layouts.app')

@section('title', 'Our Medical Team — Holistics')
@section('description', "Meet the doctors, nurses, and specialists behind Holistics' integrated home healthcare services in Amman, Jordan.")

@section('content')

  <section class="page-hero">
    <div class="container">
      @include('partials.breadcrumb', ['trail' => [
        ['label' => __('site.breadcrumb_home'), 'url' => route('home')],
        ['label' => __('site.nav.team'), 'url' => null],
      ]])
      <div class="eyebrow">{{ __('site.team.eyebrow') }}</div>
      <h1>{{ __('site.team.title') }}</h1>
      <p>{{ __('site.team.lead') }}</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="team-toolbar">
        <div class="search-field">
          <x-icon name="search" />
          <input type="text" placeholder="{{ __('site.team.search_placeholder') }}" data-team-search aria-label="Search team">
        </div>
        <div class="filter-chips">
          <button class="active" data-specialty="all">{{ __('site.team.all_specialties') }}</button>
          @foreach($members->unique('specialty') as $m)
            <button data-specialty="{{ $m->specialty }}">{{ $m->trans('specialty_label') }}</button>
          @endforeach
        </div>
      </div>
      <div class="grid grid-3" data-team-grid>
        @foreach($members as $m)
          <div class="card team-card" data-specialty="{{ $m->specialty }}" data-name="{{ $m->trans('role') }}">
            <div class="avatar">
              @if($m->photoUrl())
                <img src="{{ $m->photoUrl() }}" alt="{{ $m->name }}">
              @else
                <x-icon name="user" :filled="true" />
              @endif
            </div>
            <h3>{{ $m->name ?: __('site.team.coming_soon') }}</h3>
            <div class="role">{{ $m->trans('role') }}</div>
            <p class="bio">{{ $m->trans('bio') }}</p>
            <span class="specialty-tag">{{ $m->trans('specialty_label') }}</span>
          </div>
        @endforeach
      </div>
      <div class="no-results">{{ __('site.team.no_results') }}</div>
      <p class="team-note">{{ __('site.team.note') }}</p>
    </div>
  </section>

@endsection
