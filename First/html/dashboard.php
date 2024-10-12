<?php
    include "connection.php";
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MAFIA APPRAISAL</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/appraisal.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
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
          <a href="./index.html" class="text-nowrap logo-img">
            <img src="../assets/images/logos/appraisal.png" width="150" alt="" />
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
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./dashboard.php" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="./ui-forms.php" aria-expanded="false">
                <span>
                  <i class="ti ti-file-description"></i>
                </span>
                <span class="hide-menu">Forms</span>
              </a>
            </li>

            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">AUTH</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./authentication-login.php" aria-expanded="false">
                <span>
                  <i class="ti ti-login"></i>
                </span>
                <span class="hide-menu">Login</span>
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
                  <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">My Account</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <p class="mb-0 fs-3">My Task</p>
                    </a>
                    <a href="./authentication-login.html" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
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
          <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
              <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Chart Overview</h5>
                  </div>
                </div>

                <div class="container">
                  <h2>Employee Evaluation Overview</h2>
                  <!-- พื้นที่แสดงกราฟ -->
                  <canvas id="evaluationChart" width="400" height="200"></canvas>
                </div>

                <!-- โค้ด JavaScript สำหรับการสร้างกราฟ -->
                <script>
                  var ctx = document.getElementById('evaluationChart').getContext('2d');
                  var evaluationChart = new Chart(ctx, {
                    type: 'bar', // ชนิดของกราฟ bar
                    data: {
                      labels: [
                        'Technical Skills',
                        'Communication',
                        'Problem Solving',
                        'Teamwork',
                        'Leadership',
                        'Time Management', // หัวข้อการประเมินที่ 6
                        'Creativity' // หัวข้อการประเมินที่ 7
                      ], // ป้ายกำกับแต่ละแท่ง (หัวข้อการประเมิน)
                      datasets: [
                        {
                          label: 'Evaluation Scores', // คำอธิบายกราฟ
                          data: [85, 70, 95, 80, 88, 90, 92], // คะแนนของพนักงานคนเดียวตามหัวข้อการประเมิน
                          backgroundColor: [
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)', // สีของหัวข้อ Time Management
                            'rgba(54, 235, 162, 0.2)' // สีของหัวข้อ Creativity
                          ], // สีของแต่ละแท่งกราฟ
                          borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)', // สีขอบของหัวข้อ Time Management
                            'rgba(54, 235, 162, 1)' // สีขอบของหัวข้อ Creativity
                          ], // สีขอบของแต่ละแท่งกราฟ
                          borderWidth: 1
                        }
                      ]
                    },
                    options: {
                      plugins: {
                        legend: {
                          display: true, // กำหนดให้แสดงผล legend
                          labels: {
                            color: 'black' // เปลี่ยนสีข้อความใน legend เป็นสีแดง
                          }
                        }
                      },
                      scales: {
                        x: {
                          ticks: {
                            display: false // ปิดการแสดงผลของ ticks (labels) ที่อยู่ใต้กราฟ
                          }
                        },
                        y: {
                          beginAtZero: true, // เริ่มแกน Y จาก 0
                          max: 100 // กำหนดค่าสูงสุดของแกน Y เป็น 100
                        }
                      }
                    }
                  });
                </script>

              </div>
            </div>
          </div>


          <div class="col-lg-4">
            <div class="row">
              <!-- Overview Summary Chart -->
              <div class="col-lg-12">
                <div class="card overflow-hidden">
                  <div class="card-body p-4">
                    <h5 class="card-title mb-9 fw-semibold">Overview Summary Chart</h5>
                    <div class="row">
                      <div class="col-12">

                        <?php 
                        // สมมุติข้อมูลขึ้นมา
                        $eval1 = 85; // คะแนนประเมิน 1
                        $eval2 = 78; // คะแนนประเมิน 2
                        $eval3 = 92; // คะแนนประเมิน 3
                        ?>

                        <h4 class="fw-semibold mb-3">Total Employees Evaluated: 150</h4>
                        <p class="text-dark fs-3 mb-3">Average Score: 85.6</p>

                        <!-- จัดเรียงข้อมูลเป็นแนวตั้ง -->
                        <div class="d-flex flex-column align-items-start">
                          <div class="mb-3">
                            <span class="round-8 bg-success rounded-circle me-2 d-inline-block"></span>
                            <span class="fs-3">Evaluation 1 Score: <span class="text-success">
                                <?= $eval1 ?>
                              </span></span>
                          </div>
                          <div class="mb-3">
                            <span class="round-8 bg-warning rounded-circle me-2 d-inline-block"></span>
                            <span class="fs-3">Evaluation 2 Score: <span class="text-warning">
                                <?= $eval2 ?>
                              </span></span>
                          </div>
                          <div>
                            <span class="round-8 bg-danger rounded-circle me-2 d-inline-block"></span>
                            <span class="fs-3">Evaluation 3 Score: <span class="text-danger">
                                <?= $eval3 ?>
                              </span></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 mt-4">
                        <div class="d-flex justify-content-center">
                          <div id="evaluation_chart"></div> <!-- สมมุติว่ามีกราฟที่แสดงสถิติ -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12">
              <!-- Monthly Earnings -->
              <div class="card">
                <div class="card-body">
                  <div class="row alig n-items-start">
                    <div class="col-8">
                      <h5 class="card-title mb-9 fw-semibold"> Number of Employees </h5>

                      <?php 
                            // Query to get user count
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
                          <!-- Change the icon to something more relevant to employees -->
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
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
</body>

</html>