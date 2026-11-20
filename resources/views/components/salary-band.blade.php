@props(['band'])

{{-- Job salary (ink) drawn over the user's target range (highlighter) on one scale --}}
@if ($band)
    <span {{ $attributes->class('relative inline-block h-2.5 w-28 shrink-0 rounded-full bg-base-300') }}
          role="img"
          aria-label="{{ $band->label }}"
          title="{{ $band->label }}">
        @if ($band->targetStart !== null)
            <span class="absolute inset-y-0 rounded-full bg-highlight"
                  style="left: {{ $band->targetStart }}%; width: {{ $band->targetWidth }}%"></span>
        @endif
        <span @class([
                  'absolute top-1/2 h-1 -translate-y-1/2 rounded-full',
                  'bg-base-content' => $band->fit !== 'below',
                  'bg-muted/60' => $band->fit === 'below',
              ])
              style="left: {{ $band->jobStart }}%; width: {{ $band->jobWidth }}%"></span>
    </span>
@endif
