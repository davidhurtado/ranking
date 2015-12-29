<?php

if (!$G->user->isLogged()) {
    renivelectTo("login");
} else {
    $G->error = "ok";
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] == 'agregar') {
            if (isset($_POST['nombre'])) {

                $nombre = !empty($_POST["nombre"]) ? trim(filter_var($_POST["nombre"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error = "Falta contiene caracteres no validos");

                if ($G->error == "ok" && strlen($nombre) > 0) {
                    $insert_query = $G->db->prepare("INSERT INTO " . DB_PREFIX . "lenguajes (l_lenguaje)
            VALUES (?)");

                    $insert_query->execute(
                            array($nombre)
                    );
                    $query_lenguajesID = $G->db->prepare("SELECT * FROM " . DB_PREFIX . "lenguajes ORDER BY l_id DESC limit 1");

                    $query_lenguajesID->execute();

                    //Existen registros?
                    if ($query_lenguajesID->rowCount()) {
                        $G->lenguajesID = $query_lenguajesID->fetchAll();
                        foreach ($G->lenguajesID as $id_p):
                            $id = $id_p["l_id"];

                        endforeach;
                        $lenguaje = $id_p["l_lenguaje"];
                        $G->IDP = $id;
                        //$id = $G->lenguajesID->p_id;
                    } else {
                        $G->lenguajesID = null;
                        $id = 1;
                    }
                    if (isset($_POST['page'])) {
                        if ($_POST['page'] == 'preguntas') {
                            echo '<option value="' . $id . '"> ' . $_POST['nombre'] . '</option>';
                        }
                    }
                }
            }
        }
        if ($_POST['accion'] == 'editar') {
            if (isset($_POST['nombre_lenguaje'])) {
                if (strlen($_POST['nombre_lenguaje']) > 0) {
                    $nombre = !empty($_POST["nombre_lenguaje"]) ? trim(filter_var($_POST["nombre_lenguaje"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error = "Falta contiene caracteres no validos");

                    if ($G->error == "ok" && strlen($nombre) > 0) {
                        $insert_query = $G->db->prepare("UPDATE " . DB_PREFIX . "lenguajes set l_lenguaje='" . $_POST['nombre_lenguaje'] . "' WHERE l_id='" . $_POST['id_lenguaje'] . "'");

                        $insert_query->execute();
                        //echo '<option value="' . $id . '"> ' . $_POST['nombre'] . '</option>';
                        echo '1'; // Agregado
                    } else {
                        echo '2'; //No existe o no se actualizó
                    }
                } else {
                    echo '3'; //ingrese lenguaje
                }
            }
        }
        if ($_POST['accion'] == 'eliminar') {
            if (isset($_POST['nombre'])) {
                if (strlen($_POST['nombre']) > 0) {
                    $nombre = !empty($_POST["nombre"]) ? trim(filter_var($_POST["nombre"], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH)) : ($G->error = "Falta contiene caracteres no validos");

                    if ($G->error == "ok" && strlen($nombre) > 0) {
                        $insert_query = $G->db->prepare("DELETE FROM " . DB_PREFIX . "lenguajes WHERE l_lenguaje='" . $_POST['nombre'] . "' AND l_id='" . $_POST['id'] . "'");

                        $insert_query->execute();
                        //echo '<option value="' . $id . '"> ' . $_POST['nombre'] . '</option>';
                        echo '1'; // Agregado
                    } else {
                        echo '2'; //No existe o no se actualizó
                    }
                } else {
                    echo '3'; //ingrese lenguaje
                }
            }
        }
    }
}