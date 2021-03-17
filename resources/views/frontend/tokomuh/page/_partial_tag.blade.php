
<button class="btn tag {{ $flag ? 'active' : '' }}" wire:click="actionTag('{{ $key }}', '{{ $value }}')">{{ $value }}</button>