<?php

/**
 * Created by PhpStorm.
 * User: PC90
 * Date: 04/12/2015
 * Time: 9:46
 */
//Cargar las vistas o templates dependiendo del userLogged -->
if (!$G->user->isLogged()) {

    // Gestionar los errores del formulario de login -->
    $G->error = "ok";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!empty($_POST['user']) && !empty($_POST['pass'])) {

            // Recoger los datos del form -->
            $user = htmlspecialchars(trim($_POST['user']));
            $password = htmlspecialchars(trim($_POST['pass']));
            $password_hashed = hash("sha256", $password);

            //Existe el usuario?
            if ($existData = $G->user->exists(0, $user)) {

                if ($existData["u_password"] == $password_hashed) {
                    $G->user->loadData($existData);
                    $insert_query = $G->db->prepare("UPDATE " . DB_PREFIX . "usuarios set u_sesion=1 WHERE u_id=" .$_SESSION["id"]. " AND u_nick='". $_SESSION["user"]."'");
                    $insert_query->execute();
                    redirectTo("home");
                } else {
                    $G->error = "La contrase&ntilde;a ingresa es incorrecta.";
                }
            } else {
                $G->error = "El usuario al que intenta acceder no existe!";
            }
        } else {

            $G->error = "Debe completar todos los campos.";
        }
    }

    loadView("login.phtml");
} else {

    redirectTo("home");
}