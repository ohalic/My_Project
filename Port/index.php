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
    <title>Natnicha</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-primary-subtle border border-primary-subtle">
        <div class="container">
            <a class="navbar-brand text-primary-emphasis" href="#">MY PORTFOLIO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar1">
                <span class="navbar-toggler-icon "></span>
            </button>
            <div class="collapse navbar-collapse " id="navbar1">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-primary-emphasis" href="#aboutme">About me</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary-emphasis" href="#resume">Resume</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary-emphasis" href="#transcript">Transcript</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary-emphasis" href="#contact">Contact me</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- เกี่ยวกับฉัน -->

    <section id="aboutme">
        <div class="color">
            <div class="container">
                <div class="row abtme py-5 d-flex align-items-center justify-content-center" style="height: 550px;">
                    <div class="col-md-6">
                        <img src="../Port/img/bam.jpg" class="rounded abtme-image mx-auto" width="auto"
                            height="300px" alt="">
                    </div>
                    <div class="col-md-6 text-center">
                        <h2 class="abtme-heading mb-5">
                            About Me
                        </h2>
                        <p class="text-center">
                            I am currently a third-year Computer Science student at Kasetsart University, Sriracha
                            Campus
                            with a GPA of 3.45.
                            I interest in front-end and back-end web development and Business Analysis (such as Python,
                            C,
                            Java, MySQL, Tableau).
                            I am excited to use the skills I have learned in my knowledge and past work experience and
                            contribute to this internship.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- resume -->

    <section id="resume">
        <div class="bg-primary-subtle text-primary-emphasis">
            <div class="container">
                <div class="row allresume py-5" style="height: 550px;">
                    <h2 class="text-center">RESUME</h2>
                    <div class="row resume1 pt-3 d-flex align-items-start justify-content-between ">
                        <div class="col-md-6 text-center">
                            <p class="fw-bold"><i class="bi bi-star-fill me-3"></i>PERSONAL SKILLS</p>
                            <ul class="list-unstyled">
                                <li>Positive Attitude</li>
                                <li>Adaptabillity</li>
                                <li>Emotional Intelligence and Empathy</li>
                            </ul>
                        </div>
                        <div class="col-md-6 text-center">
                            <p class="fw-bold"><i class="bi bi-translate me-3"></i>LANGUAGES</p>
                            <ul class="list-unstyled">
                                <li>Thai</li>
                                <li>English</li>
                            </ul>

                        </div>
                    </div>
                    <div class="resume2 pt-3 text-center">
                        <p class="fw-bold"><i class="bi bi-stars me-3"></i>SKILLS</p>
                        <ul class="list-unstyled">
                            <li>Research & Data Analysis : Power BI, Tableau, Excel</li>
                            <li>Programming Languages : Python, C, JavaScript, Arduino</li>
                            <li>Web Development(Frontend) : HTML, CSS, Javascript, PHP</li>
                            <li>Web Development(Backend) : MySQL</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- transcript -->
    <section id="transcript">
        <div class="color">
            <div class="container">
                <div class="row d-flex align-items-center justify-content-center " style="height: 550px;">
                    <div class="col py-5">
                        <h2 class="text-center pb-3">Transcript</h2>
                        <table class="table">
                            <thead>
                                <tr>
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
                        <div class="d-flex justify-content-center pt-3 gap-5">
                            <a href="<?php echo $base_url; ?>/add.php" class="btn btn-info">Add</a>
                            <a href="<?php echo $base_url; ?>/edit.php" class="btn btn-warning">Edit</a>
                            <a href="<?php echo $base_url; ?>/delete.php" class="btn btn-danger">Delete</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- contact me -->
    <section id="contact">
        <div class="bg-primary-subtle text-primary-emphasis">
            <div class="container">
                <div class="row allcontact d-flex align-items-center justify-content-center " style="height: 550px;">
                    <div class="col py-5 text-center">
                        <h2>Contact Me</h2>
                        <ul class="list-unstyled pt-3 d-flex flex-column gap-3">
                            <li><i class="bi bi-telephone-fill me-3"></i>0650605893</li>
                            <li><i class="bi bi-envelope-fill me-3"></i>ohalics3388@gmail.com</li>
                            <li><i class="bi bi-github me-3"></i>https://github.com/ohalic</li>
                            <li><i class="bi bi-house-fill me-3"></i>350 Moo.1 Sukhumvit Road,Bangpumai, MueangSamutprakan,Samutprakan,
                                10280</li>
                        </ul>
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