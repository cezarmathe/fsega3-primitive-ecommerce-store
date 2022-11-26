<?php

namespace ECommerce\App\Components;

use ECommerce\App\Components\Component;

class Head implements Component {
    private string $title;

    public function __construct(string $title) {
        $this->title = $title;
    }

    public function render(): string {
        $html = <<<EOF
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="style.css">
            <title>{$this->title}</title>
        </head>
        EOF;

        return $html;
    }
}
