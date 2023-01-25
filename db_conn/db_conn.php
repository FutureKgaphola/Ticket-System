<?php

class DBconnect{

    public function getconnection()
    {
        $DBconn="";
        try {
            $host="localhost";
            $username="id17952374_boardroom";
            $password="2021@Lcx.Devs";
            $database="id17952374_boardroomlcx_db";
            $DBconn=new PDO("mysql:host=$host;dbname=$database",$username,$password);
            
        } catch (PDOException $th) {
            print "Error: ".$th->getMessage();
            die();
        }
        return $DBconn;
    }
}

?>
