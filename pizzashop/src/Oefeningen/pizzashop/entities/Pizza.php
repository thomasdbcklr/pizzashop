<?php

namespace Oefeningen\pizzashop\entities;

class Pizza {

    private static $idMap = array();
    private $id;
    private $naam;
    private $prijs;
    private $samenstelling;
    private $promoprijs;

    private function __construct($id, $naam, $prijs, $samenstelling, $promoprijs) {
        $this->id = $id;
        $this->naam = $naam;
        $this->prijs = $prijs;
        $this->samenstelling = $samenstelling;
        $this->promoprijs = $promoprijs;
    }

    public static function create($id, $naam, $prijs, $samenstelling, $promoprijs) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Pizza($id, $naam, $prijs, $samenstelling, $promoprijs);
        }
        return self::$idMap[$id];
    }

    public function getId() {
        return $this->id;
    }

    public function getNaam() {
        return $this->naam;
    }

    public function setNaam($naam) {
        $this->naam = $naam;
    }

    public function getPrijs() {
        return $this->prijs;
    }

    public function setPrijs($prijs) {
        $this->prijs = $prijs;
    }

    public function getSamenstelling() {
        return $this->samenstelling;
    }

    public function setSamenstelling($samenstelling) {
        $this->samenstelling = $samenstelling;
    }

    public function getPromoprijs() {
        return $this->promoprijs;
    }

    public function setPromoprijs($promoprijs) {
        $this->promoprijs = $promoprijs;
    }

    public function toStdClass() {
        $output = new \stdClass;
        $output->id = $this->getId();
        $output->naam = $this->getNaam();
        $output->prijs = $this->getPrijs();
        $output->samenstelling = $this->getSamenstelling();
        $output->promoprijs = $this->getPromoprijs();

        return $output;
    }

}