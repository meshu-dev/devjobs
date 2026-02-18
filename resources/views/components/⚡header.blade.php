<?php

use App\View\Components\BaseComponent;

new class extends BaseComponent
{
    #[Locked]
    public string $title;
};
?>

<div>
    <x-header :title="$title" separator class="!mb-4" />
</div>