<?php

namespace App\Livewire;

use Livewire\Component;

class Google extends Component
{
    public function loginWithGoogle()
    {
        return redirect()->route('login.google');
    }

    public function render()
    {
        return view('livewire.google');
    }
}