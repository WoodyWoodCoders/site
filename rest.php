<?php

if (!empty($_GET)) {
    echo json_encode(
        array_merge($_GET, array("GET"))
    );
} elseif (!empty($_POST)) {
    echo json_encode(
        array_merge($_POST, array("POST"))
    );
} else {
    echo json_encode(
        array("OK mais requête vide")
    );
}
