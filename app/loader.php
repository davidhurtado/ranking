<?php
/**
 * Created by PhpStorm.
 * User: PC90
 * Date: 04/12/2015
 * Time: 9:02
 */

//Evitar la inclusion directa de archivos -->
defined("ALDAV") ? null : die("[Error]: No se puede acceder directamente a este archivo.");

//Control de errores -->
error_reporting(E_ALL);
ini_set("display_errors", 1 );

//Gestor de sesiones -->
session_start();

//Rutas y Directorios -->
defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
defined("ROOT") ? null : define("ROOT", dirname(__FILE__).DS."..".DS );

// Crear objeto o clase vacia -->
$G = new StdClass();

// Incluir el archivo de funciones generales -->
require_once (ROOT.DS."app".DS."functions.php");

// Gestionar las Excepciones -->
set_error_handler("loadErrorHandler");

// Incluir el archivo de configuracion de base de datos -->
require_once (ROOT.DS."app".DS."config.php");

// Conectar a la Base de Datos -->
try{

    $G->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);

    //Cargamos la configuracion del sitio -->
    $query_config = $G->db->prepare("SELECT * FROM ".DB_PREFIX."config WHERE wid = 1");
    $query_config->execute();

    if( $query_config->rowCount() ){
        $G->config = $query_config->fetch();
    }

}catch ( PDOException $e ){

    die( customPDOError($e->getCode(), $e->getTrace()));

}

//Crear la instancia de la clase Usuario -->
$G->user = new User();

$G->controller = isset($_GET["controller"]) ? htmlentities(trim($_GET["controller"])) : "home";

loadController( $G->controller );