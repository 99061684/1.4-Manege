<?php
require(ROOT . "model/MainModel.php");


// function index()
// {
// 	$connection = checkConnection();
//     render('visitor/index', ['connection' => $connection]);
// }

function index() {
	$visitors = getAllData("visitors");
    render('visitor/index', $visitors);
}

function overzicht_animals() {
	$horses = getAllData("horses");
    $ponys = getAllData("ponys");
    render('animals/index', ['horses' => $horses, 'ponys' => $ponys]);
}

function overzicht_reservations() {
	$reservations = getAllData("reservations");
    render('reservations/index', $reservations);
}