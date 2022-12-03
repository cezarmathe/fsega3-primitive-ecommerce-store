<?php

namespace ECommerce\App\Components;

use ECommerce\App\Entity\Order;

class OrderSpotlight implements Component {
    private Order $order;

    public function __construct(Order $order) {
        $this->order = $order;
    }

    public function render(): string {
        $html = <<<EOF
        <div class="order-spotlight">
            <h2>Order {$this->order->id}</h2>
        </div>
        EOF;

        return $html;
    }
}
