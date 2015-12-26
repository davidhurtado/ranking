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
    $G->error = "ok";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!empty($_POST["matricula"])) {



            $matricula = !empty($_POST["matricula"]) ? trim($_POST["matricula"]) : ($G->error .= "Falta matricula.<br/>");
            $modelo = !empty($_POST["modelo"]) ? trim($_POST["modelo"]) : ($G->error .= "Falta modelo.<br/>");
            $tipo = !empty($_POST["tipo"]) ? trim($_POST["tipo"]) : ($G->error .= "Falta tipo.<br/>");
            $potencia = !empty($_POST["potencia"]) ? trim($_POST["potencia"]) : ($G->error .= "Falta potencia.<br/>");
            //$camionero = !empty($_POST["camionero"]) ? trim($_POST["camionero"]) : ($G->error .= "Falta cedula del camionero.<br/>");


            if ($G->error == "ok") {


                $insert_query = $G->db->prepare("INSERT INTO " . DB_PREFIX . "usuarios (c_matricula, c_modelo, c_tipo, c_potencia)
            VALUES (?, ?, ?, ?)");

                $insert_query->execute(
                        array($matricula, $modelo, $tipo, $potencia)
                );
            }
        }
    }
    $G->act = isset($_GET["act"]) ? trim($_GET["act"]) : "lista";
    $G->contenido = 'admin/usuarios.phtml';

    if ($G->act == 'eliminar'){
    //fernando balta jhong  
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
   
            if (!empty($_GET["id"])) {
                $uid = $_GET["id"];
                 $query=$G->db->prepare("DELETE FROM " . DB_PREFIX . "usuarios WHERE u_id=".$uid);
                 $query->execute();
            }
            /*
              $uid = $_GET['u_id'];
              $query->G->db->prepare("UPDATE * FROM " . DB_PREFIX . "usurios WHERE u_id='$uid'");
              $query->execute();
             */
            
        }
       redirectTo("lista");
    }
    //Cargar los registros -->
    $query = $G->db->prepare("SELECT * FROM " . DB_PREFIX . "usuarios ORDER BY u_id ASC");

    $query->execute();

    //Existen registros?
    if ($query->rowCount()) {
        $G->usuarios = $query->fetchAll();
    } else {
        $G->usuarios = null;
    }
    loadView('home.phtml');
}
    
    