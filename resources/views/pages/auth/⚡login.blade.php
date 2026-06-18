<?php

use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use App\View\Components\BaseComponent;

new #[Layout('layouts::auth')] class extends BaseComponent
{
    #[Validate('required|email')] 
    public string $email = '';
 
    #[Validate('required|string')] 
    public string $password = '';

    public function userLogin()
    {
        $this->validate();

        $params = [
            'email' => $this->email,
            'password' => $this->password
        ];

        return $this->login($params);
    }

    public function demoLogin()
    {
        $params = [
            'email'    => config('users.demo.email'),
            'password' => config('users.demo.password'),
        ];

        return $this->login($params);
    }

    private function login(array $params)
    {
        if (Auth::attempt($params)) {
            $this->notify(ToastEnum::SUCCESS, 'You have successfully logged in', '/');
        }
        $this->notify(ToastEnum::ERROR, 'Login was unsuccessful');
    }
};
?>

<div class="max-w-md mx-auto">
    <div class="text-4xl font-semibold text-center mb-4">DevJobs</div>
    <x-form wire:submit="userLogin">
        <x-input label="E-mail" wire:model="email" />
        <x-password label="Password" wire:model="password" />
        <x-slot:actions>
            <div class="w-full flex justify-between">
                <x-button
                    label="Use Demo account"
                    class="btn-ghost"
                    wire:click="demoLogin()" />
                <x-button
                    label="Login"
                    class="btn-primary"
                    type="submit"
                    spinner="save" />
            </div>
        </x-slot:actions>
    </x-form>
</div>