<?php

if (!$G->user->isLogged()) {
    renivelectTo("login");
} else {
    $G->error = "ok";
    if ($G->user->data->u_tipo == 1) {
        if (isset($_POST['accion'])) {
            if ($_POST['accion'] == 'eliminar') {
                $id = !empty($_POST["id"]) ? trim(filter_var($_POST["id"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error = "Contiene caracteres no validos");
                $pregunta = !empty($_POST["pregunta"]) ? trim(filter_var($_POST["pregunta"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error = "Contiene caracteres no validos");
                $lenguaje = !empty($_POST["lenguaje"]) ? trim(filter_var($_POST["lenguaje"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error = "Contiene caracteres no validos");
                if (isset($_POST['id'])) {
                    if (strlen($_POST['id']) > 0) {
                        if ($G->error == "ok" && strlen($pregunta) > 0) {
                            $insert_query = $G->db->prepare("DELETE FROM " . DB_PREFIX . "preguntas WHERE p_id='" . $id . "'");

                            $insert_query->execute();
                            $insert_query = $G->db->prepare("DELETE FROM " . DB_PREFIX . "literales WHERE l_id='" . $id . "'");

                            $insert_query->execute();
                            //echo '<option value="' . $id . '"> ' . $_POST['nombre'] . '</option>';
                            //echo '1'; // Agregado
                            echo ("ID -> " . $id . " | Pregunta -> " . $pregunta . " | lenguaje-> " . $lenguaje);
                        } else {
                            echo ("ID -> " . $id . " | Pregunta -> " . $pregunta . " | lenguaje-> " . $lenguaje); //No existe o no se actualizó
                        }
                    } else {
                        echo '3'; //ingrese lenguaje
                    }
                }
            }
            if ($_POST['accion'] == 'responder') {
                $id = !empty($_POST["id"]) ? trim(filter_var($_POST["id"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error = "Contiene caracteres no validos");
                $pregunta = !empty($_POST["pregunta"]) ? trim(filter_var($_POST["pregunta"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error = "Contiene caracteres no validos");
                $lenguaje = !empty($_POST["lenguaje"]) ? trim(filter_var($_POST["lenguaje"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error = "Contiene caracteres no validos");
                if (isset($_POST['id'])) {
                    if (strlen($_POST['id']) > 0) {
                        if ($G->error == "ok" && strlen($pregunta) > 0) {
                            $insert_query = $G->db->prepare("DELETE FROM " . DB_PREFIX . "preguntas WHERE p_id='" . $id . "' AND p_pregunta='" . $pregunta . "'");

                            $insert_query->execute();
                            $insert_query = $G->db->prepare("DELETE FROM " . DB_PREFIX . "literales WHERE l_id='" . $id . "'");

                            $insert_query->execute();
                            //echo '<option value="' . $id . '"> ' . $_POST['nombre'] . '</option>';
                            //echo '1'; // Agregado
                            //echo ("ID -> " . $id . " | Pregunta -> " . $pregunta . " | lenguaje-> " . $lenguaje);
                        }
//                        else {
//                            echo ("ID -> " . $id . " | Pregunta -> " . $pregunta . " | lenguaje-> " . $lenguaje); //No existe o no se actualizó
//                        }
                    } else {
                        echo '3'; //ingrese lenguaje
                    }
                }
            }
        }
    }
    if ($G->user->data->u_tipo == 3) {
        if (isset($_POST['accion'])) {
            if ($_POST['accion'] == 'opciones') {
                $id = !empty($_POST["id"]) ? trim(filter_var($_POST["id"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error = "Contiene caracteres no validos");
                //$pregunta = !empty($_POST["pregunta"]) ? trim(filter_var($_POST["pregunta"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error = "Contiene caracteres no validos");
                //$lenguaje = !empty($_POST["lenguaje"]) ? trim(filter_var($_POST["lenguaje"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error = "Contiene caracteres no validos");
                if (isset($_POST['id'])) {
                    if (strlen($_POST['id']) > 0) {
                        if ($G->error == "ok") {
                            $query = $G->db->prepare("SELECT * FROM " . DB_PREFIX . "literales WHERE l_id='" . $id . "'");

                            $query->execute();
                            //Existen registros?
                            if ($query->rowCount()) {
                                $G->opciones = $query->fetchAll();
                            } else {
                                $G->opciones = null;
                            }
                            $opt='';
                            foreach ($G->opciones as $opciones):
                                $opt.= '<option value="' . $opciones['l_id'] . '"> ' . $opciones['l_respuesta'] . '</option>';
                            endforeach;
                            echo $opt;
                            //echo '1'; // Agregado
                            // echo ("ID -> " . $id . " | Pregunta -> " . $pregunta . " | lenguaje-> " . $lenguaje);
                        }
                    }
                }
            }
        }
    }
}