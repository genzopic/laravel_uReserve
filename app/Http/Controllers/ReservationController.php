<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class ReservationController extends Controller
{
    //
    public function dashboard()
    {
        return view('dashboard');
    }

    public function detail($id)
    {
        $event = Event::findOrFail($id);

        $reservedPeople = DB::table('reservations')
        ->select('event_id',DB::raw('sum(number_of_people) as number_of_people'))
        ->whereNull('canceled_date')
        ->groupBy('event_id')
        ->having('event_id',$event->id)
        ->first();

        if(!is_null($reservedPeople)){
            $reservablePeople = $event->max_people - $reservedPeople->number_of_people;
        } else {
            $reservablePeople = $event->max_people;
        }
        // dd($reservablePeople);
        return view('event-detail',compact('event','reservablePeople'));

    }

    public function reserve(Request $request)
    {
        $event = Event::findOrFail($request->id);

        $reservedPeople = DB::table('reservations')
        ->select('event_id',DB::raw('sum(number_of_people) as number_of_people'))
        ->whereNull('canceled_date')
        ->groupBy('event_id')
        ->having('event_id',$event->id)
        ->first();

        if(is_null($reservedPeople) || 
            $event->max_people >= $reservedPeople->number_of_people + $request->reserved_people){
            // 予約直前に、もう一度チェック
            // 最大人数よりも予約済み人数＋今回の人数が小さい場合は、予約可能
            // 予約情報を新規登録
            Reservation::create([
                'user_id' => Auth::id(),
                'event_id' => $request['id'],
                'number_of_people' => $request['reserved_people'],
            ]);

            session()->flash('status','登録OKです');
            return to_route('dashboard');               // laravel9
            // return redirect()->route('dashboard');   // laravel8

        } else {
            // 予約不可
            session()->flash('status','この人数は予約できません。');
            return to_route('dashboard');               // laravel9
            // return redirect()->route('dashboard');   // laravel8
    
        }
    }
}
