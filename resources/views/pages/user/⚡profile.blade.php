<?php

use App\Actions\Profile\EditProfileAction;
use App\View\Components\BaseComponent;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends BaseComponent
{
    #[Validate('required|string')]
    public $name;
 
    #[Validate('required|numeric')]
    public $minSalary;

    #[Validate('required|numeric')]
    public $maxSalary;

    public function save()
    {
        $this->validate();

        $params = [
            'name'       => $this->name,
            'min_salary' => $this->minSalary,
            'max_salary' => $this->maxSalary,
        ];

        resolve(EditProfileAction::class)->execute($params);

        $this->success('Profile has been updated');
    }

    public function mount()
    {
        $user = Auth::user();

        $this->name      = $user->name;
        $this->minSalary = $user->profile->min_salary;
        $this->maxSalary = $user->profile->max_salary;
    }
};
?>

<div>
    <livewire:header title="Profile" />
    <x-form wire:submit="save" class="max-w-md">
        <x-input label="Name" wire:model="name" />
        <x-input label="Default money" wire:model="minSalary" prefix="GBP" money />
        <x-input label="Default money" wire:model="maxSalary" prefix="GBP" money />
        <x-slot:actions>
            <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>

@assets
    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@2.7.0/libs/currency.js"></script>
@endassets
