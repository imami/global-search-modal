{{-- @php
    use Filament\Support\Facades\FilamentAsset;
    $debounce = filament()->getGlobalSearchDebounce();
    $keyBindings = filament()->getGlobalSearchKeyBindings();
    $suffix = filament()->getGlobalSearchFieldSuffix();
    $isClosedByClickingAway = $this->getConfigs()->isClosedByClickingAway();
    $isClosedByEscaping = $this->getConfigs()->isClosedByEscaping();
    $isSlideOver = $this->getConfigs()->isSlideOver();
    $position = $this->getConfigs()->getPosition();
    $top = $position?->getTop() ?: ($isSlideOver ? '0px' : '40px');
    $left = $position?->getLeft() ?? '50%';
    $right = $position?->getRight() ?? '50%';
    $bottom = $position?->getBottom() ?? '50%';

@endphp --}}

@aware([
    'debounce',
    'keyBindings',
    'suffix',
    'isClosedByClickingAway',
    'isClosedByEscaping',
    'isSlideOver',
    'top',
    'left',
    'right',
    'bottom',
])
<div 
    @class(['flex justify-center']) 
    x-ignore 
    ax-load
    ax-load-src="{{ FilamentAsset::getAlpineComponentSrc('global-search-modal-observer', 'charrafimed/global-search-modal') }}"
    x-load-css="[@js(FilamentAsset::getStyleHref('global-search-modal', 'charrafimed/global-search-modal'))]" 
    x-data="observer"
    >
    <div 
        class="fixed inset-0 z-40 overflow-y-auto" 
        role="dialog" 
        aria-modal="true" 
        style="display: none"
        x-show="$store.modalStore.open"
        @if ($isClosedByEscaping)
             x-on:keydown.escape.window="$store.modalStore.hideModal()" 
        @endif
        x-id="['modal-title']" 
        x-bind:aria-labelledby="$id('modal-title')">

        <!-- Overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50" x-show="$store.modalStore.open" x-transition.opacity>
        </div>

        <!-- Panel -->
        <div class="">
            <div class="relative flex min-h-screen items-center justify-center p-4" x-show="$store.modalStore.open"
                x-transition @if ($isClosedByClickingAway) x-on:click="$store.modalStore.hideModal()" @endif>

                <div style=" top: 100px;" @class([
                    'absolute bg-gray-800    py-1 px-0.5 shadow-lg',
                    'inset-y-0 overflow-y-auto  rounded-l-2xl right-0 max-w-sm w-full sm:w-1/2' => $isSlideOver,
                    'inset-x-0 border w-full rounded-xl max-w-xl mx-auto' => !$isSlideOver,
                ]) x-on:click.stop
                    x-trap.noscroll.inert="$store.modalStore.open">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</div>
