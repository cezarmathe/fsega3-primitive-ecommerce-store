<?php

namespace ECommerce\App\Components;

use ECommerce\App\Components\Component;

class Html implements Component {
    private Head $head;
    private Navbar | null $navbar;
    private Component $main;

    public function __construct(Head $head, Navbar $navbar, Component $main) {
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
                    {$this->navbar->render()}
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
