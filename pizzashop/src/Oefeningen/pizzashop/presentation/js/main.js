//

$(function() {


//////////////////////////////////////INIT///////////////////////////////////////////////

//////////lijstpostcodes
    if ($('#lijstpostcodes').length > 0) {
        getPostcodes();
    }

/////////////hide
    hideAll();
    /////checkbox bestel form
    $('#aanVinken').hide();
    $('#account').click(function() {
        if ($(this).is(':checked')) {
            $('#aanVinken').show();
        } else {
            $('#aanVinken').hide();
        }
    });


/////////sessie user, winkelmandje
    welkomUser();
    getItemsWinkelmandje();

/////////////////pizzas
    if ($('#fPizza').length > 0) {
        getPizzas();
    }

    ///////////////mailCookie invullen
    if ($.cookie('mailCookie')) {
        $('#email').val($.cookie('mailCookie'));
        $('#aEmail').val($.cookie('mailCookie'));
    }

//////////////////////////////////////EVENT LISTERNERS///////////////////////////////////


//////////login
    if ($('#fLogin').length > 0) {
        $("#fLogin").submit(function(event) {
            event.preventDefault();
            aanMelden(this.email.value, this.wachtwoord.value);
        });
    }

//////////registreren
    if ($('#fRegis').length > 0) {
        $("#fRegis").submit(function(event) {
            event.preventDefault();
            registreren(this.naam.value, this.voornaam.value, this.straat.value, this.huisnummer.value, this.postcode.value, this.woonplaats.value, this.telefoon.value, this.email.value, this.wachtwoord.value);
            //
        });
    }


/////////voegToeAanWinkelmandje
    if ($('#fPizza').length > 0) {
        $("#fPizza").submit(function(event) {
            event.preventDefault();
            var Pizzas = [];
            var Aantals = [];
            $(this.aantal).each(function(n) {
                Pizzas[n] = this.dataset.id;
                Aantals[n] = this.value;
                this.value = "";
            });

            voegToeAanWinkelmandje(Pizzas, Aantals);
        });
    }

    /////////////afrekenen met account
    if ($('#afrekenenlogin').length > 0) {
        $("#afrekenenlogin").submit(function(event) {
            event.preventDefault();
            aanMelden(this.email.value, this.wachtwoord.value);
        });
    }

    ////afrekenen zonder account/ account aanmaken
    if ($('#fAfrekenen').length > 0) {
        $("#fAfrekenen").submit(function(event) {
            event.preventDefault();
            window.location = "toonbestellen.php";
        });
    }

////bestellen
    if ($('#fBestellen').length > 0) {
        $("#fBestellen").submit(function(event) {
            event.preventDefault();
            var data = checkLogin();
            if (data) {
                bestellenMetAccount(this.straat.value, this.huisnummer.value, this.postcode.value, this.woonplaats.value, this.telefoon.value, this.extra.value);
            } else {
                if ($('#account').is(':checked') == false) {
                    bestellenZonderAccount(this.straat.value, this.huisnummer.value, this.postcode.value, this.woonplaats.value, this.telefoon.value, this.extra.value);
                } else if ($('#account').is(':checked') == true) {
                    bestellenAccountMaken(this.naam.value, this.voornaam.value, this.straat.value, this.huisnummer.value, this.postcode.value, this.woonplaats.value, this.telefoon.value, this.extra.value, this.email.value, this.wachtwoord.value);
                }

            }
        });
    }


}); /////////////////////////////////////////////EINDE

/////////////////////////////////////FUNCTIES////////////////////////////////////////////

function hideAll() {
    $("#loginFout").hide();
    $("#fout").hide();
    $('#bestelfout').hide();
}


function getPostcodes() {
    $.getJSON("json_getPostcodes.php", {action: "get"}, function(data) {

        $postcodes = "";
        $.each(data, function(n, value) {
            $postcodes += '<li>' + value.postcode + '</li>';
        });
        $('#lijstpostcodes').html($postcodes);
    });
}

function aanMelden(email, wachtwoord) {
    $.post("json_login.php", {action: "login", email: email, wachtwoord: wachtwoord}, function(data) {
        if (!data.error) {
            $.each(data, function(n, value) {
                $.cookie('mailCookie', value.email, {expires: 7});
            });
            $("#loginFout").hide();
            if ($('#login').length > 0) {
                welkomUser();
            } else if ($("#afrekenenlogin").length > 0 || $("#fAfrekenen").length > 0) {
                window.location = 'toonbestellen.php';
            }
        } else {
            switch (data.error) {
                case 'vil':
                    fout = 'U bent een veld vergeten!';
                    break;
                case 'kno':
                    fout = 'Fout wachtwoord of email! ';
                    break;
                default:
                    fout = 'Error!';
            }
            $("#loginFout").show();
            $("#loginFout span").html(fout);
        }
    }, "json");
}

