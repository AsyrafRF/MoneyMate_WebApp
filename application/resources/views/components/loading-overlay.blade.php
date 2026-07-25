{{-- resources/views/components/loading-overlay.blade.php --}}
@props(['message' => 'Sedang memproses...'])

<div id="loading-overlay" {{ $attributes->merge(['style' => 'display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center; flex-direction: column; color: white;']) }}>
    <div class="spinner-border mb-2" role="status"></div>
    <span>{{ $message }}</span>
</div>