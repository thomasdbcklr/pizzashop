<?php

namespace Oefeningen\pizzashop\data;

use Oefeningen\pizzashop\data\DBConfig;
use Oefeningen\pizzashop\entities\Bestelling;
use Oefeningen\pizzashop\data\BestelinfoDAO;

class BestellingDAO {

    public static function getAll() {
        $lijst = array();

        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "select id as bestelling_id, pizza_id, bestelinfo_id, aantal from bestelling";
        $resultSet = $dbh->query($sql);
        foreach ($resultSet as $rij) {
            $bestelling = bestelling::create($rij["bestelling_id"], $rij["pizza_id"], $rij["bestelinfo_id"], $rij["aantal"]);
            array_push($lijst, $bestelling);
        }
        $dbh = null;
        return $lijst;
    }

    public static function getById($id) {
        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "select id as bestelling_id, pizza_id, bestelinfo_id, aantal from bestelling where id = " . $id;
        $resultSet = $dbh->query($sql);
        $rij = $resultSet->fetch();
        if (!$rij) {
            return null;
        } else {
            $bestelling = bestelling::create($rij["bestelling_id"], $rij["pizza_id"], $rij["bestelinfo_id"], $rij["aantal"]);
            $dbh = null;
            return $bestelling;
        }
    }

    public static function create($pizzaid, $bestelinfoid, $aantal) {
        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "insert into bestelling (pizza_id, bestelinfo_id, aantal)
                values(" . $pizzaid . "," . $bestelinfoid . ",'" . $aantal . "')";
        $dbh->exec($sql);
        $bestellingid = $dbh->lastInsertId();
        $dbh = null;
        $bestelinfo = BestelinfoDAO::getById($bestelinfoid);

        $bestelling = Bestelling::create($bestellingid, $pizzaid, $bestelinfo, $aantal);
        return $bestelling;
    }

}
