<?php

namespace ECommerce\App\Components;

class OrdersList implements Component {
    private array $orders;

    public function __construct(array $orders) {
        $this->orders = $orders;
    }

    public function render(): string {
        $html = <<<EOF
        <div class="orders-list">
            <h2>Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Order Total</th>
                    </tr>
                </thead>
                <tbody>
        EOF;

        foreach ($this->orders as $order) {
            $html .= <<<EOF
            <a href="/order.php?id={$order->id}">
                <tr>
                    <td>{$order->id}</td>
                    <td>{$order->date}</td>
                    <td>{$order->total}</td>
                </tr>
            EOF;
        }

        $html .= <<<EOF
                </tbody>
            </table>
        </div>
        EOF;

        return $html;
    }
}
