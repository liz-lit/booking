<?php

namespace Lizlit\Controllers;

class HotelController
{
    /** @var Connection */
    private $db_connect;

    public function __construct(Connection $db_connect)
    {
        $this->db_connect = $db_connect;
    }


    public function getHotel($id)
    {
        $query = "SELECT * FROM hotels WHERE ID = '" . $id . "'";
        $result = $this->db_connect->select($query);
        $arr = array();
        $row = pg_fetch_row($result);
        $arr[] = ["ID" => $row[0], "hotel_name" => $row[1], "city" => $row[2], "type" => $row[3], "address" => $row[4]];
        return $arr;
    }

    public function filterByMainParams(string $arrival, string $departure, int $guest_quantity, $minprice, $maxprice)
    {
        $query = "SELECT hotels.hotel_name, hotels.type, hotels.city, hotels.address, 
		((room_status.departure::date - room_status.arrival::date)*rooms.price) as total_cost 
            FROM hotels
            JOIN rooms ON hotels.id = rooms.hotel_id
            JOIN room_status ON room_status.id=rooms.id
            where rooms.guest_quantity='" . $guest_quantity . "' and 
	            '" . $minprice . "'<rooms.price and
	            '" . $maxprice . "'>rooms.price and
	            not room_status.arrival='" . $arrival . "' or
	            not room_status.departure='" . $departure . "' ";
        $result = $this->db_connect->select($query);
        $arr = array();
        while ($row = pg_fetch_row($result)) {
            $arr[] = ["hotel_name" => $row[0], "type" => $row[1], "city" => $row[2], "address" => $row[3], "total_cost" => $row[4]];
        }
        return ($arr);
    }

    public function filterByCity($city)
    {
        $query = "SELECT * FROM hotels WHERE city = '" . $city . "'";
        $result = $this->db_connect->select($query);
        $arr = array();
        while ($row = pg_fetch_row($result)) {
            $arr[] = array("ID" => $row[0], "hotel_name" => $row[1], "city" => $row[2], "type" => $row[3], "address" => $row[4]);
        }
        return $arr;
    }

}
