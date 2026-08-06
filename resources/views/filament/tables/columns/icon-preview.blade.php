@php $icon = $getState(); @endphp
@if($icon)
    <div style="display:flex;align-items:center;gap:0.5rem;">
        {!! \App\Support\Icons::svg($icon, style: 'width:1.1rem;height:1.1rem;flex-shrink:0;') !!}
        <span>{{ $icon }}</span>
    </div>
@endif
