<?php

namespace Oefeningen\pizzashop\business;

use Oefeningen\pizzashop\data\AccountDAO;
use Oefeningen\pizzashop\data\PizzaDAO;
use Oefeningen\pizzashop\data\BestelinfoDAO;
use Oefeningen\pizzashop\data\BestellingDAO;
use Oefeningen\pizzashop\data\PostcodeDAO;
//////////////////////////
use Oefeningen\pizzashop\exceptions\VeldIsLeegException;
use Oefeningen\pizzashop\exceptions\KomtNietOvereenException;
use Oefeningen\pizzashop\exceptions\EmailBestaatException;
use Oefeningen\pizzashop\exceptions\FouteWaardeException;
use Oefeningen\pizzashop\exceptions\PostcodeNietLeverbaarException;
use Oefeningen\pizzashop\exceptions\GeenGeldiEmailException;

class PizzashopService {

    public static function getAllPizzas() {
        $lijst = array();
        $pizzas = PizzaDAO::getAll();
        foreach ($pizzas as $pizza) {
            $lijst[] = $pizza->toStdClass();
        }
        return $lijst;
    }

    public static function getAllPostcodes() {
        $lijst = array();
        $postcodes = PostcodeDAO::getAll();
        foreach ($postcodes as $postcode) {
            $lijst[] = $postcode->toStdClass();
        }
        return $lijst;
    }

    public static function controleerUser($email, $wachtwoord) {
        $obj = new \stdClass();
        try {

            if (empty($email) or empty($wachtwoord)) {
                throw new VeldIsLeegException ();
            }
            $shawachtwoord = sha1($wachtwoord);
            $user = AccountDAO::getByEmail($email);

            if ($user == null || $user->getWachtwoord() !== $shawachtwoord) {
                throw new KomtNietOvereenException;
            }
            $obj->user = $user->toStdClass();
        } catch (VeldIsLeegException $vil) {
            $obj->error = "vil";
        } catch (KomtNietOvereenException $kno) {
            $obj->error = "kno";
        } return $obj;
    }

    public static function maakAccountAan($naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $email, $wachtwoord) {
        $obj = new \stdClass();
        try {
            if (empty($naam) or empty($voornaam) or empty($straat) or empty($huisnummer) or empty($postcode) or empty($woonplaats) or empty($telefoon) or empty($email) or empty($wachtwoord)) {
                throw new VeldIsLeegException();
            }

            if (is_numeric($naam) or is_numeric($voornaam) or is_numeric($straat) or is_numeric($woonplaats) or !is_numeric($huisnummer) or !is_numeric($telefoon)) {
                throw new FouteWaardeException();
            }

            $leverbaarpostcode = PostcodeDAO::getByPostcode($postcode);
            if (!isset($leverbaarpostcode)) {
                throw new PostcodeNietLeverbaarException;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new GeenGeldiEmailException ();
            }

            $bestaatemail = AccountDAO::getByEmail($email);
            if (isset($bestaatemail)) {
                throw new EmailBestaatException();
            }
            $shawachtwoord = sha1($wachtwoord);
            $user = AccountDAO::createAccount($naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $email, $shawachtwoord);

            $obj->user = $user->toStdClass();
        } catch (VeldIsLeegException $vil) {
            $obj->error = 'vil';
        } catch (FouteWaardeException $fwe) {
            $obj->error = 'fwe';
        } catch (PostcodeNietLeverbaarException $pnl) {
            $obj->error = 'pnl';
        } catch (GeenGeldiEmailException $gge) {
            $obj->error = 'gge';
        } catch (EmailBestaatException $ebe) {
            $obj->error = 'ebe';
        } return $obj;
    }

    public static function voegToeAanWinkelmandje($id, $aantal, $winkelmandje) {
        $obj = new \stdClass();
        try {
            $lijst = array_combine($id, $aantal);
            $count = 0;
            foreach ($lijst as $aantalp) {

                $intvalue = intval($aantalp);

                if ($intvalue !== 0) {
                    $count++;
                }
            }
            if ($count <= 0) {
                throw new VeldIsLeegException;
            }

            $completeLijst = array_diff($lijst, array("", "0"));

            foreach ($completeLijst as $pizzaid => $aantalp) {

                if (!is_numeric($intvalue)) {
                    throw new FouteWaardeException();
                }

                $floatVal = floatval($aantalp);
                if (intval($floatVal) != $floatVal) {
                    throw new FouteWaardeException();
                }

                $pizzaObj = PizzaDAO::getById($pizzaid);
                $winkelmandje->voegToe($pizzaObj->toStdClass(), $aantalp);
                $obj->winkelmandje = $winkelmandje;
            }
        } catch (FouteWaardeException $fwe) {
            $obj->error = 'fwe';
        } catch (VeldIsLeegException $vil) {
            $obj->error = 'vil';
        }return $obj;
    }

    public static function verwijderUitwinkelmandje($index, $winkelmandje) {
        $winkelmandje->verwijder($index);
        return $winkelmandje;
    }

