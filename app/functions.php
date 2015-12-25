<?php
/**
 * Created by PhpStorm.
 * User: PC90
 * Date: 04/12/2015
 * Time: 9:02
 */

//Evitar la inclusion directa de archivos -->
defined("ALDAV") ? null : die("[Error]: No se puede acceder directamente a este archivo.");

function loadErrorHandler( $error_n, $error_str, $error_file, $error_line ){

    echo "<strong>[Error-Excepci&oacute;n]</strong><br/>";
    echo "<strong>Archivo:</strong> ".$error_file;
    echo "<strong>L&iacute;nea:</strong> ".$error_line;

    throw new ErrorException($error_str, 0, $error_n, $error_file, $error_line );

}

function customPDOError( $code, $trace ){

    if(!is_array($trace)) return "Error Desconocido!";

    $error = "<strong>Conexi&oacute;n a la Base de Datos</strong><br/>";
    $error_title = "";

    if( $code == 1049 ){

        $error_title = "La base de datos que quiere conectar, no existe.";

    }elseif( $code == 2002 ){

        $error_title = "El servidor o host es incorrecto.";

    }elseif( $code == 1044 ){

        $error_title = "El nombre de usuario es incorrecto";

    }elseif( $code == 1045 ){
        $error_title = "La contrase&ntilde;a ingresada es incorrecta.";
    }

    $error .= $error_title;

    $error .= "<br/><strong>Archivo:</strong> ".$trace[0]["file"];
    $error .= "<br/><strong>L&iacute;nea:</strong> ".$trace[0]["line"];

    return $error;

}

function __autoload( $nameClass ){

    $nameClass = strtolower(trim(basename($nameClass)));

    $path = ROOT."app".DS."models".DS."c_".$nameClass.".php";

    if( file_exists($path) ){

        require_once( $path );

    }else{

        die("[Error]: No se ha podido cargar la clase: <strong>".ucfirst($nameClass)."</strong>");

    }

}

function loadController($controller){
    global $G, $config;
    if($path=isController($controller)){
       require_once ($path);
    }else{
        die('No se puede cargar el controlador');
    }
}
function isController($controller){
    $path=ROOT.'app'.DS.'controllers'.DS.$controller.'.php';
    if(file_exists($path)){
        return $path;
    }else{
        return false;
    }
}
function loadView($page){
    global $G;

    $path=ROOT.'app'.DS.'views'.DS.$page;
    if(file_exists($path)){
        require_once($path);
    }else{
        echo 'No se puede cargar la vista: '. basename($page);
    }
}

function redirectTo( $location ){
    if( !headers_sent()){
        header("Location: ".$location);
    }
}