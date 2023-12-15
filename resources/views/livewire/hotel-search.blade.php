<div class="relative">
    hotel: @if(empty($selHotel['name'])) <input
        type="text"
        class="form-input"
        placeholder="Search Hotels..."
        wire:model="query"
        wire:keydown.escape="resetter"
        wire:keydown.tab="resetter"
        wire:keydown.ArrowUp="decrementHighlight"
        wire:keydown.ArrowDown="incrementHighlight"
        wire:keydown.enter="selectCountry"
    />@else {{ $selHotel['name'] }} @endif
    <br />
    <div wire:loading class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg">
        <div class="list-item">Searching...</div>
    </div>

    @if(!empty($query))
        <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="resetter"></div>

        <div class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg">
            @if(!empty($hotels))
                @foreach($hotels as $i => $hotel)
                    <a
                        href="{{ route('f.onboarding', 'hotel_id='.$hotel['id']) }}"
                        class="list-item {{ $highlightIndex === $i ? 'highlight' : '' }}"
                    >{{ $hotel['name']['en'] }}</a>
                @endforeach
            @else
                <div class="list-item">No results!</div>
            @endif
        </div>
    @endif
    @if(!empty($selHotel['name']))
        <a
            href="{{ route('f.onboardLink', 'hotel_id='.$hotel['id']) }}"
            class="list-item"
        >generate link</a>

    @endif
</div>