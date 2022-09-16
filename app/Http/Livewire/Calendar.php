<?php

namespace App\Http\Livewire;

use Livewire\Component;
//
use Carbon\CarbonImmutable;
use App\Services\EventService;

class Calendar extends Component
{
    public $currentDate;
    public $currentWeek;
    public $day;
    public $checkDay;       // 判定用
    public $dayOfWeek;      // 曜日
    public $sevenDaysLater;
    public $events;

    public function mount()
    {
        $this->currentDate = CarbonImmutable::today();
        $this->sevenDaysLater = $this->currentDate->addDays(7);
        $this->currentWeek = [];

        // イベント情報を取得
        $this->events = EventService::getWeekEvents(
            $this->currentDate->format('Y-m-d'),
            $this->sevenDaysLater->format('Y-m-d'));

        for($i = 0; $i < 7; $i++){
            $this->day = CarbonImmutable::today()->addDays($i)->format('m月d日');
            $this->checkDay = CarbonImmutable::today()->addDays($i)->format('Y-m-d');
            $this->dayOfWeek = CarbonImmutable::today()->addDays($i)->dayName;
            array_push($this->currentWeek,[
                'day' => $this->day,
                'checkDay' => $this->checkDay,
                'dayOfWeek' => $this->dayOfWeek,
            ]);
        }

        // dd($this->currentWeek);
    }

    /**
     * getDate function
     *
     * @param string $date
     * @return void
     */
    public function getDate($date)
    {
        $this->currentDate = $date;
        $this->sevenDaysLater = CarbonImmutable::parse($this->currentDate)->addDays(7);
        $this->currentWeek = [];

        // イベント情報を取得
        $this->events = EventService::getWeekEvents(
            $this->currentDate,
            $this->sevenDaysLater->format('Y-m-d'));

        for($i = 0; $i < 7; $i++){
            $this->day = CarbonImmutable::parse($this->currentDate)->addDays($i)->format('m月d日');
            $this->checkDay = CarbonImmutable::parse($this->currentDate)->addDays($i)->format('Y-m-d');
            $this->dayOfWeek = CarbonImmutable::parse($this->currentDate)->addDays($i)->dayName;
            array_push($this->currentWeek,[
                'day' => $this->day,
                'checkDay' => $this->checkDay,
                'dayOfWeek' => $this->dayOfWeek,
            ]);
        }
        // dd($this->currentWeek);

    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
