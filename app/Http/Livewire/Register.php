<?php

namespace App\Http\Livewire;

use Livewire\Component;
//
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ];
    
    public $name;
    public $email;
    public $password;

    // 値が更新されると実行される（引数の名前はなんでもよい）
    public function updated($props)
    {
        // 入力しているフィールドのみバリデーションがかかる
        $this->validateOnly($props);

    }

    public function register()
    {
        // dd($this);

        $this->validate();
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('message','登録OKです');
        
        // laravel8まではこの書き方
        return redirect()->to(route('livewire-test.index'));
        // laravel9からはこれでもOK
        // return to_route('livewire-test.index');

    }
    public function render()
    {
        return view('livewire.register');
    }
}
