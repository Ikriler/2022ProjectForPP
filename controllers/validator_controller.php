<?php

function getErrorMessage($fieldName) {
    if(isset($_SESSION['errors'][$fieldName])) {
        $message = $_SESSION['errors'][$fieldName];
        unset($_SESSION['errors'][$fieldName]);
        session_write_close();
        return $message;
    }
    return "";
}

?>