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

        if( !empty($_POST["codigo"]) ){



            $codigo = !empty($_POST["codigo"]) ? trim($_POST["codigo"]) : ($G->error .= "Falta codigo.<br/>");
            $nombre = !empty($_POST["nombre"]) ? trim($_POST["nombre"]) : ($G->error .= "Falta nombre.<br/>");
            //$camionero = !empty($_POST["camionero"]) ? trim($_POST["camionero"]) : ($G->error .= "Falta cedula del camionero.<br/>");


            if( $G->error == "ok" ) {


                $insert_query = $G->db->prepare("INSERT INTO ".DB_PREFIX."provincias (p_codigo, p_nombre)
            VALUES (?, ?)");

                $insert_query->execute(

                    array( $codigo, $nombre )

                );


            }




        }

    }


    //Cargar los registros -->
    $query = $G->db->prepare("SELECT * FROM ".DB_PREFIX."provincias ORDER BY pid ASC");

    $query->execute();

    //Existen registros?
    if( $query->rowCount() ){
        $G->provincias = $query->fetchAll();
    }else{
        $G->provincias = null;
    }

    $G->act = isset($_GET["act"]) ? trim($_GET["act"]) : "registros";
    loadView('logged/provincias.phtml');
}