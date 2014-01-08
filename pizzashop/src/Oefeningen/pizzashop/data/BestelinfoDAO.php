<?php

namespace Oefeningen\pizzashop\data;

use Oefeningen\pizzashop\data\DBConfig;
use Oefeningen\pizzashop\entities\Bestelinfo;
use Oefeningen\pizzashop\data\AccountDAO;

class BestelinfoDAO {

    public static function getAll() {
        $lijst = array();

        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "select id as bestelinfo_id, klant_id, straat, huisnummer, postcode, woonplaats, telefoon, besteldatum, totaalprijs, extra_info from bestelinfo";
        $resultSet = $dbh->query($sql);
        foreach ($resultSet as $rij) {
            $bestelinfo = bestelinfo::create($rij["bestelinfo_id"], $rij["klant_id"], $rij["straat"], $rij["huisnummer"], $rij['postcode'], $rij['woonplaats'], $rij['telefoon'], $rij['besteldatum'], $rij['totaalprijs'], $rij['extra_info']);
            array_push($lijst, $bestelinfo);
        }
        $dbh = null;
        return $lijst;
    }

    public static function getById($id) {
        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "select id as bestelinfo_id, klant_id, straat, huisnummer, postcode, woonplaats, telefoon, besteldatum, totaalprijs, extra_info from bestelinfo where id = " . $id;
        $resultSet = $dbh->query($sql);
        $rij = $resultSet->fetch();
        if (!$rij) {
            return null;
        } else {
            $bestelinfo = bestelinfo::create($rij["bestelinfo_id"], $rij["klant_id"], $rij["straat"], $rij["huisnummer"], $rij['postcode'], $rij['woonplaats'], $rij['telefoon'], $rij['besteldatum'], $rij['totaalprijs'], $rij['extra_info']);
            $dbh = null;
            return $bestelinfo;
        }
    }

    public static function create($klantid, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $datum, $totaalprijs, $extra) {
        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "insert into bestelinfo (klant_id, straat, huisnummer, postcode, woonplaats, telefoon, besteldatum, totaalprijs, extra_info) values (" . $klantid . ", '" . $straat . "', " . $huisnummer . ", " . $postcode . ", '" . $woonplaats . "', " . $telefoon . ", '" . $datum . "', " . $totaalprijs . ", '" . $extra . "')";
        $dbh->exec($sql);
        $bestelinfoid = $dbh->lastInsertId();
        $dbh = null;
        $klant = AccountDAO::getById($klantid);
        $bestelinfo = Bestelinfo::create($bestelinfoid, $klant, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $datum, $totaalprijs, $extra);
        return $bestelinfo;
    }

    public static function createKlantNull($straat, $huisnummer, $postcode, $woonplaats, $telefoon, $datum, $totaalprijs, $extra) {
        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "insert into bestelinfo (straat, huisnummer, postcode, woonplaats, telefoon, besteldatum, totaalprijs, extra_info) values ('" . $straat . "', " . $huisnummer . ", " . $postcode . ", '" . $woonplaats . "', " . $telefoon . ", '" . $datum . "', " . $totaalprijs . ", '" . $extra . "')";
        $dbh->exec($sql);
        $bestelinfoid = $dbh->lastInsertId();
        $dbh = null;
        $klant = null;
        $bestelinfo = Bestelinfo::create($bestelinfoid, $klant, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $datum, $totaalprijs, $extra);
        return $bestelinfo;
    }

}
