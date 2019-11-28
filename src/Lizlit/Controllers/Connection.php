<?php

namespace Lizlit\Controllers;

class Connection
{
    protected $db_params;
    public function __construct($db_params)
    {
        $this->db_params = pg_connect($db_params)
            or die('Unsuccessful connection: ' . pg_last_error());
    }

    public function select(string $query)
    {
        return pg_query($this->db_params, $query);
    }

    /**
     * @return false|resource
     */
    public function getDbParams()
    {
        return $this->db_params;
    }

    public function __destruct()
    {
        pg_close($this->db_params);
    }

}