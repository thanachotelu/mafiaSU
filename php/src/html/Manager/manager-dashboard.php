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
              <a class="sidebar-link" href="./manager-forms.php" aria-expanded="false">
                <span>
                  <i class="ti ti-file-description"></i>
                </span>
                <span class="hide-menu">Forms</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="#" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Forms Editor</span>
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
      <!--  Header End -->
      <div class="container-fluid">
        <!--  Row 1 -->
        <div class="row">
          <!-- Column for Chart 1 and Chart 2 -->
          <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
              <div class="card-body">
                <!-- Chart 1 Overview -->
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Chart From 1 Overview</h5>
                  </div>
                </div>
                <div class="container">
                  <h2>Employee Evaluation Overview - Chart 1</h2>
                  <canvas id="evaluationChart1" width="400" height="200"></canvas>
                </div>

                <!-- Chart 2 Overview -->
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9 mt-5">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Chart From 2 Overview</h5>
                  </div>
                </div>
                <div class="container">
                  <h2>Employee Evaluation Overview - Chart 2</h2>
                  <canvas id="evaluationChart2" width="400" height="200"></canvas>
                </div>

                <!-- JavaScript for Chart 1 and Chart 2 -->
                <script>
                  // Chart 1
                  var ctx1 = document.getElementById('evaluationChart1').getContext('2d');
                  var evaluationChart1 = new Chart(ctx1, {
                    type: 'bar',
                    data: {
                      labels: ['Job Perform', 'Quality of Work', 'Teamwork', 'Adaptability to Change', 'Time Management', 'Creativity', 'Policy Adherence and Regulations'],
                      datasets: [{
                        label: 'Evaluation Scores - Chart 1',
                        data: [4, 3, 5, 4, 4, 5, 5], // ข้อมูลเป็นจำนวนเต็ม
                        backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(153, 102, 255, 0.5)', 'rgba(255, 159, 64, 0.5)', 'rgba(54, 235, 162, 0.5)'],
                        borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)', 'rgba(54, 235, 162, 1)'],
                        borderWidth: 1
                      }]
                    },
                    options: {
                      plugins: {
                        legend: {
                          display: true,
                          labels: {
                            color: 'black'
                          }
                        }
                      },
                      scales: {
                        x: {
                          ticks: {
                            display: false
                          }
                        },
                        y: {
                          beginAtZero: true,
                          max: 5 // แกน Y เป็น 5
                        }
                      }
                    }
                  });

                  // Chart 2
                  var ctx2 = document.getElementById('evaluationChart2').getContext('2d');
                  var evaluationChart2 = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                      labels: ['Skills & Knowledge', 'Behavior & Attitude', 'Communication', 'Ability to Work Under Pressure', 'Leadership', 'Relationship', 'Adaptability to Learning'],
                      datasets: [{
                        label: 'Evaluation Scores - Chart 2',
                        data: [4, 4, 5, 5, 4, 4, 5], // ข้อมูลเป็นจำนวนเต็ม
                        backgroundColor: ['rgba(75, 192, 192, 0.5)', 'rgba(153, 102, 255, 0.5)', 'rgba(255, 159, 64, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(54, 235, 162, 0.5)'],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(255, 206, 86, 1)', 'rgba(54, 235, 162, 1)'],
                        borderWidth: 1
                      }]
                    },
                    options: {
                      plugins: {
                        legend: {
                          display: true,
                          labels: {
                            color: 'black'
                          }
                        }
                      },
                      scales: {
                        x: {
                          ticks: {
                            display: false
                          }
                        },
                        y: {
                          beginAtZero: true,
                          max: 5 // แกน Y เป็น 5
                        }
                      }
                    }
                  });
                </script>
              </div>
            </div>
          </div>


          <!-- Column for Overview Summary -->
          <div class="col-lg-4">
            <div class="row">

              <!-- Overview Summary for Chart 1 -->
              <div class="col-lg-12">
                <div class="card overflow-hidden">
                  <div class="card-body p-4">
                    <h5 class="card-title mb-9 fw-semibold">Overview Summary Chart From 1</h5>

                    <?php 
                        // สมมุติข้อมูลขึ้นมา data: [4, 3, 5, 4, 4, 5, 5]
                        $eval1 = 4; // คะแนนประเมิน 1
                        $eval2 = 3; // คะแนนประเมิน 2
                        $eval3 = 5; // คะแนนประเมิน 3
                        $eval4 = 4; // คะแนนประเมิน 4
                        $eval5 = 4; // คะแนนประเมิน 5
                        $eval6 = 5; // คะแนนประเมิน 6
                        $eval7 = 5; // คะแนนประเมิน 7
                    ?>

                    <div class="d-flex flex-column align-items-start">
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(54, 162, 235, 0.5);"></span>
                        <span class="fs-3">Job Perform Score:
                          <span class="text-success">
                            <?= $eval1 ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(153, 102, 255, 0.5);"></span>
                        <span class="fs-3">Quality of Work Score:
                          <span class="text-success">
                            <?= $eval2 ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(255, 159, 64, 0.5);"></span>
                        <span class="fs-3">Teamwork Score:
                          <span class="text-success">
                            <?= $eval3 ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(54, 162, 235, 0.5);"></span>
                        <span class="fs-3">Adaptability to Change Score:
                          <span class="text-success">
                            <?= $eval4 ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(255, 99, 132, 0.5);"></span>
                        <span class="fs-3">Time Management Score:
                          <span class="text-success">
                            <?= $eval5 ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(255, 206, 86, 0.5);"></span>
                        <span class="fs-3">Creativity Score:
                          <span class="text-success">
                            <?= $eval6 ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(54, 235, 162, 0.5);"></span>
                        <span class="fs-3">Adherence to Policies and Regulations Score:
                          <span class="text-success">
                            <?= $eval7 ?>
                          </span>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Overview Summary for Chart 2 -->
              <div class="col-lg-12">
                <div class="card overflow-hidden">
                  <div class="card-body p-4">
                    <h5 class="card-title mb-9 fw-semibold">Overview Summary Chart From 1</h5>

                    <?php 
                        // สมมุติข้อมูลขึ้นมา data: [4, 4, 5, 5, 4, 4, 5], // ข้อมูลเป็นจำนวนเต็ม
                        $eval8 = 4; // คะแนนประเมิน 1
                        $eval9 = 4; // คะแนนประเมิน 2
                        $eval10 = 5; // คะแนนประเมิน 3
                        $eval11 = 5; // คะแนนประเมิน 4
                        $eval12 = 4; // คะแนนประเมิน 5
                        $eval13 = 4; // คะแนนประเมิน 6
                        $eval14 = 5; // คะแนนประเมิน 7
                    ?>

                    <div class="d-flex flex-column align-items-start">
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(75, 192, 192, 0.5);"></span>
                        <span class="fs-3">Skills & Knowledge Score:
                          <span class="text-success">
                            <?= $eval8 ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(153, 102, 255, 0.5);"></span>
                        <span class="fs-3">Behavior & Attitude Score:
                          <span class="text-success">
                            <?= $eval9 ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(255, 159, 64, 0.5);"></span>
                        <span class="fs-3">Communication Score:
                          <span class="text-success">
                            <?= $eval10 ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(54, 162, 235, 0.5);"></span>
                        <span class="fs-3">Ability to Work Under Pressure Score:
                          <span class="text-success">
                            <?= $eval11 ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(255, 99, 132, 0.5);"></span>
                        <span class="fs-3">Leadership Score:
                          <span class="text-success">
                            <?= $eval12 ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(255, 206, 86, 0.5);"></span>
                        <span class="fs-3">Relationship Score:
                          <span class="text-success">
                            <?= $eval13 ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(54, 235, 162, 0.5);"></span>
                        <span class="fs-3">Adaptability to Learning Score:
                          <span class="text-success">
                            <?= $eval14 ?>
                          </span>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Number of Employees -->
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row alig n-items-start">
                      <div class="col-8">
                        <h5 class="card-title mb-9 fw-semibold">Number of Employees</h5>
                        <?php 
                          //Query to get user count
                          $sql = "SELECT COUNT(*) as users FROM employees";
                          $query = $conn->prepare($sql);
                          $query->execute();
                          $fetch = $query->fetch(PDO::FETCH_ASSOC);                        
                        ?>
                        <h4 class="fw-semibold mb-3">
                          <?= $fetch['users']?>
                        </h4>
                      </div>
                      <div class="col-4">
                        <div class="d-flex justify-content-end">
                          <div
                            class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                            <i class="ti ti-user fs-6"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <!--  Row 2 -->
        <div class="row">
          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
                  <div class="mb-3 mb-sm-0">
                    <h4 class="card-title fw-semibold">Top Performers</h4>
                    <p class="card-subtitle">Best Employees</p>
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
      </div>

    </div>
  </div>
  <script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/sidebarmenu.js"></script>
  <script src="../../assets/js/app.min.js"></script>
  <script src="../../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../../assets/js/dashboard.js"></script>
</body>

</html>