<?php

use Phinx\Migration\AbstractMigration;

class MyMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */

    public function up()
    {
        $sql1 = '
            CREATE TABLE hotels(
            ID SERIAL PRIMARY KEY,
            hotel_name character(300),
            city character(100),
            type character(100),
            address character(400)
            );';
        $this->execute($sql1);
        $sql2 = '
            CREATE TABLE type_rooms(
            ID SERIAL PRIMARY KEY,
            type_name character(300)
            );';
        $this->execute($sql2);


        $sql = '
            CREATE TABLE room(
            ID SERIAL PRIMARY KEY,
            type int,
            hotel_id int,
            price float,
            guest_quantity int,
            FOREIGN KEY (hotel_id) REFERENCES hotel (ID),
            FOREIGN KEY (type) REFERENCES type_rooms (ID)
            ); ';
        $this->execute($sql);
        $sql3 = '
            CREATE TABLE rooms_status(
            ID SERIAL PRIMARY KEY,
            arrival timestamp ,
            departure timestamp ,
            summary_cost float,
            FOREIGN KEY (ID) REFERENCES room (ID)
            ); ';
        $this->execute($sql3);
        $sql4 = '
            CREATE TABLE bookings(
            ID SERIAL PRIMARY KEY,
            status_id int,
            surname_id int UNIQUE,
            FOREIGN KEY (status_id) REFERENCES rooms_status (ID)
            ); ';
        $this->execute($sql4);
        $sql5 = '
            CREATE TABLE client(
            ID SERIAL PRIMARY KEY,
            surname character(300),
            name character (100),
            birthday timestamp ,
            gender character(50),
            FOREIGN KEY (ID) REFERENCES booking (surname_id)
            ); ';
        $this->execute($sql5);

    }
    public function down()
    {
        $sql1 = 'DROP TABLE hotels CASCADE ';
        $this->execute($sql1);
        $sql2 = 'DROP TABLE type_rooms CASCADE ';
        $this->execute($sql2);
        $sql = 'DROP TABLE room';
        $this->execute($sql);
        $sql3 = 'DROP TABLE rooms_status CASCADE ';
        $this->execute($sql3);
        $sql4 = 'DROP TABLE bookings CASCADE ';
        $this->execute($sql4);
        $sql5 = 'DROP TABLE client CASCADE ';
        $this->execute($sql5);
    }

}
