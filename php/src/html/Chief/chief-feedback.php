<?php
include "../connection.php";

try {
    $conn = new PDO("pgsql:host={$servername};port={$port};dbname={$dbname}", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ดึงข้อมูล department จากตาราง department
    $departmentQuery = "SELECT dept_id, dept_name FROM departments";
    $stmtDept = $conn->prepare($departmentQuery);
    $stmtDept->execute();
    $departments = $stmtDept->fetchAll(PDO::FETCH_ASSOC);

    // ดึงข้อมูล employee จากตาราง employees
    $employeeQuery = "SELECT e_id, firstname, dept_id FROM employees";
    $stmtEmp = $conn->prepare($employeeQuery);
    $stmtEmp->execute();
    $employees = $stmtEmp->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MAFIA APPRAISAL</title>
    <link rel="shortcut icon" type="image/png" href="../../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../../assets/css/styles.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="./../index.php" class="text-nowrap logo-img">
                        <img src="../../assets/images/logos/appraisal.png" width="150" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Tools</span>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./chief-dashboard.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file-description"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./chief-forms_check.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file-description"></i>
                                </span>
                                <span class="hide-menu">Forms</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./chief-feedback.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Feedback</span>
                            </a>
                        </li>

                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">AUTH</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./../index.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-login"></i>
                                </span>
                                <span class="hide-menu">Logout</span>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                <i class="ti ti-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="../../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="./chief-profile.php" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <a href="./../index.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
            <div class="container-fluid">
                <div class="card">

                    <div class="container">
                        <h2>Employee Feedback Form</h2>
                        <form id="feedbackForm" method="POST">

                            <!-- Department Selection -->
                            <div class="form-group">
                                <label for="department">Department</label>
                                <select id="department" name="department" required>
                                    <option value="">--Select Department--</option>
                                    <?php foreach ($departments as $department): ?>
                                        <option value="<?php echo $department['dept_id']; ?>">
                                            <?php echo $department['dept_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="error" id="departmentError"></small>
                            </div>

                            <!-- Combined Employee Information (Dropdown) -->
                            <div class="form-group">
                                <label for="employee">Employee</label>
                                <select id="employee" name="employee" required>
                                    <option value="">--Select Employee--</option>
                                    <?php foreach ($employees as $employee): ?>
                                        <option value="<?php echo $employee['e_id']; ?>" data-department="<?php echo $employee['dept_id']; ?>">
                                            <?php echo $employee['firstname']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="error" id="employeeError"></small>
                            </div>

                            <!-- Feedback Details -->
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" id="subject" name="subject" required>
                                <small class="error" id="subjectError"></small>
                            </div>

                            <div class="form-group">
                                <label for="details">Details</label>
                                <textarea id="details" name="details" rows="5" required></textarea>
                                <small class="error" id="detailsError"></small>
                            </div>

                            <!-- Date of Feedback -->
                            <div class="form-group">
                                <label for="feedbackDate">Date of Feedback</label>
                                <input type="date" id="feedbackDate" name="feedbackDate" required>
                            </div>

                            <div class="form-group">
                                <input type="submit" value="Submit Feedback">

                                <?php

                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    // รับข้อมูลจากฟอร์ม
                                    $department = $_POST['department'];
                                    $employee = $_POST['employee'];
                                    $subject = $_POST['subject'];
                                    $details = $_POST['details'];
                                    $feedbackDate = $_POST['feedbackDate'];

                                    // เตรียมคำสั่ง SQL สำหรับบันทึกข้อมูล
                                    $sql = "INSERT INTO feedback (dept_id, e_id, subjects, detail, feedback_date) 
                                            VALUES (:department, :employee, :subject, :details, :feedback_date)";

                                    // เตรียม execute statement
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute([
                                        ':department' => $department,
                                        ':employee' => $employee,
                                        ':subject' => $subject,
                                        ':details' => $details,
                                        ':feedback_date' => $feedbackDate
                                    ]);

                                    // หากสำเร็จจะแสดงข้อความแจ้งเตือน
                                    echo "<script>alert('Feedback submitted successfully!'); window.location.href='feedback.php';</script>";
                                }
                                ?>

                            </div>

                        </form>
                    </div>

                    <script>
                        const departmentSelect = document.getElementById('department');
                        const employeeSelect = document.getElementById('employee');

                        // ฟังก์ชั่นกรองพนักงานตามแผนก
                        departmentSelect.addEventListener('change', function() {
                            const selectedDepartment = departmentSelect.value;

                            // ลบพนักงานที่ไม่ตรงกับแผนกที่เลือกออกจาก dropdown
                            for (let i = 0; i < employeeSelect.options.length; i++) {
                                const option = employeeSelect.options[i];
                                if (option.getAttribute('data-department') === selectedDepartment || option.value === "") {
                                    option.style.display = 'block';
                                } else {
                                    option.style.display = 'none';
                                }
                            }
                        });
                    </script>
                </div>
            </div>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                }

                .container {
                    max-width: 800px;
                    margin: 50px auto;
                    background-color: #fff;
                    padding: 20px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    border-radius: 8px;
                }

                h2 {
                    text-align: center;
                    color: #333;
                }

                .form-group {
                    margin-bottom: 15px;
                }

                label {
                    display: block;
                    font-weight: bold;
                    margin-bottom: 5px;
                }

                input[type="text"],
                input[type="date"],
                textarea,
                select {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    font-size: 16px;
                }

                input[type="submit"] {
                    background-color: #28a745;
                    color: white;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 16px;
                }

                input[type="submit"]:hover {
                    background-color: #218838;
                }

                .error {
                    color: red;
                    font-size: 14px;
                }
            </style>
            <script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
            <script src="../../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../../assets/js/sidebarmenu.js"></script>
            <script src="../../assets/js/app.min.js"></script>
            <script src="../../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
            <script src="../../assets/libs/simplebar/dist/simplebar.js"></script>
            <script src="../../assets/js/dashboard.js"></script>

</body>

</html>