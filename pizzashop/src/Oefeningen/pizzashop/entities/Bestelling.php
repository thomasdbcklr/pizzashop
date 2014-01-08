<?php

namespace Oefeningen\pizzashop\entities;

class Bestelling {

    private static $idMap = array();
    private $id;
    private $pizza_id;
    private $bestelinfo_id;
    private $aantal;

    private function __construct($id, $pizza_id, $bestelinfo_id, $aantal) {
        $this->id = $id;
        $this->pizza_id = $pizza_id;
        $this->bestelinfo_id = $bestelinfo_id;
        $this->aantal = $aantal;
    }

    public static function create($id, $pizza_id, $bestelinfo_id, $aantal) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Bestelling($id, $pizza_id, $bestelinfo_id, $aantal);
        }
        return self::$idMap[$id];
    }

    public function getId() {
        return $this->id;
    }

    public function getPizza_id() {
        return $this->pizza_id;
    }

    public function setPizza_id($pizza_id) {
        $this->pizza_id = $pizza_id;
    }

    public function getBestelinfo_id() {
        return $this->bestelinfo_id;
    }

    public function setBestelinfo_id($bestelinfo_id) {
        $this->bestelinfo_id = $bestelinfo_id;
    }

    public function getAantal() {
        return $this->aantal;
    }

    public function setAantal($aantal) {
        $this->aantal = $aantal;
    }

    public function toStdClass() {
        $output = new \stdClass;
        $output->id = $this->getId();
        $output->pizza_id = $this->getPizza_id();
        $output->bestelinfo_id = $this->getBestelinfo_id();
        $output->aantal = $this->getAantal();

        return $output;
    }

}