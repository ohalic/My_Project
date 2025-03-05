<?php
session_start();
include 'config.php';

//ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT * FROM subjects";
$result = mysqli_query($conn, $sql);

//ค่าคะแนนของเกรด
$grade_values = [
    "A" => 4.0,
    "B+" => 3.5,
    "B" => 3.0,
    "C+" => 2.5,
    "C" => 2.0,
    "D+" => 1.5,
    "D" => 1.0,
    "F" => 0.0,
];

$total_points = 0;
$total_credits = 0;
$subjects = []; // เก็บข้อมูลตารางไว้ใช้ภายหลัง

while ($row = mysqli_fetch_assoc($result)) {
    $subjects[] = $row; // เก็บข้อมูลไว้ก่อนปิด connection
    $grade = $row['grade'];
    $credit = $row['credit'];

    //คำนวณ GPA 
    if (isset($grade_values[$grade])) {
        $total_points += $grade_values[$grade] * $credit;
        $total_credits += $credit;
    }
}

// ป้องกันหารด้วยศูนย์
if ($total_credits > 0) {
    $gpa = round($total_points / $total_credits, 2);
} else {
    $gpa = 0;
}

mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transcript</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>


    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-primary-subtle border border-primary-subtle">
        <div class="container">
            <a class="navbar-brand text-primary-emphasis" href="<?php echo $base_url; ?>/index.php">MY PORTFOLIO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar1">
                <span class="navbar-toggler-icon "></span>
            </button>
            <div class="collapse navbar-collapse " id="navbar1">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-primary-emphasis" href="<?php echo $base_url; ?>/index.php">About me</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary-emphasis" href="<?php echo $base_url; ?>/index.php">Resume</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary-emphasis" href="<?php echo $base_url; ?>/index.php">Transcript</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary-emphasis" href="<?php echo $base_url; ?>/index.php">Contact me</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- transcript -->
    <section id="transcript">
        <div class="color">
            <div class="container">
                <div class="row d-flex align-items-center justify-content-center " style="height: 550px;">
                    <div class="col pt-3">
                        <h2 class="text-center pb-3">Transcript</h2>
                        <table class="table table-hover">
                            <thead>
                                <tr class="table-primary">
                                    <th>Course code</th>
                                    <th>Course title</th>
                                    <th>Grade</th>
                                    <th>Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($subjects as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['course_code']) ?></td>
                                        <td><?= htmlspecialchars($row['course_title']) ?></td>
                                        <td><?= htmlspecialchars($row['grade']) ?></td>
                                        <td><?= htmlspecialchars($row['credit']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="fw-bold">
                                <tr>
                                    <td></td>
                                    <td>Total GPA</td>
                                    <td><?= $gpa ?></td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>

                <!-- edit form -->


                <div class="row pt-3">
                    <div class="input-form">
                        <div class="col text-center">
                            <form action="./action/action_edit.php" method="post">
                                <div class="row justify-content-center">
                                    <div class="col-2">
                                        <input class="form-control" type="text" name="course_code" placeholder="Course Code">
                                    </div>
                                    <div class="col-2">
                                        <input class="form-control" type="text" name="course_title" placeholder="Course Title">
                                    </div>
                                    <div class="col-2">
                                        <input class="form-control" type="text" name="grade" placeholder="Grade">
                                    </div>
                                    <div class="col-2">
                                        <input class="form-control" type="text" name="credit" placeholder="Credit">
                                    </div>
                                    <div class="col-1">
                                        <input type="submit" class="btn btn-warning" value="Edit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>