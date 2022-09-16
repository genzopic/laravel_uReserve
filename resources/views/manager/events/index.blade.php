<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            本日以降のイベント一覧
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- <x-jet-welcome /> --}}
                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-4 mx-auto">
                      @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                      @endif
                      
                      <div class="flex justify-between">
                        <button onclick="location.href='{{ route('events.past') }}'" class="flex mb-4 ml-auto text-white bg-green-500 border-0 py-2 px-6 focus:outline-none hover:bg-green-600 rounded">過去のイベント一覧</button>
                        <button onclick="location.href='{{ route('events.create') }}'" class="flex mb-4 ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">新規登録</button>  
                      </div>
                      <div class="w-full mx-auto overflow-auto">
                        <table class="table-auto w-full text-left whitespace-no-wrap">
                          <thead>
                            <tr>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">イベント名</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">開始日時</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">終了日時</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">予約人数</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">定員</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">表示・非表示</th>
                              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">操作</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($events as $event)
                            <tr class="">
                                <td class="text-blue-500 px-4 py-3"><a href="{{ route('events.show',[ 'event' => $event->id ]) }}">{{ $event->name }}</a></td>
                                <td class="px-4 py-3">{{ $event->start_date }}</td>
                                <td class="px-4 py-3">{{ $event->end_date }}</td>
                                <td class="px-4 py-3">
                                  @if (is_null($event->number_of_people))
                                    0
                                  @else
                                    {{ $event->number_of_people }}
                                  @endif
                                </td>
                                <td class="px-4 py-3">{{ $event->max_people }}</td>
                                <td class="px-4 py-3">{{ $event->is_visible }}</td>
                                <td class="">
                                  <div class="flex">
                                    <form class="" id="delete_{{ $event->id }}" method="post" action="{{ route('events.destroy',[ 'event' => $event->id ]) }}">
                                      @csrf
                                      @method('delete')
                                      <a class="text-sm p-1 border-0 bg-green-100 hover:bg-green-200 rounded" href="{{ route('events.edit',[ 'event' => $event->id ]) }}">編集</a><br>
                                      <a class="text-sm p-1 border-0 text-white bg-red-400 focus:outline-none hover:bg-red-500 rounded" href="#" data-id="{{ $event->id }}" onclick="deletePost(this)" >削除</a>
                                    </form>
                                  </div>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                        {{ $events->links() }}
                    </div>
                      <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                        
                      </div>
                    </div>
                  </section>

            </div>
        </div>
    </div>
    <script>
      function deletePost(e) {
        'use strict';
        if (confirm('本当に削除してもいいですか?')) {
          document.getElementById('delete_' + e.dataset.id).submit(); 
        }
      }
    </script>
</x-app-layout>