function welkomUser() {
    var data = checkLogin();
    if (data) {
        $('#login').empty();
        $("#regis").hide();
        $logout = "<p class='navbar-text navbar-right pull-right'> Welkom, " + data.voornaam + "! <a class='navbar-link' href='#' id='logout'>Uitloggen</a></p>";
        $('#login').html($logout);
        if ($('#fBestellen').length > 0) {
            $('#zonderAccount').hide();
            $('#fBestellen legend ').html('Bestellen met account');
            $('#fBestellen input').filter('input[name=naam]').val(data.naam);
            $('#fBestellen input').filter('input[name=voornaam]').val(data.voornaam);
            $('#fBestellen input').filter('input[name=straat]').val(data.straat);
            $('#fBestellen input').filter('input[name=huisnummer]').val(data.huisnummer);
            $('#fBestellen input').filter('input[name=postcode]').val(data.postcode);
            $('#fBestellen input').filter('input[name=woonplaats]').val(data.woonplaats);
            $('#fBestellen input').filter('input[name=telefoon]').val('0' + data.telefoon);
        }
        ////event listerner logout
        $('#logout').click(function(event) {
            event.preventDefault();
            logout();
        });
    }
}


function checkLogin() {
    var json;
    $.ajax({
        url: 'json_checkLogin.php',
        data: {action: "get"},
        dataType: 'json',
        async: false,
        success: function(data) {
// console.log(data.totaal);
            json = data;
        }
    });
    return json;
}



function logout() {
    $.getJSON("json_logout.php", {action: "logout"}, function(data) {
        window.location = 'index.php';
    });
}

function registreren(naam, voornaam, straat, huisnummer, postcode, woonplaats, telefoon, email, wachtwoord) {
    $.post("json_registreren.php", {action: "regis", naam: naam, voornaam: voornaam, straat: straat, huisnummer: huisnummer, postcode: postcode, woonplaats: woonplaats, telefoon: telefoon, email: email, wachtwoord: wachtwoord}, function(data) {
        if (!data.error) {
            if ($('#fRegis').length > 0) {
                window.location = 'index.php';
            }
        } else {
            console.log(data.error);
            switch (data.error) {
                case 'vil':
                    fout = 'U bent een veld vergeten!';
                    break;
                case 'fwe':
                    fout = 'Incorrecte waarde(n)! ';
                    break;
                case 'pnl':
                    fout = 'Niet leverbaar aan die postcode! ';
                    break;
                case 'gge':
                    fout = 'Geen geldig email adres!';
                    break;
                case 'ebe':
                    fout = 'Email al in gebruik! ';
                    break;
                default:
                    fout = 'Error!';
            }
            $("#fout").show();
            $("#fout").html(fout);
        }
    }, "json");
}


function getPizzas() {
    $.getJSON("json_getPizzas.php", {action: "get"}, function(data) {
        $.each(data, function(n, value) {
            $('<tr>').appendTo("#fPizza table")
                    .append('<td>' + value.naam + '</td>')
                    .append('<td>€ ' + value.prijs + '</td>')
                    .append('<td>' + value.samenstelling + '</td>')
                    .append('<td>€ ' + value.promoprijs + '</td>')
                    .append('<td><input type="text" class="form-control" name="aantal" placeholder="0" data-id=' + value.id + '></td>');
        });
    });
}


function voegToeAanWinkelmandje(pizzaid, aantal) {
    $.getJSON("json_voegtoe.php", {action: "voegtoe", pizzaid: pizzaid, aantal: aantal}, function(data) {
        if (!data.error) {
            hideAll();
            getItemsWinkelmandje();
        } else {
            console.log(data.error);
            switch (data.error) {
                case 'fwe':
                    fout = 'U heeft een foute waarde ingegeven!';
                    break;
                case 'vil':
                    fout = 'U moet minstend 1 aantal invullen!';
                    break;
                default:
                    fout = 'Error!';
            }
            $("#fout").show();
            $("#fout").html(fout);
        }
    });
}


