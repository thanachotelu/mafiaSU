<?php
  include "../connection.php"; // ไฟล์นี้ควรประกอบไปด้วยการเชื่อมต่อฐานข้อมูลด้วย PDO

  // เช็คการเชื่อมต่อ
  if (!$conn) {
    die("Connection failed: " . pg_last_error());
  }

  // จำนวนข้อมูลต่อหน้า
  $limit = 7;
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($page - 1) * $limit;

  // ดึงข้อมูลพนักงาน
  $query = "SELECT e.e_id, e.firstname, e.lastname, d.dept_name
            FROM employees e
            JOIN departments d ON e.dept_id = d.dept_id
            LIMIT :limit OFFSET :offset";

  $stmt = $conn->prepare($query);
  $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
  $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if ($result === false) {
      die("Error in SQL query: " . $conn->errorInfo()[2]);
  }

  // ดึงจำนวนข้อมูลทั้งหมด
  $count_query = "SELECT COUNT(*) AS total FROM employees";
  $count_stmt = $conn->query($count_query);
  $count_row = $count_stmt->fetch(PDO::FETCH_ASSOC);
  $total_rows = $count_row['total'];
  $total_pages = ceil($total_rows / $limit);
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
  <script src="path/to/your/bootstrap.bundle.js"></script> <!-- เปลี่ยนเป็น path ของ Bootstrap JS -->

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
          <a href="./../index.html" class="text-nowrap logo-img">
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
              <a class="sidebar-link" href="./chief-forms.php" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
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
                  <img src="../../assets/images/profile/user-1.jpg" alt="" width="35" height="35"
                    class="rounded-circle">
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
        <div class="col-lg-12 d-flex align-items-stretch">
          <div class="card w-100">
            <div class="card-body">
              <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
                <div class="mb-3 mb-sm-0">
                  <h4 class="card-title fw-semibold">Employee evaluations</h4>
                  <p class="card-subtitle">Employee appraisals</p>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table align-middle text-nowrap mb-0">
                  <thead>
                    <tr class="text-muted fw-semibold">
                      <th scope="col">ID</th>
                      <th scope="col">Name</th>
                      <th scope="col">Department</th>
                      <th scope="col">Total Evaluated</th>
                      <th scope="col">Total Approved</th>
                    </tr>
                  </thead>
                  <tbody class="border-top">
                    <?php
                                // แสดงข้อมูลพนักงานที่ดึงมาจากฐานข้อมูล
                                foreach ($result as $row) {
                                    // สมมุติข้อมูล Total Evaluated และ Total Approved
                                    $total_evaluated = rand(1, 10); // สุ่มจำนวนที่ประเมิน
                                    $total_approved = rand(0, $total_evaluated); // สุ่มจำนวนที่ได้รับการอนุมัติ
                                    echo "<tr>
                                            <td>{$row['e_id']}</td>
                                            <td>{$row['firstname']} {$row['lastname']}</td>
                                            <td>{$row['dept_name']}</td>
                                            <td>$total_evaluated</td>
                                            <td>$total_approved</td>
                                          </tr>";
                                }
                                ?>
                  </tbody>
                </table>
              </div>

              <div class="pagination">
                <?php
                        // สร้างปุ่มสำหรับเปลี่ยนหน้า
                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo "<a href='?page=$i' class='page-link'>$i</a> ";
                        }
                        ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php
    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn = null;
    ?>

    </div>

    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
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