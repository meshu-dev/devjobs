<?php

use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use App\View\Components\BaseComponent;
use App\View\Enums\ToastEnum;

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
            $this->notify(ToastEnum::SUCCESS, 'Logged in', '/');

            return;
        }

        $this->notify(ToastEnum::ERROR, 'Email or password is incorrect');
    }
};
?>

<div class="w-full max-w-sm">
    <h1 class="text-3xl font-bold tracking-tight">DevJobs</h1>
    <p class="mt-2 mb-8 text-muted">Developer jobs from Reed, Larajobs and Jobleads, collected every day.</p>

    <x-form wire:submit="userLogin" no-separator class="rounded-box border border-base-300 bg-base-100 p-6">
        <x-input label="Email" type="email" autocomplete="email" wire:model="email" />
        <x-password label="Password" autocomplete="current-password" wire:model="password" right />
        <x-slot:actions>
            <x-button
                label="Log in"
                class="btn-primary w-full"
                type="submit"
                spinner="userLogin" />
        </x-slot:actions>
    </x-form>

    <p class="mt-6 text-center text-sm text-muted">
        Just looking?
        <button type="button" wire:click="demoLogin()" class="cursor-pointer font-medium text-primary underline underline-offset-2">Use the demo account</button>
    </p>
</div>
