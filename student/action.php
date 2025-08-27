<?php
require_once "../database/config.php";

$nisn = $_POST["nisn"];
$name = $_POST["name"];
$gender = $_POST["gender"];
$address = $_POST["address"];
$parent = $_POST["parent"];
$parent_phone = $_POST["phone"];

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
} else if (isset($_POST["update"])) {
    $query = "UPDATE student SET nisn = '$nisn',
                                    name = '$name',
                                    gender = '$gender',
                                    address = '$address',
                                    parent = '$parent',
                                    parent_phone = '$parent_phone' WHERE nisn = '$nisn' ";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    header("Location: ../student");
}
?>