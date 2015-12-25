<?php
//Cerrar sesion del usuario -->
if( $G->user->isLogged()){
    $G->user->logout();
}