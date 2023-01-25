<?php

class AddAdmin extends DBconnect
{
    private $Emailregister;

    public function setMember($email, $pass, $name, $lname, $role)
    {
        try {
            $this->Emailregister = trim($email);
            if ($this->isAccountExist() == false) {
                $sql = "INSERT INTO admins (username,pass,Names,role)
                    VALUES (?,?,?,?)";
                $dbcon = new DBconnect();
                $stmt = $dbcon->getconnection()->prepare($sql);
                if ($stmt->execute([$email, $pass, $name . ' ' . $lname, $role])) {
                    $_SESSION['update_info'] = "created user : " . $name . " 's account";
                    header('Location:../dashboard.php');
                }
            } else {
                $_SESSION['ExistAccount'] = "The email used is already assigned to another user on the system. try a different email";
                header('Location:../dashboard.php');
            }
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
    }
    function isAccountExist()
    {
        $exist = false;
        try {
            $dbconn = new DBconnect();
            $stmt = $dbconn->getconnection()->prepare("SELECT * FROM Admins");
            $stmt->execute();
            $result = $stmt->fetchAll();
            foreach ($result as $row) {
                if (trim(strtolower($this->Emailregister)) == trim(strtolower($row['username']))) {
                    $exist = true;
                }
            }
        } catch (PDOException $er) {
            echo $er->getMessage();
        }
        return $exist;
    }
}

?>