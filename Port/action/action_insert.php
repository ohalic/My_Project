<?php
session_start();
include '../config.php';
//print_r($_POST);

$course_code = $_POST['course_code'];
$course_title = $_POST['course_title'];
$grade = $_POST['grade'];
$credit = $_POST['credit'];

$sql = "INSERT INTO subjects (course_code, course_title, grade, credit)
        VALUES (?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "sssd", $course_code, $course_title, $grade, $credit);

if(mysqli_stmt_execute($stmt)){
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: ../index.php");
    exit();
} else {
    echo "Error: ". $sql . "<br>" . mysqli_error($conn);
}
?>