<?php

namespace ECommerce\App\Components;

use ECommerce\App\Components\Component;

class Html implements Component {
    private Head $head;
    private Component | null $navbar;
    private Component $main;

    public function __construct(Head $head, Component | null $navbar, Component $main) {
        $this->head = $head;
        $this->navbar = $navbar;
        $this->main = $main;
    }

    public function render(): string {
        $html = <<<EOF
        <html>
            {$this->head->render()}
            <body>
                <div class="app">
        EOF;

        if ($this->navbar) {
            $html .= $this->navbar->render();
        }

        $html .= <<<EOF
                    <main>
                        {$this->main->render()}
                    </main>
                </div>
            </body>
        </html>
        EOF;

        return $html;
    }
}
