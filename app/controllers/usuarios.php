<?php

/**
 * Created by PhpStorm.
 * User: PC90
 * Date: 04/12/2015
 * Time: 11:06
 */
if (!$G->user->isLogged()) {
    redirectTo("login");
} else {
    if ($G->user->data->u_tipo == 1) {
        $G->error = "ok";
        $G->act = isset($_GET["act"]) ? trim($_GET["act"]) : "lista";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($G->act == 'agregar') {
                if (!empty($_POST["nick"])) {
                    $nombres = !empty($_POST["nombres"]) ? trim($_POST["nombres"]) : ($G->error .= "Falta nombres.<br/>");
                    $apellidos = !empty($_POST["apellidos"]) ? trim($_POST["apellidos"]) : ($G->error .= "Falta apellidos.<br/>");
                    $nick = !empty($_POST["nick"]) ? trim($_POST["nick"]) : ($G->error .= "Falta nick.<br/>");
                    $password = !empty($_POST["pass"]) ? trim($_POST["pass"]) : ($G->error .= "Falta password.<br/>");
                    $tipo = !empty($_POST["tipo"]) ? trim($_POST["tipo"]) : 3;
                    $sesion = 0;
                    //$camionero = !empty($_POST["camionero"]) ? trim($_POST["camionero"]) : ($G->error .= "Falta camionero.<br/>");
                     //Cargar los registros -->
                        $queryExiste = $G->db->prepare("SELECT * FROM " . DB_PREFIX . "usuarios WHERE u_nick='".$nick."'");
                        $queryExiste->execute();

                        //Existen registros?
                        if ($queryExiste->rowCount()) {
                            $G->error='Ya existe ese usuario';
                        } else {
                            $G->usuarios = null;
                        }
                    
                    if ($G->error == "ok") {
                        $password_hashed = hash("sha256", $password);
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $insert_query = $G->db->prepare("INSERT INTO " . DB_PREFIX . "usuarios (u_nombres, u_apellidos, u_nick, u_password, u_tipo, u_sesion, u_ip)
            VALUES (?, ?, ?, ?,?,?,?)");

                        $insert_query->execute(
                                array($nombres, $apellidos, $nick, $password_hashed, $tipo, $sesion, $ip)
                        );
                    }
                }
            }
            if ($G->act == 'eliminar') {
                if (!empty($_POST["id"]) && $_POST["accion"]=='eliminar' ) {
                    $uid = $_POST["id"];
                    $query = $G->db->prepare("DELETE FROM " . DB_PREFIX . "usuarios WHERE u_id=" . $uid);
                    $query->execute();
                    echo '1';
                    die();
                }
                //redirectTo("lista");
            }
            if ($G->act == 'editando') {
                if (!empty($_POST["nick"])) {

                    $uid = $_GET["id"];
                    $query = $G->db->prepare("UPDATE FROM " . DB_PREFIX . "usuarios WHERE u_id=" . $uid);
                    $query->execute();
                }
                redirectTo("lista");
            }
        }
        $G->contenido = 'admin/usuarios.phtml';
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            
            if ($G->act == 'editar') {
                if (!empty($_GET["id"])) {
                    $uid = $_GET["id"];

                    //Cargar los registros -->
                    $query = $G->db->prepare("SELECT * FROM " . DB_PREFIX . "usuarios WHERE u_id=" . $uid);

                    $query->execute();
                    //Existen registros?
                    if ($query->rowCount()) {
                        $G->usuariosEditar = $query->fetchAll();
                    } else {
                        $G->usuariosEditar = null;
                        redirectTo('lista');
                    }
                }
            }
        }

//Cargar los registros -->
        $queryUs = $G->db->prepare("SELECT * FROM " . DB_PREFIX . "usuarios ORDER BY u_id ASC");

        $queryUs->execute();

//Existen registros?
        if ($queryUs->rowCount()) {
            $G->usuarios = $queryUs->fetchAll();
        } else {
            $G->usuarios = null;
        }


        loadView('home.phtml');
    } else {
        redirectTo($G->config["w_url"] . DS . 'logout');
    }
} 