function getItemsWinkelmandje() {
    $.getJSON("json_winkelmandje.php", {action: "get"}, function(data) {
        $('#items').empty();
        if (data.length !== 0) {
            $('<table class="table table-striped">').appendTo('#items').append('<thead><tr><th>Pizza</th><th>Aantal</th><th>Prijs</th><th></th></tr></thead><tbody></tbody>');
            $items = "";
            $totaalprijs = 0;
            $.each(data, function(n, value) {
                $pizzaAantalTotaal = value.pizza.prijs * value.aantal;
                $totaalprijs += $pizzaAantalTotaal;
                $items += '<tr><td>' + value.pizza.naam + '</td><td>&times; ' + value.aantal + '</td> <td> € ' + $pizzaAantalTotaal + '</td><td><button type="button" class="close" id="bverwijder" data-item=' + n + ' aria-hidden="true">&times;</button></td></tr>';
            });

            $('#items table tbody').append($items);
            $('#items table tbody').append('<tr id="totaal"><td colspan="2">Totaal:</td><td colspan="2">€ ' + $totaalprijs + '</td></tr>')
                    .append('<br><button type="submit" class="btn btn-success" id="afrekenen">Afrekenen</button>');
            //////EVENT LISTENERS/////////
            //verwijderen
            $('#items td button').click(function(event) {
                event.preventDefault();
                verwijderItem(this.dataset.item);
            });

            ////afrekenen
            if ($('#fBestellen').length > 0) {
                $('#items #afrekenen').hide();
                $('#items #bverwijder').hide();
            }
            $('#items #afrekenen').click(function(event) {
                event.preventDefault();
                window.location = 'afrekenen.php';
            });
        }
    });
}

function verwijderItem(itemId) {
    $.getJSON("json_verwijderPizza.php", {action: "verwijder", itemid: itemId}, function(data) {
        getItemsWinkelmandje();
    });
}

function bestellenMetAccount(straat, huisnummer, postcode, woonplaats, telefoon, extra) {
    $.getJSON("json_bestellen.php", {action: "bestelaccount", straat: straat, huisnummer: huisnummer, postcode: postcode, woonplaats: woonplaats, telefoon: telefoon, extra: extra}, function(data) {
        if (!data.error) {
            BerichtBestellingGelukt();
        } else {
            console.log(data.error);
            switch (data.error) {
                case 'fwe':
                    fout = 'U heeft een foute waarde ingegeven!';
                    break;
                case 'vil':
                    fout = 'Veld leeg gelaten!';
                    break;
                case 'pol':
                    fout = 'Postcode niet leverbaar!';
                    break;
                default:
                    fout = 'Error!';
            }
            $("#bestelfout").show();
            $("#bestelfout").html(fout);
        }

    });
}

function bestellenZonderAccount(straat, huisnummer, postcode, woonplaats, telefoon, extra) {
    $.getJSON("json_bestellenZonderAccount.php", {action: "bestelaccount", straat: straat, huisnummer: huisnummer, postcode: postcode, woonplaats: woonplaats, telefoon: telefoon, extra: extra}, function(data) {
        if (!data.error) {
            BerichtBestellingGelukt();
        } else {
            console.log(data.error);
            switch (data.error) {
                case 'fwe':
                    fout = 'U heeft een foute waarde ingegeven!';
                    break;
                case 'vil':
                    fout = 'Veld leeg gelaten!';
                    break;
                case 'pol':
                    fout = 'Postcode niet leverbaar!';
                    break;
                default:
                    fout = 'Error!';
            }
            $("#bestelfout").show();
            $("#bestelfout").html(fout);
        }

    });
}

function bestellenAccountMaken(naam, voornaam, straat, huisnummer, postcode, woonplaats, telefoon, extra, email, wachtwoord) {
    $.getJSON("json_bestellenAccountMaken.php", {action: "bestelaccount", naam: naam, voornaam: voornaam, straat: straat, huisnummer: huisnummer, postcode: postcode, woonplaats: woonplaats, telefoon: telefoon, extra: extra, email: email, wachtwoord: wachtwoord}, function(data) {
        if (!data.error) {
            BerichtBestellingGelukt();
        } else {
            console.log(data.error);
            switch (data.error) {
                case 'fwe':
                    fout = 'U heeft een foute waarde ingegeven!';
                    break;
                case 'vil':
                    fout = 'Veld leeg gelaten!';
                    break;
                case 'pol':
                    fout = 'Postcode niet leverbaar!';
                    break;
                case 'ebe':
                    fout = 'Email al in gebruik!';
                    break;
                case 'gge':
                    fout = 'Geen geldig email adres!';
                    break;
                default:
                    fout = 'Error!';
            }
            $("#bestelfout").show();
            $("#bestelfout").html(fout);
        }

    });
}


function BerichtBestellingGelukt() {
    $('#myModal').modal('show');
    $('#modalButton').click(function() {
        window.location = 'index.php';
    });
}