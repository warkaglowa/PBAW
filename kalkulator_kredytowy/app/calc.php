<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów

$kwota = $_REQUEST ['kwota'];
$lata = $_REQUEST ['lata'];
$procent = $_REQUEST ['procent'];

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($kwota) && isset($lata) && isset($procent))) {
    //sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
    $messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $kwota == "") {
    $messages [] = 'Nie podano kwoty';
}
if ( $lata == "") {
    $messages [] = 'Nie podano lat';
}
if ( $procent == "") {
    $messages [] = 'Nie podano oprocentowania';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {

    // sprawdzenie, czy $kwota i $lata są liczbami
    if (! is_numeric( $kwota )) {
        $messages [] = 'Kwota nie jest liczbą';
    }
    else {
        $kwota = floatval($kwota);
        if ($kwota <= 0){
            $messages [] = 'Kwota jest mniejsza lub równa zero';
        }
    }

    if (! is_numeric( $lata )) {
        $messages [] = 'Lata nie jest liczbą';
    }
    else {
        $lata = floatval($lata);
        if ($lata <= 0){
            $messages [] = 'Lata są mniejsze lub równe zero';
        }
    }

    if (! is_numeric( $procent )) {
        $messages [] = 'Procent nie jest liczbą';
    }
    else {
        $procent = floatval($procent);
        if ($procent <= 0){
            $messages [] = 'Procent jest mniejszy lub równy zero';
        }
    }

}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów

    //wykonanie operacji
    $miesiace = 12 * $lata;
    $rata = $kwota / $miesiace;
    $rata *= (1 + $procent / 100);
}

// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$kwota,$lata,$procent,$rata)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';