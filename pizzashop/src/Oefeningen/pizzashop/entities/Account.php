<?php

namespace Oefeningen\pizzashop\entities;

class Account {

    private static $idMap = array();
    private $id;
    private $naam;
    private $voornaam;
    private $straat;
    private $huisnummer;
    private $postcode;
    private $woonplaats;
    private $telefoon;
    private $email;
    private $wachtwoord;
    private $promo;

    private function __construct($id, $naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $email, $wachtwoord, $promo) {
        $this->id = $id;
        $this->naam = $naam;
        $this->voornaam = $voornaam;
        $this->straat = $straat;
        $this->huisnummer = $huisnummer;
        $this->postcode = $postcode;
        $this->woonplaats = $woonplaats;
        $this->telefoon = $telefoon;
        $this->email = $email;
        $this->wachtwoord = $wachtwoord;
        $this->promo = $promo;
    }

    public static function create($id, $naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $email, $wachtwoord, $promo) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Account($id, $naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $email, $wachtwoord, $promo);
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

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getWachtwoord() {
        return $this->wachtwoord;
    }

    public function setWachtwoord($wachtwoord) {
        $this->wachtwoord = $wachtwoord;
    }

    public function getPromo() {
        return $this->promo;
    }

    public function setPromo($promo) {
        $this->promo = $promo;
    }

    public function toStdClass() {
        $output = new \stdClass;
        $output->id = $this->getId();
        $output->naam = $this->getNaam();
        $output->voornaam = $this->getVoornaam();
        $output->straat = $this->getStraat();
        $output->huisnummer = $this->getHuisnummer();
        $output->postcode = $this->getPostcode();
        $output->woonplaats = $this->getWoonplaats();
        $output->telefoon = $this->getTelefoon();
        $output->email = $this->getEmail();
        $output->promo = $this->getPromo();

        return $output;
    }

}