<?php
include "../connection.php"; // ไฟล์นี้ควรประกอบไปด้วยการเชื่อมต่อฐานข้อมูลด้วย PDO
session_start();
$currentUserId = $_SESSION['currentUserId'];

// เช็คการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// จำนวนข้อมูลต่อหน้า
$limit = 7;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// ดึง dept_id ของผู้จัดการที่ล็อกอินเข้ามา
$managerDeptQuery = "SELECT dept_id FROM employees WHERE e_id = :currentUserId";
$deptStmt = $conn->prepare($managerDeptQuery);
$deptStmt->bindParam(':currentUserId', $currentUserId, PDO::PARAM_INT);
$deptStmt->execute();
$deptResult = $deptStmt->fetch(PDO::FETCH_ASSOC);
$currentDeptId = $deptResult['dept_id'];

// ดึงข้อมูลพนักงาน
// ดึงข้อมูลพนักงานที่อยู่ในแผนกเดียวกันกับผู้จัดการที่ล็อกอิน
$employeeQuery = "SELECT e.e_id, e.firstname, e.lastname, d.dept_name
                  FROM employees e
                  JOIN departments d ON e.dept_id = d.dept_id
                  WHERE e.dept_id = :currentDeptId
                  LIMIT :limit OFFSET :offset";

$sql = "SELECT 
        -- ค่าเฉลี่ยจาก form_topic1_info
        ROUND(AVG(t1.job_perform), 2) AS avg_job_performance, 
        ROUND(AVG(t1.quality_of_work), 2) AS avg_quality_of_work, 
        ROUND(AVG(t1.teamwork), 2) AS avg_teamwork, 
        ROUND(AVG(t1.adaptability_to_change), 2) AS avg_adaptability, 
        ROUND(AVG(t1.time_management), 2) AS avg_time_management, 
        ROUND(AVG(t1.creativity), 2) AS avg_creativity, 
        ROUND(AVG(t1.adherence_policies_regulations), 2) AS avg_policy_adherence,
        -- ค่าเฉลี่ยจาก form_topic2_info
        ROUND(AVG(t2.skills_knowledge), 2) AS avg_skills_knowledge,
        ROUND(AVG(t2.behavior_attiude), 2) AS avg_behavior_attitude,
        ROUND(AVG(t2.communication), 2) AS avg_communication,
        ROUND(AVG(t2.ability_work_un_press), 2) AS avg_ability_work_un_press,
        ROUND(AVG(t2.leadership), 2) AS avg_leadership,
        ROUND(AVG(t2.relationship), 2) AS avg_relationship,
        ROUND(AVG(t2.adaptability_learning), 2) AS avg_adaptability_learning
        FROM form_appraisal a 
        LEFT JOIN form_topic1_info t1 ON (t1.form_id = a.form_id)
        LEFT JOIN form_topic2_info t2 ON (t2.form_id = a.form_id)
        JOIN employees e ON (a.evaluatee_id = e.e_id)
        WHERE e.e_id = :currentUserId;";

// คิวรีเพื่อดึงข้อมูลค่าเฉลี่ย
$query1 = $conn->prepare($sql);
$query1->bindParam(':currentUserId', $currentUserId);
$query1->execute();
$averageResults = $query1->fetch(PDO::FETCH_ASSOC);

// คิวรีเพื่อดึงข้อมูลพนักงาน
$stmt = $conn->prepare($employeeQuery);
$stmt->bindParam(':currentDeptId', $currentDeptId, PDO::PARAM_INT); // ผูกค่า dept_id ของผู้จัดการ
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$employeeResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($employeeResults === false) {
    die("Error in SQL query: " . $conn->errorInfo()[2]);
}

// ดึงจำนวนข้อมูลทั้งหมด
$count_query = "SELECT COUNT(*) AS total FROM employees WHERE dept_id = :currentDeptId";
$count_stmt = $conn->prepare($count_query);
$count_stmt->bindParam(':currentDeptId', $currentDeptId, PDO::PARAM_INT);
$count_stmt->execute();
$count_row = $count_stmt->fetch(PDO::FETCH_ASSOC);
$total_rows = $count_row['total'];
$total_pages = ceil($total_rows / $limit);

// ค่าเฉลี่ยสำหรับกราฟแรก
$avgJobPerformance = $averageResults['avg_job_performance'] ?? 0;
$avgQualityOfWork = $averageResults['avg_quality_of_work'] ?? 0;
$avgTeamwork = $averageResults['avg_teamwork'] ?? 0;
$avgAdaptability = $averageResults['avg_adaptability'] ?? 0;
$avgTimeManagement = $averageResults['avg_time_management'] ?? 0;
$avgCreativity = $averageResults['avg_creativity'] ?? 0;
$avgPolicyAdherence = $averageResults['avg_policy_adherence'] ?? 0;

