<?php

    include_once 'config.php';
    include_once 'inc_view/init.php';

    $isAuth = $inValidUser = false;

    if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['login-form'])) {
        if ($_POST['email'] == AUTH_USERNAME && $_POST['password'] == AUTH_PASSWORD) {
            $isAuth = $inValidUser = true;
        } else {
            $showError = true;
        }
    } else if(isset($_POST['upload_file'])) {
        $isAuth = true;
    }

    if ($isAuth === false) {
        deleteAll(TEMP_FOLDER, true);
        include_once 'login-user.php';
    } else {
        include_once 'auth-user.php';
    }

?> 
