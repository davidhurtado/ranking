<?php

/**
 * Created by PhpStorm.
 * User: PC90
 * Date: 04/12/2015
 * Time: 9:54
 */
class User {
    # Verificar si el usuario esta conectado

    public $logged;

    # Datos del usuario
    public $data;

    # Tiempo
    public $time;

    # ultimo inicio de sesion
    private $login_time;

    #Token para los formularios
    private $token;

    # Base de datos
    private $db;

    public function __construct() {

        $this->time = time();

        $this->db = $GLOBALS["G"]->db;

        $this->__session_start();
    }

    private function __session_start() {

        if (!empty($_SESSION["logged"]) && !empty($_SESSION["id"])) {

            if ($datauser = $this->exists()) {

                $this->logged = true;

                $this->loadData($datauser);
            }
        } else {

            $this->logged = false;
        }
    }

    public function loadData($datauser) {
        global $G;
        if ($datauser["u_id"] > 0) {

            $_SESSION["logged"] = true;
            $_SESSION["id"] = $datauser["u_id"];
            $_SESSION["user"] = $datauser["u_nick"];
            $this->logged = true;

            $this->data = (object) $datauser;

            if ($this->data->u_tipo == 1) {
                $G->menu_principal = "admin/menu_admin.phtml";
            } else
            if ($this->data->u_tipo == 3) {
                $G->menu_principal = "participante/menu_user.phtml";
            }
        }
    }

    public function exists($id = 0, $username = false) {

        $array_where = array();
        if (!empty($username)) {
            $query_exist = $this->db->prepare("SELECT * FROM " . DB_PREFIX . "usuarios WHERE u_nick = ?");
            $query_exist->execute(array($username));
        } else {
            if (empty($id))
                $array_where = array(intval($_SESSION["id"]));
            else
                $array_where = array(intval($id));
            $query_exist = $this->db->prepare("SELECT * FROM " . DB_PREFIX . "usuarios WHERE u_id = ?");
            $query_exist->execute($array_where);
        }                                  
        return ( $query_exist->rowCount() ? $query_exist->fetch(PDO::FETCH_ASSOC) : false );
    }

    public function logout() {

        $_SESSION["logged"] = false;
        $_SESSION["id"] = null;
        session_destroy();
        $this->logged = false;
        redirectTo("home");
    }

    public function isLogged() {
        return !empty($this->logged);
    }

}
