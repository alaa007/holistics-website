@php $trail = $trail ?? []; @endphp
<div class="breadcrumb">
  @foreach($trail as $i => $item)
    @if($item['url'] ?? null)
      <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
    @else
      <span>{{ $item['label'] }}</span>
    @endif
    @if($i < count($trail) - 1)<span>/</span>@endif
  @endforeach
</div>
