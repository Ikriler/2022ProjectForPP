<?php

class Setting {

    static function setClaimStatus($status) {
        file_put_contents("{$_SERVER['DOCUMENT_ROOT']}/actions/claimstatustxt.php", $status);
    }

    static function getClaimStatus() {
        return file_get_contents("{$_SERVER['DOCUMENT_ROOT']}/actions/claimstatustxt.php");
    }
}   

?>