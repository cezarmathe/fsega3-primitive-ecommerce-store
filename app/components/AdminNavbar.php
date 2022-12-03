<?php

namespace ECommerce\App\Components;

use ECommerce\App\Components\Component;

class AdminNavbar implements Component {
    public function render(): string {
        $html = <<<EOF
        <nav class="navbar">
            <a href="/index.php" class="navbar-item">Add product</a>
            <a href="/logout.php" class="navbar-item">Logout</a>
        </nav>
        EOF;

        return $html;
    }
}
