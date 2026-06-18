<?php

use App\Actions\Profile\EditProfileAction;
use App\View\Components\BaseComponent;
use App\View\Enums\ToastEnum;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends BaseComponent
{
    #[Validate('required|string|min:2|max:100')]
    public string $name;

    public int $minSalary;

    public int $maxSalary;

    protected function rules()
    {
        $minSalaryLimit = config('users.min_salary_limit');
        $maxSalaryLimit = config('users.max_salary_limit');

        return [
            'minSalary' => [
                'required',
                'numeric',
                "between:$minSalaryLimit,$maxSalaryLimit",
                'lt:maxSalary',
            ],
            'maxSalary' => [
                'required',
                'numeric',
                "between:$minSalaryLimit,$maxSalaryLimit",
                'gt:minSalary',
            ],
        ];
    }

    public function save()
    {
        $this->validate();

        $params = [
            'name'       => $this->name,
            'min_salary' => $this->minSalary,
            'max_salary' => $this->maxSalary,
        ];

        resolve(EditProfileAction::class)->execute($params);

        $this->notify(ToastEnum::SUCCESS, 'Profile has been updated');
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
        <x-input label="Minimum Salary" wire:model="minSalary" prefix="GBP" money />
        <x-input label="Maximum Salary" wire:model="maxSalary" prefix="GBP" money />
        <x-slot:actions>
            <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>

@assets
    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@2.7.0/libs/currency.js"></script>
@endassets
