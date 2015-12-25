<?php

/**
 * Created by PhpStorm.
 * User: PC90
 * Date: 04/12/2015
 * Time: 9:32
 */
if (!$G->user->isLogged()) {
    redirectTo("login");
} else {

//    $query_c = $G->db->query("SELECT * FROM ".DB_PREFIX."camioneros");
//    $query_cc = $G->db->query("SELECT * FROM ".DB_PREFIX."camiones");
//    $query_p = $G->db->query("SELECT * FROM ".DB_PREFIX."paquetes");
//
//    $G->camioneros = $query_c->rowCount();
//    $G->camiones = $query_cc->rowCount();
//    $G->paquetes = $query_p->rowCount();
    if ($G->user->data->u_tipo == 1) {
        $G->contenido = "admin/principal.phtml";
    } else
    if ($G->user->data->u_tipo == 3) {
        $G->contenido = "participante/principal.phtml";
    }
    loadView('home.phtml');
}