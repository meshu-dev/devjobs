<?php

namespace App\View\Components;

use App\View\Enums\ToastEnum;
use Livewire\Component;
use Mary\Traits\Toast;

class BaseComponent extends Component
{
    use Toast;

    public function successWithRedirect(string $message, string $url)
    {
        $type = ToastEnum::SUCCESS;

        $this->toast(
            type: $type->value,
            title: $message,
            icon: $type->getIcon(),
            css: $type->getCss(),
            redirectTo: $url
        );
    }
}
