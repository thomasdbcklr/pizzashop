<?php

namespace Oefeningen\pizzashop\entities;

class Postcode {

    private static $idMap = array();
    private $id;
    private $postcode;

    private function __construct($id, $postcode) {
        $this->id = $id;
        $this->postcode = $postcode;
    }

    public static function create($id, $postcode) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Postcode($id, $postcode);
        }
        return self::$idMap[$id];
    }

    public function getId() {
        return $this->id;
    }

    public function getPostcode() {
        return $this->postcode;
    }

    public function setPostcode($postcode) {
        $this->postcode = $postcode;
    }

    public function toStdClass() {
        $output = new \stdClass;
        $output->id = $this->getId();
        $output->postcode = $this->getPostcode();

        return $output;
    }

}