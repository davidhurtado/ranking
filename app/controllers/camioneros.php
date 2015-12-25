<?php
/**
 * Created by PhpStorm.
 * User: PC90
 * Date: 04/12/2015
 * Time: 11:06
 */
if( !$G->user->isLogged() ){
    redirectTo("login");
}else{
    $G->error = "ok";

    if( $_SERVER["REQUEST_METHOD"] == "POST"){

        if( !empty($_POST["cedula"]) ){



            $cedula = !empty($_POST["cedula"]) ? trim($_POST["cedula"]) : ($G->error .= "Falta cedula.<br/>");
            $nombres = !empty($_POST["nombres"]) ? trim($_POST["nombres"]) : ($G->error .= "Falta nombres.<br/>");
            $direccion = !empty($_POST["direccion"]) ? trim($_POST["direccion"]) : ($G->error .= "Falta direccion.<br/>");
            $telefono = !empty($_POST["telf"]) ? trim($_POST["telf"]) : ($G->error .= "Falta telefono.<br/>");
            $ciudad = !empty($_POST["ciudad"]) ? trim($_POST["ciudad"]) : ($G->error .= "Falta ciudad.<br/>");
            $salario = !empty($_POST["salario"]) ? trim($_POST["salario"]) : ($G->error .= "Falta salario.<br/>");

           if( $G->error == "ok" ) {


               $insert_query = $G->db->prepare("INSERT INTO ".DB_PREFIX."camioneros (c_cedula, c_nombres, c_direccion, c_telefono, c_ciudad, c_salario)
            VALUES (?, ?, ?, ?, ?, ?)");

               $insert_query->execute(

                   array( $cedula, $nombres, $direccion, $telefono, $ciudad, $salario)

               );


           }




        }

    }

    //Cargar los registros -->
    $query_camioneros = $G->db->prepare("SELECT * FROM ".DB_PREFIX."camioneros ORDER BY cid ASC");

    $query_camioneros->execute();

    //Existen registros?
    if( $query_camioneros->rowCount() ){
        $G->camioneros = $query_camioneros->fetchAll();
    }else{
        $G->camioneros = null;
    }

    $G->act = isset($_GET["act"]) ? trim($_GET["act"]) : "registros";
    loadView('logged/camioneros.phtml');
}