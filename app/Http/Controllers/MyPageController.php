<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\MyPageService;
use Carbon\Carbon;

class MyPageController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $events = $user->events;
        $fromTodayEvents = MyPageService::reservedEvent($events,'fromToday');
        $pastEvents = MyPageService::reservedEvent($events,'past');

        // dd($user,$events,$fromTodayEvents,$pastEvents);

        return view('mypage/index',compact('fromTodayEvents','pastEvents'));

    }
    //
    public function show($id)
    {
        $event = Event::findOrFail($id);
        $reservation = Reservation::where('user_id','=',Auth::id())
                        ->where('event_id','=',$id)
                        ->latest()  // 最新の情報を取得
                        ->first();
        return view('mypage/show',compact('event','reservation'));

    }
    //
    public function cancel($id)
    {
        $reservation = Reservation::where('user_id','=',Auth::id())
                        ->where('event_id','=',$id)
                        ->latest()  // 最新の情報を取得
                        ->first();
        // cancel日時をセット
        $reservation->canceled_date = Carbon::now()->format('Y-m-d H:i:s');
        $reservation->save();

        session()->flash('status','キャンセルできました');
        return to_route('dashboard');

    }
}
