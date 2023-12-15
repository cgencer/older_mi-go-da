<div class="relative">
    country: @if( empty($selHotel['id']) && empty(app('request')->input('country')) ) <input
        type="text"
        class="form-input"
        placeholder="Search Countries..." 
        wire:model="query"
        wire:keydown.escape="resetter"
        wire:keydown.tab="resetter"
        wire:keydown.ArrowUp="decrementHighlight"
        wire:keydown.ArrowDown="incrementHighlight"
        wire:keydown.enter="selectCountry"
    />@else {{ $selCountry['name'] }} @endif
    <br />
    <div wire:loading class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg">
        <div class="list-item">Searching...</div>
    </div>

    @if(!empty($query))
        <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="resetter"></div>

        <div class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg">
            @if(!empty($countries))
                @foreach($countries as $i => $country)
                    <a
                        href="{{ route('f.onboarding', ['country' => $country['code']]) }}"
                        class="list-item {{ $highlightIndex === $i ? 'highlight' : '' }}"
                    >{{ $country['name']['en'] }}</a>
                @endforeach
            @else
                <div class="list-item">No results!</div>
            @endif
        </div>
    @endif
</div>