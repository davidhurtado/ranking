<?php

/**
 * Created by PhpStorm.
 * User: PC90
 * Date: 04/12/2015
 * Time: 11:06
 */
if (!$G->user->isLogged()) {
    redirectTo($G->config["w_url"] . DS . 'login');
} else {
    $G->error = "ok";
    //Cargar los registros -->
    $query_preguntasID = $G->db->prepare("SELECT * FROM " . DB_PREFIX . "preguntas ORDER BY p_id DESC limit 1");

    $query_preguntasID->execute();

    //Existen registros?
    if ($query_preguntasID->rowCount()) {
        $G->preguntasID = $query_preguntasID->fetchAll();
        foreach ($G->preguntasID as $id_p):
            $id = $id_p["p_id"] + 1;
        endforeach;
        $G->IDP = $id;
        //$id = $G->preguntasID->p_id;
    } else {
        $G->preguntasID = null;
        $id = 1;
        $query_preguntasID = $G->db->prepare("ALTER TABLE preguntas AUTO_INCREMENT = 0");
        $query_preguntasID->execute();

        $G->IDP = $id;
    }
    if ($G->user->data->u_tipo == 1) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (!empty($_POST["pregunta"])) {


                //$id = 1; //!empty($_POST["id"]) ? trim($_POST["id"]) : ($G->error .= "ID.<br/>");
                $pregunta = !empty($_POST["pregunta"]) ? trim(filter_var($_POST["pregunta"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error .= "Falta la pregunta.<br/>");
                $descripcion = !empty($_POST["descripcion"]) ? trim(filter_var($_POST["descripcion"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error .= "Falta la Descripcion.<br/>");
                $respuesta = !empty($_POST["respuesta"]) ? trim(filter_var($_POST["respuesta"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error .= "Falta las respuestas.<br/>");
                $nivel = !empty($_POST["nivel"]) ? trim(filter_var($_POST["nivel"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error .= "Falta el nivel.<br/>");
                $id_lenguaje = !empty($_POST["id_lenguaje"]) ? trim(filter_var($_POST["id_lenguaje"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error .= "Falta el ID del lenguaje.<br/>");
                $opciones = !empty($_POST["opciones"]) ? $_POST["opciones"] : ($G->error .= "Falta opciones.<br/>");

                if ($G->error == "ok") {
                    $insert_query = $G->db->prepare("INSERT INTO " . DB_PREFIX . "preguntas (p_pregunta, p_descripcion, p_respuesta, p_nivel, p_id_lenguaje)
            VALUES (?, ?, ?, ?, ?)");

                    $insert_query->execute(
                            array($pregunta, $descripcion, $respuesta, $nivel, $id_lenguaje)
                    );
                    //Cargar los registros -->
                    $query_preguntasID = $G->db->prepare("SELECT * FROM " . DB_PREFIX . "preguntas ORDER BY p_id DESC limit 1");

                    $query_preguntasID->execute();
                    //Existen registros?
                    if ($query_preguntasID->rowCount()) {
                        $G->preguntasID = $query_preguntasID->fetchAll();
                        foreach ($G->preguntasID as $id_p):
                            $id = $id_p["p_id"];
                        endforeach;
                    } else {
                        $G->preguntasID = null;
                        $id = 1;
                    }
                    $letra = 'a';
                    foreach ($opciones as $opc) :
                        $insert_opciones = $G->db->prepare("INSERT INTO " . DB_PREFIX . "literales (l_id,l_letra,l_respuesta)
            VALUES (?, ?, ?)");

                        $insert_opciones->execute(
                                array($id, $letra, trim(filter_var($opc, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)))
                        );
                        ++$letra . PHP_EOL;
                    endforeach;
                }else{
                    $G->error .= "Verifique lo que ingresa.</br>";
                }
                $G->act = 'lista';
                redirectTo('agregar');
            }
        }
    }

    //Cargar los registros -->
    $query_preguntas = $G->db->prepare("SELECT * FROM " . DB_PREFIX . "preguntas ORDER BY p_id ASC");

    $query_preguntas->execute();

    //Existen registros?
    if ($query_preguntas->rowCount()) {
        $G->preguntas = $query_preguntas->fetchAll();
    } else {
        $G->preguntas = null;
    }

    //Cargar los registros -->
    $query = $G->db->prepare("SELECT * FROM " . DB_PREFIX . "lenguajes ORDER BY l_id ASC");

    $query->execute();

    //Existen registros?
    if ($query->rowCount()) {
        $G->lenguajes = $query->fetchAll();
    } else {
        $G->lenguajes = null;
    }

    $G->act = isset($_GET["act"]) ? trim($_GET["act"]) : "lista";
    if ($G->act == 'agregar') {
        if ($G->user->data->u_tipo == 1) {
            $G->contenido = 'preguntas.phtml';
        } else {
            redirectTo($G->config["w_url"].DS.'logout');
        }
    }
    if ($G->act == 'lista-lenguaje' || $G->act == 'agregar-lenguaje') {
        if ($G->user->data->u_tipo == 1) {
            $G->contenido = 'preguntas.phtml';
        } else {
            redirectTo($G->config["w_url"].DS.'logout');
        }
    }
    $G->contenido = 'preguntas.phtml';



    loadView('home.phtml');
}