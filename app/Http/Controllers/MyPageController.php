<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\MyPageService;

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
}
