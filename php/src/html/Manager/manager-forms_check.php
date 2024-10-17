<?php
session_start();
include "../connection.php";

// ตรวจสอบว่ามีการเข้าสู่ระบบหรือไม่
if (!isset($_SESSION['currentUserId'])) {
    header("Location: index.php");
    exit();
}

// ประมวลผล POST ก่อนแสดงผล HTML
$categoryMapping = [
    'work' => ['id' => 1, 'redirect' => '../form1.php'],
    'personality' => ['id' => 2, 'redirect' => '../form2.php']
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // รับข้อมูลจากฟอร์ม
        $employee = $_POST['employee'];
        $category = $_POST['topic'];

        // ตรวจสอบว่า category ถูกต้องหรือไม่
        if (isset($categoryMapping[$category])) {
            $categoryId = $categoryMapping[$category]['id'];
            $redirectPage = $categoryMapping[$category]['redirect'];
        } else {
            throw new Exception("Invalid category selected");
        }

        // เตรียมคำสั่ง SQL สำหรับบันทึกข้อมูล
        $sql = "INSERT INTO form_appraisal (topic_id, evaluator_id, evaluatee_id) 
                VALUES (:category, :evaluator_id, :employee) RETURNING form_id";

        // เตรียม execute statement
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':category' => $categoryId,
            ':evaluator_id' => $_SESSION['currentUserId'],
            ':employee' => $employee
        ]);

        $formId = $stmt->fetch(PDO::FETCH_ASSOC)['form_id'];

            header("Location: $redirectPage?form_id=$formId&topic_id=$categoryId");
            exit(); // หยุดการประมวลผลทันทีหลังจากส่ง header
    } catch (Exception $e) {
        // จัดการข้อผิดพลาดหากมีการ exception
        $errorMessage = "Error: " . $e->getMessage();
    }
}

// ดึงข้อมูลแผนกจากฐานข้อมูล
try {
    $conn = new PDO("pgsql:host={$servername};port={$port};dbname={$dbname}", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ดึงข้อมูลแผนก
    $departmentQuery = "SELECT dept_id, dept_name FROM departments";
    $stmtDept = $conn->prepare($departmentQuery);
    $stmtDept->execute();
    $departments = $stmtDept->fetchAll(PDO::FETCH_ASSOC);

    // ดึงข้อมูลพนักงาน
    $employeeQuery = "SELECT e_id, firstname, dept_id FROM employees";
    $stmtEmp = $conn->prepare($employeeQuery);
    $stmtEmp->execute();
    $employees = $stmtEmp->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forms</title>
    <link rel="shortcut icon" type="image/png" href="../../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../../assets/css/styles.min.css" />
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
              <a class="sidebar-link" href="./manager-dashboard.php" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="./manager-forms_check.php" aria-expanded="false">
                <span>
                  <i class="ti ti-file-description"></i>
                </span>
                <span class="hide-menu">Forms</span>
              </a>
            </li>
            
            <li class="sidebar-item">
              <a class="sidebar-link" href="./evaluated_list.php" aria-expanded="false">
                <span>
                  <i class="ti ti-article"></i>
                </span>
                <span class="hide-menu">Evaluated List</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="./manager-feedback.php" aria-expanded="false">
                <span>
                  <i class="ti ti-file-description"></i>
                </span>
                <span class="hide-menu">Feedback</span>
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
                    <a href="./manager-profile.php" class="d-flex align-items-center gap-2 dropdown-item">
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
            <div class="container-fluid">
                <div class="card">

                    <div class="container">
                        <h3>Select Employee for Appraisal</h3>
                        <form id="check_form" method="POST">
                            <!-- Department Dropdown -->
                            <div class="mb-3">
                                <label for="department" class="form-label">Select Department:</label>
                                <select class="form-select" id="department" name="department" required>
                                    <option value="">-- Select Department --</option>
                                    <?php
                                    foreach ($departments as $row) {
                                        echo '<option value="' . $row['dept_id'] . '">' . $row['dept_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Employee Dropdown -->
                            <div class="mb-3">
                                <label for="employee" class="form-label">Select Employee:</label>
                                <select class="form-select" id="employee" name="employee" required>
                                    <option value="">-- Select Employee --</option>
                                    <?php
                                    // ดึงข้อมูลพนักงานทั้งหมดพร้อมกับ dept_id
                                    $employeeQuery = "
                                     SELECT e_id, firstname, dept_id 
                                     FROM employees
                                    ";
                                    $stmtEmp = $conn->prepare($employeeQuery);
                                    $stmtEmp->execute();
                                    $employees = $stmtEmp->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($employees as $row) {
                                        // แสดงพนักงานทั้งหมดใน dropdown พร้อมแอตทริบิวต์ data-department
                                        echo '<option value="' . $row['e_id'] . '" data-department="' . $row['dept_id'] . '">' . $row['firstname'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Appraisal Category -->
                            <div class="mb-3">
                                <label for="category" class="form-label">Appraisal Category:</label>
                                <select class="form-select" id="topic" name="topic" required>
                                    <option value="">-- Select Category --</option>
                                    <option value="work">ประเมินพฤติกรรมการปฏิบัติงาน</option>
                                    <option value="personality">ประเมินพฤติกรรมของบุคคล</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="submit" value="Submit Feedback">
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/sidebarmenu.js"></script>
    <script src="../../assets/js/app.min.js"></script>
    <script src="../../assets/libs/simplebar/dist/simplebar.js"></script>

    <script>
        const departmentSelect = document.getElementById('department');
        const employeeSelect = document.getElementById('employee');

        // ฟังก์ชั่นกรองพนักงานตามแผนกที่เลือก
        departmentSelect.addEventListener('change', function() {
            const selectedDepartment = departmentSelect.value;

            // แสดงหรือซ่อนพนักงานตามแผนกที่เลือก
            for (let i = 0; i < employeeSelect.options.length; i++) {
                const option = employeeSelect.options[i];

                // ถ้าไม่มีแผนกที่เลือก หรือพนักงานอยู่ในแผนกที่ตรงกับแผนกที่เลือก
                if (option.getAttribute('data-department') === selectedDepartment || option.value === "") {
                    option.style.display = 'block'; // แสดงพนักงาน
                } else {
                    option.style.display = 'none'; // ซ่อนพนักงานที่ไม่ได้อยู่ในแผนก
                }
            }
        });
    </script>

</body>

</html>