<?php

use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::auth')] class extends Component
{
    #[Validate('required|email')] 
    public string $email = '';
 
    #[Validate('required|string')] 
    public string $password = '';

    public function login()
    {
        $this->validate();

        $params = ['email' => $this->email, 'password' => $this->password];

        if (Auth::attempt($params)) {
            session()->regenerate();
            session()->flash('status', 'You have successfully logged in');

            return redirect('/');
        }
        session()->flash('status', 'Login was unsuccessful');
    }
};
?>

<div class="max-w-md mx-auto">
    <x-form wire:submit="login">
        <x-input label="E-mail" wire:model="email" />
        <x-password label="Password" wire:model="password" />
        <x-slot:actions>
            <x-button label="Login" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>