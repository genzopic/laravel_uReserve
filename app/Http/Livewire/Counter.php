<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;
    public $name = '';

    // renderの前に実行される
    public function mount()
    {

        $this->name = 'mount';
    }

    // 値が更新されると実行される
    public function updated()
    {
        $this->name = 'updated';

    }

    public function mouseOver()
    {
        $this->name = 'mouseover';
    }

    public function increment()
    {
        $this->count++;
    }
     
    public function render()
    {
        return view('livewire.counter');
    }
}
