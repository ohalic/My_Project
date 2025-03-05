<?php
//var url
$base_url = 'http://localhost/Port';

//var database
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'edittrans';

//connect database
$conn = mysqli_connect($db_host,$db_user,$db_pass,$db_name) or die('connection failed'); // ทำการ connect database แต่ถ้าเชื่อมไม่ได้ให้ขึ้น connection failed

//prefix session
define('AB', 'editmytranscript'); // กำหนดตัวแปรค่าคงที่ กัน session ซ้ำกับระบบอื่น