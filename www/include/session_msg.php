<?php

function successMsg($success, $loc) {
    $_SESSION['success'] = $success;
    if(isset($loc)) {
        header('refresh:3;$loc');
    }
}

function errorMsg($error, $loc) {
    $_SESSION['error'] = $error;
    if(isset($loc)) {
        header('refresh:3;$loc');
    }
}


?>