$result_score1 = $avgJobPerformance + $avgQualityOfWork + $avgTeamwork + $avgAdaptability + $avgTimeManagement + $avgCreativity + $avgPolicyAdherence;
if ($result_score1>=(80/100)*35){
  $grade1 = 'คะแนน = A โดดเด่น';
} else if($result_score1>=(60/100)*35){
  $grade1 = 'คะแนน = B สูงกว่าเป้าหมาย';
} else if($result_score1>=(40/100)*35){
  $grade1 = 'คะแนน = C ได้ตามเป้าหมาย';
} else if($result_score1>=(20/100)*35){
  $grade1 = 'คะแนน = D ต้องปรับปรุง';
} else {
  $grade1 = 'คะแนน = E ยอมรับไม่ได้';
};

// ค่าเฉลี่ยสำหรับกราฟที่สอง
$avgSkillsKnowledge = $averageResults['avg_skills_knowledge'] ?? 0;
$avgBehaviorAttitude = $averageResults['avg_behavior_attitude'] ?? 0;
$avgCommunication = $averageResults['avg_communication'] ?? 0;
$avgAbilityWorkUnderPress = $averageResults['avg_ability_work_un_press'] ?? 0;
$avgLeadership = $averageResults['avg_leadership'] ?? 0;
$avgRelationship = $averageResults['avg_relationship'] ?? 0;
$avgAdaptabilityLearning = $averageResults['avg_adaptability_learning'] ?? 0;

