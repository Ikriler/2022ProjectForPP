<?php

function getFillOrEmptyString($whatIneed, $frameName) {
    if(isset($_SESSION[$frameName][$whatIneed])) {
        return $_SESSION[$frameName][$whatIneed];
    }
    else {
        return "";
    }
}

function checkSpecArrayOnChecked($number) {
    $flag = false;
    if(isset($_SESSION["frameThirdData"]["spec"])) {
        if(is_array($_SESSION["frameThirdData"]["spec"])) {
            foreach($_SESSION["frameThirdData"]["spec"] as $checkNum) {
                if($checkNum == $number) {
                    $flag = true;
                }
            }
        }
        else {
            $flag = $_SESSION["frameThirdData"]["spec"] == $number;
        }
    }
    return $flag;
}

?>