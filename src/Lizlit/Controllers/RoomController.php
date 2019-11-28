<?php


namespace Lizlit\Controllers;


class RoomController
{
    /** @var Connection */
    private $db_connect;

    public function __construct(Connection $db_connect)
    {
        $this->db_connect = $db_connect;
    }


    public function getRoom($room_id)
    {
        $query = "SELECT * FROM rooms WHERE ID = ='" . $$room_id . "' ";
        $result = pg_query($this->db_connect, $query) or die('The request failed: ' . pg_last_error());
        $arr = array();
        $row = pg_fetch_row($result);
        $arr[] = array("ID" => $row[0], "type" => $row[1], "person_quantity" => $row[2], "goods" => $row[3], "price" => $row[4]);
        return $arr;

        /*$arr[] = array("ID" => $room_id,
            "hotel_name" => 'Alessandro Palace',
            "type" => 'Standart',
            "Person_quantity" => 'tw0',
            "Goods" => "Private bathroom, hairdryer",
            "Price" => '100 ye');
        return $arr;*/
    }

    public function getRoomsTypes(string $hotels_name, string $arrival, string $departure, int $guest_quantity)
    {
        $query = "select types.type_name, count(1), rooms.price, ('" . $departure . "'::date - '" . $arrival . "'::date)*rooms.price as total_cost from hotels
            JOIN rooms on hotels.id=rooms.hotel_id
            JOIN types on rooms.type=types.id
            where hotels.hotel_name='" . $hotels_name . "' and
            rooms.guest_quantity='" . $guest_quantity . "'
            group by types.type_name, rooms.price, total_cost";
        $result = $this->db_connect->select($query);
        $arr = array();
        while ($row = pg_fetch_row($result)) {
            $arr[] = array("type" => $row[0], "rooms_quantity" => $row[1], "price" => $row[2], "total_cost" => $row[3]);
        }
        return $arr;
    }
}
