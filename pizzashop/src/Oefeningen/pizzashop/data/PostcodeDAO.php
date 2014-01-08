<?php

namespace Oefeningen\pizzashop\data;

use Oefeningen\pizzashop\data\DBConfig;
use Oefeningen\pizzashop\entities\Postcode;

class PostcodeDAO {

    public static function getAll() {
        $lijst = array();

        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "select id as postcode_id, postcode from postcode";
        $resultSet = $dbh->query($sql);
        foreach ($resultSet as $rij) {
            $postcode = Postcode::create($rij["postcode_id"], $rij["postcode"]);
            array_push($lijst, $postcode);
        }
        $dbh = null;
        return $lijst;
    }

    public static function getByPostcode($postcode) {
        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "select id as postcode_id, postcode from postcode where postcode = '" . $postcode . "'";
        $resultSet = $dbh->query($sql);
        if ($resultSet) {
            $rij = $resultSet->fetch();
            if ($rij) {
                $postcode = Postcode::create($rij["postcode_id"], $rij["postcode"]);
                $dbh = null;
                return $postcode;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

}
