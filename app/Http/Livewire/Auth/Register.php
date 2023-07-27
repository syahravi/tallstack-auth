<?php

namespace App\Http\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Component;

class Register extends Component
{
    /** @var string */
    public $name = '';

    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var string */
    public $passwordConfirmation = '';

    protected $rules = [
        'name' => ['required'],
        'email' => ['required', 'email', 'unique:users'],
        'password' => ['required', 'min:8', 'same:passwordConfirmation'],
    ];
    protected $messages = [
        'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.same' => 'Password tidak sesuai.',
    ];
    public function register()
    {
        $this->validate();

        $user = User::create([
            'email' => $this->email,
            'name' => $this->name,
            'password' => Hash::make($this->password),
        ]);

        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->intended(route('home'));
    }

    public function render()
    {
        return view('livewire.auth.register')->extends('layouts.auth');
    }
}
