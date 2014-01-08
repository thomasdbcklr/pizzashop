<?php

namespace Oefeningen\pizzashop\DTO;

class Winkelmandje {

    private $items;

    public function __construct() {
        $this->items = array();
    }

    public function voegToe($pizza, $aantal) {
        $pizzas = new \stdClass();
        $pizzas->pizza = $pizza;
        $pizzas->aantal = $aantal;
        $index = uniqid();
        $this->items[$index] = $pizzas;
    }

    public function getItems() {
        return $this->items;
    }

    public function verwijder($index) {
        unset($this->items[$index]);
    }

}
