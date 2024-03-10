<?php
require_once '../core/database.php';
// pet sitter

if (isset($_POST['p'])) {

    $petName = $_POST['pet_name'];
    $charges = $_POST['charges'];
    $services = $_POST['services_offer'];

    if (!empty($_POST['edit_id'])) {
        $eID = $_POST['edit_id'];
        $sql = $db->query("UPDATE `pet_sitter` SET `pet_name`='$petName', `charges`='$charges', `services_offer`='$services' WHERE `id`='$eID'");
        if ($sql) {
            echo 'Edit Successfully.';
        }
    } else {
        $sql = $db->query("INSERT INTO `pet_sitter` (pet_name,charges,services_offer,sitter_id) VALUES('$petName','$charges','$services','$id')");
        if ($sql) {
            echo 'Submitted Successfully.';
        }
    }
}
