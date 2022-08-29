<html>
    <head>
        @livewireStyles
    </head>
    <body>
        livewireテスト

        @if (session()->has('message'))
            {{-- フラッシュメッセージ --}}
            <div>
                {{ session('message') }}
            </div>
        @endif

        {{-- <livewire:counter /> --}}
        @livewire('counter')

        @livewireScripts
    </body>
</html>