    public static function bestellenMetAccount($user, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $extra, $winkelmandje) {
        $obj = new \stdClass();
        try {
            if (empty($straat) or empty($huisnummer) or empty($postcode) or empty($woonplaats) or empty($telefoon)) {
                throw new VeldIsLeegException();
            }

            if (is_numeric($straat) or is_numeric($woonplaats) or !is_numeric($huisnummer) or !is_numeric($telefoon)) {
                throw new FouteWaardeException();
            }

            $leverbaarpostcode = PostcodeDAO::getByPostcode($postcode);
            if (!isset($leverbaarpostcode)) {
                throw new PostcodeNietLeverbaarException;
            }

            $klantid = $user->id;
            $datum = date('Y-m-d H:i:s');

            $items = $winkelmandje->getItems();
            $totaalprijs = 0;
            foreach ($items as $index => $pizza) {
                $totaalprijs = $totaalprijs + $pizza->pizza->prijs * $pizza->aantal;
            }

            $bestelinfo = BestelinfoDAO::create($klantid, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $datum, $totaalprijs, $extra);

            $bestelinfoid = $bestelinfo->getId();

            foreach ($items as $index => $pizza) {
                $aantal = $pizza->aantal;
                $pizzaid = $pizza->pizza->id;
                $bestelling = BestellingDAO::create($pizzaid, $bestelinfoid, $aantal);
            }

            $obj->bestelinfo = $bestelinfo->toStdClass();
        } catch (VeldIsLeegException $vil) {
            $obj->error = "vil";
        } catch (PostcodeNietLeverbaarException $pnl) {
            $obj->error = "pol";
        } catch (FouteWaardeException $fwe) {
            $obj->error = "fwe";
        }
        return $obj;
    }

    public static function bestellenZonderAccount($straat, $huisnummer, $postcode, $woonplaats, $telefoon, $extra, $winkelmandje) {

        $obj = new \stdClass();
        try {
            if (empty($straat) or empty($huisnummer) or empty($postcode) or empty($woonplaats) or empty($telefoon)) {
                throw new VeldIsLeegException();
            }

            if (is_numeric($straat) or is_numeric($woonplaats) or !is_numeric($huisnummer) or !is_numeric($telefoon)) {
                throw new FouteWaardeException();
            }

            $leverbaarpostcode = PostcodeDAO::getByPostcode($postcode);
            if (!isset($leverbaarpostcode)) {
                throw new PostcodeNietLeverbaarException;
            }

            $datum = date('Y-m-d H:i:s');

            $items = $winkelmandje->getItems();
            $totaalprijs = 0;
            foreach ($items as $index => $pizza) {
                $totaalprijs = $totaalprijs + $pizza->pizza->prijs * $pizza->aantal;
            }

            $bestelinfo = BestelinfoDAO::createKlantNull($straat, $huisnummer, $postcode, $woonplaats, $telefoon, $datum, $totaalprijs, $extra);

            $bestelinfoid = $bestelinfo->getId();

            foreach ($items as $index => $pizza) {

                $aantal = $pizza->aantal;
                $pizzaid = $pizza->pizza->id;
                BestellingDAO::create($pizzaid, $bestelinfoid, $aantal);
            }
            $obj->bestelinfo = $bestelinfo->toStdClass();
        } catch (VeldIsLeegException $vil) {
            $obj->error = "vil";
        } catch (PostcodeNietLeverbaarException $pnl) {
            $obj->error = "pol";
        } catch (FouteWaardeException $fwe) {
            $obj->error = "fwe";
        }
        return $obj;
    }

    public static function AccountEnBestelling($naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $email, $wachtwoord, $extra, $winkelmandje) {
        $obj = new \stdClass();
        try {
            if (empty($naam) or empty($voornaam) or empty($straat) or empty($huisnummer) or empty($postcode) or empty($woonplaats) or empty($telefoon) or empty($email) or empty($wachtwoord)) {
                throw new VeldIsLeegException();
            }

            if (is_numeric($naam) or is_numeric($voornaam) or is_numeric($straat) or is_numeric($woonplaats) or !is_numeric($huisnummer) or !is_numeric($telefoon)) {
                throw new FouteWaardeException();
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new GeenGeldiEmailException ();
            }

            $bestaatemail = AccountDAO::getByEmail($email);
            if (isset($bestaatemail)) {
                throw new EmailBestaatException();
            }

            $leverbaarpostcode = PostcodeDAO::getByPostcode($postcode);
            if (!isset($leverbaarpostcode)) {
                throw new PostcodeNietLeverbaarException;
            }

            $shawachtwoord = sha1($wachtwoord);
            $account = AccountDAO::createAccount($naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $email, $shawachtwoord);

            $klantid = $account->getId();
            $datum = date('Y-m-d H:i:s');

            $items = $winkelmandje->getItems();
            $totaalprijs = 0;
            foreach ($items as $index => $pizza) {
                $totaalprijs = $totaalprijs + $pizza->pizza->prijs * $pizza->aantal;
            }

            $bestelinfo = BestelinfoDAO::create($klantid, $straat, $huisnummer, $postcode, $woonplaats, $telefoon, $datum, $totaalprijs, $extra);

            $bestelinfoid = $bestelinfo->getId();

            foreach ($items as $index => $pizza) {

                $aantal = $pizza->aantal;
                $pizzaid = $pizza->pizza->id;
                BestellingDAO::create($pizzaid, $bestelinfoid, $aantal);
            }

            $obj->bestelinfo = $bestelinfo->toStdClass();
        } catch (VeldIsLeegException $vil) {
            $obj->error = "vil";
        } catch (PostcodeNietLeverbaarException $pnl) {
            $obj->error = "pol";
        } catch (FouteWaardeException $fwe) {
            $obj->error = "fwe";
        } catch (EmailBestaatException $ebe) {
            $obj->error = "ebe";
        } catch (GeenGeldiEmailException $gge) {
            $obj->error = 'gge';
        }
        return $obj;
    }

}

?>