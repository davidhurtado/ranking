<?php
//Cerrar sesion del usuario -->
if( $G->user->isLogged()){
    $insert_query = $G->db->prepare("UPDATE " . DB_PREFIX . "usuarios set u_sesion=0 WHERE u_id=" .$_SESSION["id"]. " AND u_nick='". $_SESSION["user"]."'");
                    $insert_query->execute();
    $G->user->logout();
}else{
    redirectTo($G->config["w_url"].DS.'login');
}