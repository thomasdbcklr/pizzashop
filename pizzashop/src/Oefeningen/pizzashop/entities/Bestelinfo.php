<?php

namespace Oefeningen\pizzashop\entities;

class Bestelinfo {

    private static $idMap = array();
    private $id;
    private $klant_id;
    private $naam;
    private $voornaam;
    private $straat;
    private $huisnummer;
    private $postcode;
    private $woonplaats;
    private $telefoon;
    private $besteldatum;
    private $totaalprijs;
    private $extra_info;

    private function __construct($id, $klant_id, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $besteldatum, $totaalprijs, $extra_info) {
        $this->id = $id;
        $this->klant_id = $klant_id;
        $this->straat = $straat;
        $this->huisnummer = $huisnummer;
        $this->postcode = $postcode;
        $this->woonplaats = $woonplaats;
        $this->telefoon = $telefoon;
        $this->besteldatum = $besteldatum;
        $this->totaalprijs = $totaalprijs;
        $this->extra_info = $extra_info;
    }

    public static function create($id, $klant_id, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $besteldatum, $totaalprijs, $extra_info) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Bestelinfo($id, $klant_id, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $besteldatum, $totaalprijs, $extra_info);
        }
        return self::$idMap[$id];
    }

    public function getId() {
        return $this->id;
    }

    public function getKlant_id() {
        return $this->klant_id;
    }

    public function setKlant_id($klant_id) {
        $this->klant_id = $klant_id;
    }

    public function getNaam() {
        return $this->naam;
    }

    public function setNaam($naam) {
        $this->naam = $naam;
    }

    public function getVoornaam() {
        return $this->voornaam;
    }

    public function setVoornaam($voornaam) {
        $this->voornaam = $voornaam;
    }

    public function getStraat() {
        return $this->straat;
    }

    public function setStraat($straat) {
        $this->straat = $straat;
    }

    public function getHuisnummer() {
        return $this->huisnummer;
    }

    public function setHuisnummer($huisnummer) {
        $this->huisnummer = $huisnummer;
    }

    public function getPostcode() {
        return $this->postcode;
    }

    public function setPostcode($postcode) {
        $this->postcode = $postcode;
    }

    public function getWoonplaats() {
        return $this->woonplaats;
    }

    public function setWoonplaats($woonplaats) {
        $this->woonplaats = $woonplaats;
    }

    public function getTelefoon() {
        return $this->telefoon;
    }

    public function setTelefoon($telefoon) {
        $this->telefoon = $telefoon;
    }

    public function getBesteldatum() {
        return $this->besteldatum;
    }

    public function setBesteldatum($besteldatum) {
        $this->besteldatum = $besteldatum;
    }

    public function getTotaalprijs() {
        return $this->totaalprijs;
    }

    public function setTotaalprijs($totaalprijs) {
        $this->totaalprijs = $totaalprijs;
    }

    public function getExtra_info() {
        return $this->extra_info;
    }

    public function setExtra_info($extra_info) {
        $this->extra_info = $extra_info;
    }

    public function toStdClass() {
        $output = new \stdClass;
        $output->id = $this->getId();
        $output->klant_id = $this->getKlant_id();
        $output->straat = $this->getStraat();
        $output->huisnummer = $this->getHuisnummer();
        $output->postcode = $this->getPostcode();
        $output->woonplaats = $this->getWoonplaats();
        $output->telefoon = $this->getTelefoon();
        $output->besteldatum = $this->getBesteldatum();
        $output->totaalprijs = $this->getTotaalprijs();
        $output->extra_info = $this->getExtra_info();

        return $output;
    }

}