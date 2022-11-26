<?php

namespace ECommerce\App\Components;

// A component is an object that can be rendered to HTML.
interface Component {
    // Render the component to HTML.
    //
    // Returns a string containing the HTML.
    public function render(): string;
}
