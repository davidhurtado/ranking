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

        if( !empty($_POST["matricula"]) ){



            $matricula = !empty($_POST["matricula"]) ? trim($_POST["matricula"]) : ($G->error .= "Falta matricula.<br/>");
            $modelo = !empty($_POST["modelo"]) ? trim($_POST["modelo"]) : ($G->error .= "Falta modelo.<br/>");
            $tipo = !empty($_POST["tipo"]) ? trim($_POST["tipo"]) : ($G->error .= "Falta tipo.<br/>");
            $potencia = !empty($_POST["potencia"]) ? trim($_POST["potencia"]) : ($G->error .= "Falta potencia.<br/>");
            //$camionero = !empty($_POST["camionero"]) ? trim($_POST["camionero"]) : ($G->error .= "Falta cedula del camionero.<br/>");


            if( $G->error == "ok" ) {


                $insert_query = $G->db->prepare("INSERT INTO ".DB_PREFIX."camiones (c_matricula, c_modelo, c_tipo, c_potencia)
            VALUES (?, ?, ?, ?)");

                $insert_query->execute(

                    array( $matricula, $modelo, $tipo, $potencia)

                );


            }




        }

    }


    //Cargar los registros -->
    $query = $G->db->prepare("SELECT * FROM ".DB_PREFIX."camiones ORDER BY cid ASC");

    $query->execute();

    //Existen registros?
    if( $query->rowCount() ){
        $G->camiones = $query->fetchAll();
    }else{
        $G->camiones = null;
    }

    $G->act = isset($_GET["act"]) ? trim($_GET["act"]) : "registros";
    loadView('logged/camiones.phtml');
}