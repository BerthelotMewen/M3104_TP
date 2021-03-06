<?php

class Utilisateur
{

    protected $login = null;

    /**
     * Permet de valider un couple (login,pass) auprès d'une base de données.
     *
     * @param string $login le login à vérifier.
     * @param string $password le mot de passe à vérifier.
     *
     * @return boolean selon que l'authentification est ok ou pas.
     */
    public function getAuth($login, $password)
    {
        include_once ('params.inc.php');
        if (!is_null ($login) && !is_null ($password)) {
            $db = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
                DB_USER,
                DB_PASS
            );

            $login = filter_var ($login, FILTER_SANITIZE_STRING);
            $pass = filter_var ($password, FILTER_SANITIZE_STRING);
            $sql = "SELECT * FROM TP2_Users WHERE login = :login AND pass = :pass";
            $stmt = $db->prepare ($sql);
            $stmt->bindValue ("login", $login);
            $stmt->bindValue ("pass", $pass);
            $stmt->execute ();
            if ($stmt->fetch ()) {
                $this->login = $login;
                return true;
            } else {
                $this->login = null;
                return false;
            }
        }

    }

    /**
     * Permet d'insérer un nouvel utilisateur dans la base de données.
     *
     * @param string $login le login à insérer.
     * @param string $password le mot de passe à insérer.
     * @param string $mail le mail à insérer.
     * @param string $tel le tel à insérer.
     *
     * @return boolean selon que l'insertion est ok ou pas.
     */
    public function createUser($login, $password, $mail, $tel)
    {

        include_once ('params.inc.php');

        $db = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );

        $login = filter_var ($login, FILTER_SANITIZE_STRING);
        $pass = filter_var ($password, FILTER_SANITIZE_STRING);
        $mail = filter_var ($mail, FILTER_SANITIZE_STRING);
        $tel = filter_var ($tel, FILTER_SANITIZE_STRING);

        $sql = "INSERT INTO TP2_Users VALUES ('$login', '$pass', '$mail', '$tel')";

        if ($db->exec ($sql)) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Permet de modifier les données d'un utilisateur existant dans la base de données.
     * (l'utilisateur mis à jour est celui préalablement connecté)
     *
     * @param string $password le mot de passe à mettre à jour.
     * @param string $mail le mail à mettre à jour.
     * @param string $tel le tel à mettre à jour.
     *
     * @return boolean selon que la mise à jour est ok ou pas.
     */
    public function updateUser($password, $mail, $tel)
    {

        include_once ('params.inc.php');

        $db = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );

        $pass = filter_var ($password, FILTER_SANITIZE_STRING);
        $mail = filter_var ($mail, FILTER_SANITIZE_STRING);
        $tel = filter_var ($tel, FILTER_SANITIZE_STRING);

        $sql = "UPDATE TP2_Users SET pass = '$pass', mail = '$mail', tel = '$tel' WHERE login = '$this->login'";

        if ($db->exec ($sql)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Permet de modifier les données d'un utilisateur existant dans la base de données.
     * (l'utilisateur mis à jour est celui préalablement connecté)
     *
     * @param string $password le mot de passe à mettre à jour.
     * @param string $mail le mail à mettre à jour.
     * @param string $tel le tel à mettre à jour.
     *
     * @return boolean selon que la mise à jour est ok ou pas.
     */
    public function updateUserV2($password, $mail, $tel) {

        include_once ('params.inc.php');

        $db = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );

        $maj = "";
        $virgule = "";

        if (!is_null($password)) {
            $pass = filter_var ($password, FILTER_SANITIZE_STRING);
            $maj .= $virgule."pass='$pass'";
            $virgule = ", ";
        }
        if (!is_null($mail)) {
            $mail = filter_var ($mail, FILTER_SANITIZE_STRING);
            $maj .= $virgule."mail='$mail'";
            $virgule = ", ";
        }
        if (!is_null($tel)) {
            $tel = filter_var ($tel, FILTER_SANITIZE_STRING);
            $maj .= $virgule."tel='$tel'";
            $virgule = ", ";
        }

        $sql = "UPDATE TP2_Users SET ".$maj." WHERE login = '$this->login'";

        if ($db->exec ($sql)) {
            return true;
        } else {
            return false;
        }
    }

}
