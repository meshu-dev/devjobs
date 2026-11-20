<?php

use App\View\Components\BaseComponent;

new class extends BaseComponent
{
    #[Locked]
    public string $title;

    #[Locked]
    public ?string $subtitle = null;
};
?>

<header class="mb-6 lg:mb-8">
    <h1 class="text-[1.75rem] leading-tight font-bold tracking-tight text-balance lg:text-3xl">{{ $title }}</h1>
    @if ($subtitle)
        <p class="mt-1 text-muted">{{ $subtitle }}</p>
    @endif
</header>
