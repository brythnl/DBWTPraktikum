<?php

function successfulLoginUpdate($id) {
    date_default_timezone_set('Europe/Berlin');
    $date = date("Y-m-d H:i:s"); // get current time

    $link = connectdb();
    
    mysqli_begin_transaction($link);
    mysqli_query($link, "CALL Anmeldungszahler($id)");
    mysqli_query($link, "UPDATE benutzer SET letzteanmeldung = '$date' WHERE id = $id");
    mysqli_commit($link);

    mysqli_close($link);
}

function incLogin(/*$username,*/$id) {
    $link = connectdb();
    
    $sql = mysqli_stmt_init($link);
    /*
    mysqli_stmt_prepare($sql, 
        "UPDATE benutzer SET anzahlanmeldungen = anzahlanmeldungen + 1 WHERE email = ?");
    mysqli_stmt_bind_param($sql, 's',
        $username);
    */
    mysqli_stmt_prepare($sql,
      "CALL Anmeldungszahler($id)");
    mysqli_stmt_execute($sql);
    mysqli_close($link);
}

function setLoginTime($username, $error) {
    $link = connectdb();

    date_default_timezone_set('Europe/Berlin');
    $date = date("Y-m-d H:i:s"); // get current time

    $sql = mysqli_stmt_init($link);
    mysqli_stmt_prepare($sql,
        "UPDATE benutzer SET " . (!$error ? "letzteanmeldung" : "letzterfehler") . " = '$date' WHERE email = ?");
    mysqli_stmt_bind_param($sql, 's',
        $username);
    mysqli_stmt_execute($sql);

    mysqli_close($link);
        
}

function getLoginData() {
    $link = connectdb();

    $sql = "SELECT id, email, passwort FROM benutzer";
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($link);

    return $data;
}

function checkAdmin($user) {
    $link = connectdb();
    $sql = "SELECT ADMIN FROM benutzer WHERE email = '$user'";
    $result = mysqli_query($link, $sql);

    mysqli_close($link);

    if (mysqli_fetch_assoc($result)['ADMIN'] == 1) {
        return true;
    } else {
        return false;
    }
}
?>
