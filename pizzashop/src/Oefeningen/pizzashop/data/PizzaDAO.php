<?php

namespace Oefeningen\pizzashop\data;

use Oefeningen\pizzashop\data\DBConfig;
use Oefeningen\pizzashop\entities\Pizza;

class PizzaDAO {

    public static function getAll() {
        $lijst = array();

        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "select id as pizza_id , naam, prijs, samenstelling, promoprijs from pizza";
        $resultSet = $dbh->query($sql);
        foreach ($resultSet as $rij) {
            $pizza = Pizza::create($rij["pizza_id"], $rij["naam"], $rij["prijs"], $rij["samenstelling"], $rij["promoprijs"]);
            array_push($lijst, $pizza);
        }
        $dbh = null;
        return $lijst;
    }

    public static function getById($id) {
        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "select id as pizza_id , naam, prijs, samenstelling, promoprijs from pizza where id = " . $id;
        $resultSet = $dbh->query($sql);
        $rij = $resultSet->fetch();
        if (!$rij) {
            return null;
        } else {
            $pizza = Pizza::create($rij["pizza_id"], $rij["naam"], $rij["prijs"], $rij["samenstelling"], $rij["promoprijs"]);
            $dbh = null;
            return $pizza;
        }
    }

}
