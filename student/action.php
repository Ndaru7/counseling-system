<?php
require_once "../database/config.php";

$nisn = $_POST["nisn"];
$name = $_POST["name"];
$gender = $_POST["gender"];
//$point = $_POST["point"];
$address = $_POST["address"];
$parent = $_POST["parent"];
$parent_phone = $_POST["parentPhone"];

if (isset($_POST["save"])) {
    $query = "INSERT INTO student (nisn,
                name,
                gender,
                address,
                parent,
                parent_phone) VALUES ('$nisn',
                                        '$name',
                                        '$gender',
                                        '$address',
                                        '$parent',
                                        '$parent_phone')";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    header("Location: ../student");
}
?>