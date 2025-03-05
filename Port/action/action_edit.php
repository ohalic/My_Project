<?php
session_start();
include '../config.php';

// รับค่าจากฟอร์ม
$course_code = $_POST['course_code'];  // รหัสวิชา (ใช้เป็นตัวระบุหลัก)
$course_title = $_POST['course_title']; // ชื่อวิชา
$grade = $_POST['grade']; // เกรด
$credit = $_POST['credit']; // หน่วยกิต (ควรเป็นตัวเลข)

// ตรวจสอบว่าข้อมูลครบหรือไม่
if (!isset($course_code, $course_title, $grade, $credit)) {
    die("Error: ข้อมูลไม่ครบ");
}

// คำสั่ง SQL สำหรับอัปเดตข้อมูล
$sql = "UPDATE subjects SET course_title = ?, grade = ?, credit = ? WHERE course_code = ?";

// เตรียม statement
$stmt = mysqli_prepare($conn, $sql);

// ผูกค่ากับ statement
mysqli_stmt_bind_param($stmt, "ssds", $course_title, $grade, $credit, $course_code);

// Execute คำสั่ง SQL
if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: ../index.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
