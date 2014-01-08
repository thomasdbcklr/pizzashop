<?php

namespace Oefeningen\pizzashop\data;

use Oefeningen\pizzashop\data\DBConfig;
use Oefeningen\pizzashop\entities\Account;

class AccountDAO {

    public static function getAll() {
        $lijst = array();

        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "select id as account_id, naam, voornaam, straat, huisnummer, postcode, woonplaats, telefoon, email, wachtwoord, promo from account";
        $resultSet = $dbh->query($sql);
        foreach ($resultSet as $rij) {
            $account = Account::create($rij["account_id"], $rij["naam"], $rij["voornaam"], $rij["straat"], $rij["huisnummer"], $rij['postcode'], $rij['woonplaats'], $rij['telefoon'], $rij['email'], $rij['wachtwoord'], $rij['promo']);
            array_push($lijst, $account);
        }
        $dbh = null;
        return $lijst;
    }

    public static function getByEmail($email) {
        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "select id as account_id, naam, voornaam, straat, huisnummer, postcode, woonplaats, telefoon, email, wachtwoord, promo from account where email = '" . $email . "'";
        $resultSet = $dbh->query($sql);
        if ($resultSet) {
            $rij = $resultSet->fetch();
            if ($rij) {
                $account = Account::create($rij["account_id"], $rij["naam"], $rij["voornaam"], $rij["straat"], $rij["huisnummer"], $rij['postcode'], $rij['woonplaats'], $rij['telefoon'], $rij['email'], $rij['wachtwoord'], $rij['promo']);
                $dbh = null;
                return $account;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public static function getById($id) {
        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "select id as account_id, naam, voornaam, straat, huisnummer, postcode, woonplaats, telefoon, email, wachtwoord, promo from account where id = '" . $id . "'";
        $resultSet = $dbh->query($sql);
        if ($resultSet) {
            $rij = $resultSet->fetch();
            if ($rij) {
                $account = Account::create($rij["account_id"], $rij["naam"], $rij["voornaam"], $rij["straat"], $rij["huisnummer"], $rij['postcode'], $rij['woonplaats'], $rij['telefoon'], $rij['email'], $rij['wachtwoord'], $rij['promo']);
                $dbh = null;
                return $account;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public static function createAccount($naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $email, $wachtwoord) {
        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "insert into account (naam, voornaam, straat, huisnummer, postcode, woonplaats, telefoon, email, wachtwoord)
		 values ('" . $naam . "','" . $voornaam . "','" . $straat . "','" . $huisnummer . "','" . $postcode . "','" . $woonplaats . "','" . $telefoon . "','" . $email . "','" . $wachtwoord . "')";
        $dbh->exec($sql);
        $accountid = $dbh->lastInsertId();
        $dbh = null;
        $promo = FALSE;
        $user = Account::create($accountid, $naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $email, $wachtwoord, $promo);
        return $user;
    }

}

