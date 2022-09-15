<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベント詳細
        </h2>
    </x-slot>

    <div class="pt-4 pb-2">
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
                                {{ $event->eventDate }}
                            </div>
                
                            {{-- 開始時間 --}}
                            <div class="mt-4">
                                <x-jet-label for="start_time" value="開始時間" />
                                {{ $event->startTime }}
                            </div>
        
                            {{-- 終了時間 --}}
                            <div class="mt-4">
                                <x-jet-label for="end_time" value="終了時間" />
                                {{ $event->endTime }}
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
                                @if ($event->is_visible)
                                    表示中
                                @else
                                    非表示
                                @endif
                            </div>
                            {{-- 新規登録ボタン --}}
                            @if ($event->event_date >= \Carbon\Carbon::today()->format('Y年m月d日'))
                                <x-jet-button>
                                    編集する
                                </x-jet-button>
                            @endif
                        </div>
                    </form>    
                </div>
            </div>
        </div>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="max-w-2xl py-4 mx-auto">
                    @if (!$users->isEmpty())
                        <div class="text-center py-2">予約状況</div>
                        <table class="table-auto w-full text-left whitespace-no-wrap">
                            <thead>
                              <tr>
                                <th class="px-4 py-2 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">予約者名</th>
                                <th class="px-4 py-2 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">予約人数</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($reservations as $reservation)
                                <tr class="">
                                    <td class="px-4 py-2">{{ $reservation['name'] }}</td>
                                    <td class="px-4 py-2">{{ $reservation['number_of_people'] }}</td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                    @endif
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
