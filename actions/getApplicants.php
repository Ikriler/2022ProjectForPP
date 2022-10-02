<?php

require_once "../controllers/db_controller.php";

print json_encode($DB->getApplicantsForTable());
?>