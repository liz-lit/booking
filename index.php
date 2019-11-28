<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

use Lizlit\Controllers\Connection;
use Lizlit\Controllers\HotelController;
use Lizlit\Controllers\RoomController;

require_once __DIR__ . '/vendor/autoload.php';
$db_params = "host=localhost port=5432 dbname=intership user=postgres password =12345";
$db_connect = new Connection($db_params);

$hotel = new HotelController($db_connect);
$room = new RoomController($db_connect);
$req_res = null;
$request = $_SERVER['REQUEST_METHOD'];


switch ($request) {
    case "GET":
        if (empty($_GET["hotel_name"])) {
            $req_res = $hotel->filterByMainParams($_GET["arrival"], $_GET["departure"], $_GET["guest_quantity"], $_GET["min_price"], $_GET["max_price"]);
        } else {
            $req_res = $room->getRoomsTypes($_GET["hotel_name"], $_GET["arrival"], $_GET["departure"], $_GET["guest_quantity"]);
        }
        echo json_encode($req_res);
        break;
}











