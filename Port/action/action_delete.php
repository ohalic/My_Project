<?php
session_start();
include '../config.php';

// รับค่าจากฟอร์ม
$course_code = $_POST['course_code']; // รหัสวิชา (ใช้เป็นตัวระบุหลัก)

// ตรวจสอบว่ามีค่า course_code หรือไม่
if (!isset($course_code)) {
    die("Error: ไม่พบรหัสวิชา");
}

// คำสั่ง SQL สำหรับลบข้อมูล
$sql = "DELETE FROM subjects WHERE course_code = ?";

// เตรียม statement
$stmt = mysqli_prepare($conn, $sql);

// ผูกค่ากับ statement
mysqli_stmt_bind_param($stmt, "s", $course_code);

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
