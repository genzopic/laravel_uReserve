<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservedPeople = DB::table('reservations')
                    ->select('event_id',DB::raw('sum(number_of_people) as number_of_people'))
                    ->whereNull('canceled_date')
                    ->groupBy('event_id');

        $events = DB::table('events')
                    ->leftJoinSub($reservedPeople,'reservedPeople',function($join){
                        $join->on('events.id','=','reservedPeople.event_id');
                    })
                    ->whereDate('start_date','>=',Carbon::today())
                    ->orderBy('start_date','asc')
                    ->paginate(10);

        return view('manager.events.index',compact('events'));
    }

    public function past()
    {
        $reservedPeople = DB::table('reservations')
                    ->select('event_id',DB::raw('sum(number_of_people) as number_of_people'))
                    ->whereNull('canceled_date')
                    ->groupBy('event_id');
        
        $events = DB::table('events')
                    ->leftJoinSub($reservedPeople,'reservedPeople',function($join){
                        $join->on('events.id','=','reservedPeople.event_id');
                    })
                    ->whereDate('start_date','<',Carbon::today())
                    ->orderBy('start_date','desc')
                    ->paginate(10);
        
        return view('manager.events.past',compact('events'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('manager.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        // ????????????????????????????????????
        $check = EventService::checkEventDuplication($request['event_date'],
                                                     $request['start_time'],
                                                     $request['end_time']);
        if($check){
            session()->flash('status','????????????????????????????????????????????????????????????');
            return view('manager.events.create');
        };

        // ???????????????????????????????????????
        $startDate = EventService::joinDateAndTime($request['event_date'],$request['start_time']);
        $endDate = EventService::joinDateAndTime($request['event_date'],$request['end_time']);

        // ?????????????????????????????????
        Event::create([
            'name' => $request['event_name'],
            'information' => $request['information'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'max_people' => $request['max_people'],
            'is_visible' => $request['is_visible'],
        ]);

        session()->flash('status','??????OK??????');
        return to_route('events.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
        $event = Event::findOrFail($event->id);
        // $eventDate = $event->eventDate;
        // $startTime = $event->startTime;
        // $endTime = $event->endTime;
        // dd($eventDate,$startTime,$endTime);

        $users = $event->users;
        $reservations = [];
        foreach($users as $user)
        {
            $reservedInfo = [
                'name' => $user->name,
                'number_of_people' => $user->pivot->number_of_people,
                'canceled_date' => $user->pivot->canceled_date,
            ];
            array_push($reservations,$reservedInfo);
        }
        // dd($reservations);
        // dd($event,$users);

        return view('manager.events.show',compact('event','users','reservations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
        $event = Event::findOrFail($event->id);
        // $eventDate = $event->eventDate;
        // $startTime = $event->startTime;
        // $endTime = $event->endTime;
        // dd($eventDate,$startTime,$endTime);

        return view('manager.events.edit',compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        //
        // ????????????????????????????????????
        $check = EventService::countEventDuplication($request['event_date'],
                                                     $request['start_time'],
                                                     $request['end_time']);
        if($check > 1){
            session()->flash('status','????????????????????????????????????????????????????????????');
            return view('manager.events.edit',compact('event'));
        };

        // ???????????????????????????????????????
        $startDate = EventService::joinDateAndTime($request['event_date'],$request['start_time']);
        $endDate = EventService::joinDateAndTime($request['event_date'],$request['end_time']);

        // ???????????????????????????
        $event->name = $request['event_name'];
        $event->information = $request['information'];
        $event->start_date = $startDate;
        $event->end_date = $endDate;
        $event->max_people = $request['max_people'];
        $event->is_visible = $request['is_visible'];
        $event->save();

        session()->flash('status','??????????????????');
        return to_route('events.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Event::findOrFail($id)->delete();

        session()->flash('status','??????????????????');
        return to_route('events.index');
        
    }

}
