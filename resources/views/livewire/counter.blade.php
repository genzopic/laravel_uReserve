<div style="text-align: center">
    {{-- Because she competes with no one, no one can compete with her. --}}
    <button wire:click="increment">+</button>
    <h1>{{ $count }}</h1>
    <div class="mb-8"></div>
    こんにちは{{ $name }}さん<br>
    {{-- オプションなし --}}
    <input type="text" wire:model="name">
    
    {{-- ２秒後のタイミング --}}
    {{-- <input type="text" wire:model.debounce.2000ms="name"> --}}

    {{-- フォーカスが外れたタイミング --}}
    {{-- <input type="text" wire:model.lazy="name"> --}}

    {{-- submitのタイミング --}}
    {{-- <input type="text" wire:model.defer="name"> --}}
    <br>
    <button wire:mouseover="mouseOver">マウスを合わせてね</button>
</div>