$result_score2 = $avgSkillsKnowledge + $avgBehaviorAttitude + $avgCommunication + $avgAbilityWorkUnderPress + $avgLeadership + $avgRelationship + $avgAdaptabilityLearning;
if ($result_score2>=(80/100)*35){
  $grade2 = 'คะแนน = A โดดเด่น';
} else if($result_score2>=(60/100)*35){
  $grade2 = 'คะแนน = B สูงกว่าเป้าหมาย';
} else if($result_score2>=(40/100)*35){
  $grade2 = 'คะแนน = C ได้ตามเป้าหมาย';
} else if($result_score2>=(20/100)*35){
  $grade2 = 'คะแนน = D ต้องปรับปรุง';
} else {
  $grade2 = 'คะแนน = E ยอมรับไม่ได้';
};
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
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
                  <i class="ti ti-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="./manager-forms_check.php" aria-expanded="false">
                <span>
                  <i class="ti ti-article"></i>
                </span>
                <span class="hide-menu">Forms</span>
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
            <li class="nav-item">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)" onclick="toggleNotificationBox()">
                <i class="ti ti-bell-ringing"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
            </li>
            <div id="notificationBox" class="box-root" style="display: none;">
              <div id="notificationContent">
              </div>
            </div>
            <script>
              function toggleNotificationBox() {
                var box = document.getElementById('notificationBox');
                box.style.display = (box.style.display === 'none') ? 'block' : 'none';

                // Fetch notifications from server when the box is displayed
                if (box.style.display === 'block') {
                  fetchNotifications();
                }
              }

              function fetchNotifications() {
                fetch('../get_notifications.php')
                  .then(response => response.json())
                  .then(data => {
                    var content = document.getElementById('notificationContent');
                    content.innerHTML = ''; // ล้างข้อมูลเดิมก่อน

                    if (data.notifications && data.notifications.length > 0) {
                      data.notifications.forEach(function (notification) {
                        var notificationElement = document.createElement('div');
                        notificationElement.classList.add('notification-item'); // เพิ่มคลาสสำหรับ CSS

                        // สร้างข้อความแสดงข้อมูล
                        var subject = document.createElement('h4');
                        subject.textContent = `Subject: ${notification.subjects}`; // แสดง subject
                        notificationElement.appendChild(subject);

                        var message = document.createElement('p');
                        message.textContent = `Message: ${notification.detail}`; // แสดง detail
                        notificationElement.appendChild(message);

                        var date = document.createElement('small');
                        date.textContent = `Date: ${notification.feedback_date}`; // แสดง feedback_date
                        notificationElement.appendChild(date);

                        content.appendChild(notificationElement);
                      });
                    } else {
                      content.innerHTML = '<p>No new notifications</p>';
                    }
                  })
                  .catch(error => {
                    console.error('Error fetching notifications:', error);
                    document.getElementById('notificationContent').innerHTML = '<p>Error loading notifications</p>';
                  });
              }
            </script>
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
          <div class="col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row alig n-items-start">
                      <div class="col-8">
                      <h5 class="card-title mb-9 fw-semibold">เกณฑ์คะแนน >=80% = A , >=60% = B , >=40% = C , >=20% = D , E</h5>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
          <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
              <div class="card-body">
                <!-- Chart 1 Overview -->
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Chart From 1 Overview <?php echo $grade1;?></h5>
                  </div>
                </div>
                <div class="container">
                  <h2>Employee Evaluation Overview - Chart 1</h2>
                  <canvas id="evaluationChart1" width="400" height="200"></canvas>
                </div>

                <!-- Chart 2 Overview -->
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9 mt-5">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Chart From 2 Overview <? echo $grade2;?></h5>
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
                        data: [<?php echo $avgJobPerformance; ?>, <?php echo $avgQualityOfWork; ?>, <?php echo $avgTeamwork; ?>, <?php echo $avgAdaptability; ?>, <?php echo $avgTimeManagement; ?>, <?php echo $avgCreativity; ?>, <?php echo $avgPolicyAdherence; ?>],
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
                        data: [<?php echo $avgSkillsKnowledge; ?>, <?php echo $avgBehaviorAttitude; ?>, <?php echo $avgCommunication; ?>, <?php echo $avgAbilityWorkUnderPress; ?>, <?php echo $avgLeadership; ?>, <?php echo $avgRelationship; ?>, <?php echo $avgAdaptabilityLearning; ?>],
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
                    <div class="d-flex flex-column align-items-start">
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(54, 162, 235, 0.5);"></span>
                        <span class="fs-3">Job Perform Score:
                          <span class="text-success">
                            <?= $avgJobPerformance ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(153, 102, 255, 0.5);"></span>
                        <span class="fs-3">Quality of Work Score:
                          <span class="text-success">
                            <?= $avgQualityOfWork ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(255, 159, 64, 0.5);"></span>
                        <span class="fs-3">Teamwork Score:
                          <span class="text-success">
                            <?= $avgTeamwork ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(54, 162, 235, 0.5);"></span>
                        <span class="fs-3">Adaptability to Change Score:
                          <span class="text-success">
                            <?= $avgAdaptability ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(255, 99, 132, 0.5);"></span>
                        <span class="fs-3">Time Management Score:
                          <span class="text-success">
                            <?= $avgTimeManagement ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(255, 206, 86, 0.5);"></span>
                        <span class="fs-3">Creativity Score:
                          <span class="text-success">
                            <?= $avgCreativity ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(54, 235, 162, 0.5);"></span>
                        <span class="fs-3">Adherence to Policies and Regulations Score:
                          <span class="text-success">
                            <?= $avgPolicyAdherence ?>
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
                    <h5 class="card-title mb-9 fw-semibold">Overview Summary Chart From 2</h5>
                    <div class="d-flex flex-column align-items-start">
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(75, 192, 192, 0.5);"></span>
                        <span class="fs-3">Skills & Knowledge Score:
                          <span class="text-success">
                            <?= $avgSkillsKnowledge ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(153, 102, 255, 0.5);"></span>
                        <span class="fs-3">Behavior & Attitude Score:
                          <span class="text-success">
                            <?= $avgBehaviorAttitude ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(255, 159, 64, 0.5);"></span>
                        <span class="fs-3">Communication Score:
                          <span class="text-success">
                            <?= $avgCommunication ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(54, 162, 235, 0.5);"></span>
                        <span class="fs-3">Ability to Work Under Pressure Score:
                          <span class="text-success">
                            <?= $avgAbilityWorkUnderPress ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(255, 99, 132, 0.5);"></span>
                        <span class="fs-3">Leadership Score:
                          <span class="text-success">
                            <?= $avgLeadership ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(255, 206, 86, 0.5);"></span>
                        <span class="fs-3">Relationship Score:
                          <span class="text-success">
                            <?= $avgRelationship ?>
                          </span>
                        </span>
                      </div>
                      <div class="mb-3">
                        <span class="round-8 rounded-circle me-2 d-inline-block"
                          style="background-color: rgba(54, 235, 162, 0.5);"></span>
                        <span class="fs-3">Adaptability to Learning Score:
                          <span class="text-success">
                            <?= $avgAdaptabilityLearning ?>
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
                        foreach ($employeeResults as $row) {
                            // ดึงค่าจริงจากฐานข้อมูลสำหรับ Total Evaluated
                            $total_evaluated_query = "SELECT COUNT(*) AS total_evaluated
                                                      FROM form_appraisal
                                                      WHERE evaluator_id = :e_id";
                            $evaluated_stmt = $conn->prepare($total_evaluated_query);
                            $evaluated_stmt->bindParam(':e_id', $row['e_id'], PDO::PARAM_STR);
                            $evaluated_stmt->execute();
                            $evaluated_result = $evaluated_stmt->fetch(PDO::FETCH_ASSOC);
                            $total_evaluated = $evaluated_result['total_evaluated'];

                            // ดึงค่าจริงจากฐานข้อมูลสำหรับ Total Approved
                            $total_approved_query = "SELECT COUNT(*) AS total_approved
                                                     FROM form_appraisal
                                                     WHERE evaluatee_id = :e_id";
                            $approved_stmt = $conn->prepare($total_approved_query);
                            $approved_stmt->bindParam(':e_id', $row['e_id'], PDO::PARAM_STR);
                            $approved_stmt->execute();
                            $approved_result = $approved_stmt->fetch(PDO::FETCH_ASSOC);
                            $total_approved = $approved_result['total_approved'];

                            // แสดงข้อมูลพนักงานในตาราง
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
                </div>
              </div>
            </div>
            <div>

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
  <style>
    .box-root {
      position: absolute;
      top: 50px;
      left: 0px;
      width: 300px;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    #notificationContent p {
      margin: 0;
      padding: 10px 0;
      border-bottom: 1px solid #ddd;
    }

    #notificationContent p:last-child {
      border-bottom: none;
    }

    .notification-item {
      margin-bottom: 10px;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      background-color: #f9f9f9;
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