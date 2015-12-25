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
            $desc = !empty($_POST["desc"]) ? trim($_POST["desc"]) : ($G->error .= "Falta Descripcion.<br/>");
            $dest = !empty($_POST["dest"]) ? trim($_POST["dest"]) : ($G->error .= "Falta destinatario.<br/>");
            $dir = !empty($_POST["direccion"]) ? trim($_POST["direccion"]) : ($G->error .= "Falta direccion.<br/>");
            $camionero = !empty($_POST["camionero"]) ? trim($_POST["camionero"]) : ($G->error .= "Falta cedula del camionero.<br/>");
            $prov =!empty($_POST["provincia"]) ? trim($_POST["provincia"]) : ($G->error .= "Falta provincia.<br/>");

            if( $G->error == "ok" ) {


                $insert_query = $G->db->prepare("INSERT INTO ".DB_PREFIX."paquetes (p_codigo, p_desc, p_dest, p_direccion, p_camionero, p_provincia)
            VALUES (?, ?, ?, ?, ?, ?)");

                $insert_query->execute(

                    array( $codigo, $desc, $dest, $dir, $camionero, $prov )

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

    //Cargar los registros -->
    $query = $G->db->prepare("SELECT * FROM ".DB_PREFIX."paquetes ORDER BY pid ASC");

    $query->execute();

    //Existen registros?
    if( $query->rowCount() ){
        $G->paquetes = $query->fetchAll();
    }else{
        $G->paquetes = null;
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
    loadView('logged/paquetes.phtml');
}