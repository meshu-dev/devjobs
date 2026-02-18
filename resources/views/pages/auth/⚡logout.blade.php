<?php

use Livewire\Component;

new class extends Component
{
    public function boot() 
    {
        Auth::logout();
        session()->invalidate();

        return redirect('/login');
    }
};
?>