<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベント詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="max-w-2xl py-4 mx-auto">
                    <x-jet-validation-errors class="mb-4" />

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
            
                    <form method="get" action="{{ route('events.edit',[ 'event' => $event->id ]) }}">
                        
                        {{-- イベント名 --}}
                        <div class="mt-4">
                            <x-jet-label for="event_name" value="イベント名" />
                            {{ $event->name }}
                        </div>

                        {{-- イベント詳細 --}}
                        <div class="mt-4">
                            <x-jet-label for="information" value="イベント詳細" />
                            {!! nl2br(e($event->information)) !!}
                        </div>
                        
                        <div class="md:flex justify-between">
                            {{-- イベント日付 --}}
                            <div class="mt-4">
                                <x-jet-label for="event_date" value="イベント日付" />
                                <x-jet-input id="event_date" class="block mt-1 w-full" type="text" name="event_date" required />
                            </div>
                
                            {{-- 開始時間 --}}
                            <div class="mt-4">
                                <x-jet-label for="start_time" value="開始時間" />
                                <x-jet-input id="start_time" class="block mt-1 w-full" type="text" name="start_time" required />
                            </div>
        
                            {{-- 終了時間 --}}
                            <div class="mt-4">
                                <x-jet-label for="end_time" value="終了時間" />
                                <x-jet-input id="end_time" class="block mt-1 w-full" type="text" name="end_time" required />
                            </div>
                        </div>
                        <div class="md:flex justify-between items-end">
                            {{-- 定員人数 --}}
                            <div class="mt-4">
                                <x-jet-label for="max_people" value="定員人数" />
                                {{ $event->max_people }}
                            </div>
                            {{-- 表示有無 --}}
                            <div class="flex space-x-4 justify-center-aroud" >
                                <input type="radio" name="is_visible" value="1" checked>非表示
                                <input type="radio" name="is_visible" value="0">表示
                            </div>
                            {{-- 新規登録ボタン --}}
                            <x-jet-button>
                                編集する
                            </x-jet-button>
                        </div>
                    </form>    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
