<?php
    include "../connection.php";
    session_start();

    $currentUserId = $_SESSION['currentUserId'];
    
    $userSql = "SELECT firstname, lastname FROM employees WHERE e_id = :currentUserId";
    $userQuery = $conn->prepare($userSql);
    $userQuery->bindParam(':currentUserId', $currentUserId);
    $userQuery->execute();
    $user = $userQuery->fetch(PDO::FETCH_ASSOC);

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

    $query = $conn->prepare($sql);
    $query->bindParam(':currentUserId', $currentUserId);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // ค่าเฉลี่ยสำหรับกราฟแรก
    $avgJobPerformance = $result['avg_job_performance'] ?? 0;
    $avgQualityOfWork = $result['avg_quality_of_work'] ?? 0;
    $avgTeamwork = $result['avg_teamwork'] ?? 0;
    $avgAdaptability = $result['avg_adaptability'] ?? 0;
    $avgTimeManagement = $result['avg_time_management'] ?? 0;
    $avgCreativity = $result['avg_creativity'] ?? 0;
    $avgPolicyAdherence = $result['avg_policy_adherence'] ?? 0;

    // ค่าเฉลี่ยสำหรับกราฟที่สอง
    $avgSkillsKnowledge = $result['avg_skills_knowledge'] ?? 0;
    $avgBehaviorAttitude = $result['avg_behavior_attitude'] ?? 0;
    $avgCommunication = $result['avg_communication'] ?? 0;
    $avgAbilityWorkUnderPress = $result['avg_ability_work_un_press'] ?? 0;
    $avgLeadership = $result['avg_leadership'] ?? 0;
    $avgRelationship = $result['avg_relationship'] ?? 0;
    $avgAdaptabilityLearning = $result['avg_adaptability_learning'] ?? 0;

    // Calculate summation of avg scores for form 1
    $sumForm1 = $avgJobPerformance + $avgQualityOfWork + $avgTeamwork + $avgAdaptability + 
    $avgTimeManagement + $avgCreativity + $avgPolicyAdherence;
    $percentForm1 = round(($sumForm1 / 35) * 100, 2); // Assuming max score for each item is 5, and there are 7 items

    // Calculate summation of avg scores for form 2
    $sumForm2 = $avgSkillsKnowledge + $avgBehaviorAttitude + $avgCommunication + $avgAbilityWorkUnderPress + 
    $avgLeadership + $avgRelationship + $avgAdaptabilityLearning;
    $percentForm2 = round(($sumForm2 / 35) * 100, 2); // Assuming max score for each item is 5, and there are 7 items
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo ($user['firstname']);?>'s score</title>
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
              <a class="sidebar-link" href="./officer-dashboard.php" aria-expanded="false">
                <span>
                  <i class="ti ti-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="./officer-forms_check.php" aria-expanded="false">
                <span>
                  <i class="ti ti-article"></i>
                </span>
                <span class="hide-menu">Forms</span>
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
                      data.notifications.forEach(function(notification) {
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
                  <img src="../../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="./officer-profile.php" class="d-flex align-items-center gap-2 dropdown-item">
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
        <h3>คะแนนประเมินของ <b><?php echo ($user['firstname'].' '.$user['lastname']); ?></b> </h3>
        <!--  Row 1 -->
        <div class="row">
          <!-- Column for data 1 and  2 -->
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <!-- First box -->
                  <div class="col-md-6 mb-4">
                    <div class="d-flex flex-column h-100">
                      <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="round-48 d-flex align-items-center justify-content-center rounded bg-outline-light">
                          <div
                              class="text-white bg-primary rounded p-6 d-flex align-items-center justify-content-center">
                              <i class="ti ti-clipboard-data"></i>
                          </div>
                        </span>
                        <h5><b>คะแนน:</b> การประเมินด้านพฤติกรรมการปฏิบัติงาน</h5>
                      </div>
                      <div class="progress-container">
                        <h4 class="progress-percentage"><b><?php echo $percentForm1; ?>%</b> (<?php echo $sumForm1;?> คะแนน)</h4>
                      </div>
                    </div>
                  </div>
                  <!-- Second box -->
                  <div class="col-md-6 mb-4">
                    <div class="d-flex flex-column h-100">
                      <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="round-48 d-flex align-items-center justify-content-center rounded bg-outline-light">
                          <div class="text-white bg-primary rounded p-6 d-flex align-items-center justify-content-center">
                            <i class="ti ti-clipboard-data"></i>
                          </div>
                        </span>
                        <h5><b>คะแนน:</b> การประเมินด้านพฤติกรรมของบุคคล</h5>
                      </div>
                      <div class="progress-container">
                        <h4 class="progress-percentage"><b><?php echo $percentForm2; ?>%</b> (<?php echo $sumForm2;?> คะแนน)</h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- row 2-->
        <div class="card-group">
          <!-- forms 1 score-->
          <div class="card align-items-center" >
            <div class="card-body ">
              <div>
                <span class="fs-3" style="font-weight:bold;">Job Perform Score: 
                <span class="text-primary">
                  <?= $avgJobPerformance ?>
                </span>
              </div>

              <div>
                <span class="fs-3" style="font-weight:bold;">Quality of Work Score: 
                <span class="text-primary">
                  <?= $avgQualityOfWork ?>
                </span>
              </div>

              <div>
                <span class="fs-3" style="font-weight:bold;">Teamwork Score: 
                <span class="text-primary">
                  <?= $avgTeamwork ?>
                </span>
              </div>

              <div>
                <span class="fs-3" style="font-weight:bold;">Adaptability to Change Score: 
                <span class="text-primary">
                  <?= $avgAdaptability ?>
                </span>
              </div>

              <div>
                <span class="fs-3" style="font-weight:bold;">Time Management Score: 
                <span class="text-primary">
                  <?= $avgTimeManagement ?>
                </span>
              </div>

              <div>
                <span class="fs-3" style="font-weight:bold;">Creativity Score: 
                <span class="text-primary">
                  <?= $avgCreativity ?>
                </span>
              </div>

              <div>
                <span class="fs-3" style="font-weight:bold;">Adherence to Policies and Regulations Score: 
                <span class="text-primary">
                  <?= $avgPolicyAdherence ?>
                </span> 
              </div>

            </div>
          </div>

          <!-- forms 2 score-->
          <div class="card align-items-center">
            <div class="card-body">
            <div>
              <span class="fs-3" style="font-weight:bold;">Skills & Knowledge Score: 
              <span class="text-primary">
                <?= $avgSkillsKnowledge ?>
              </span>
            </div>

            <div>
              <span class="fs-3" style="font-weight:bold;">Behavior & Attitude Score: 
              <span class="text-primary">
                <?= $avgBehaviorAttitude ?>
              </span>
            </div>

            <div>
              <span class="fs-3" style="font-weight:bold;">Communication Score: 
              <span class="text-primary">
                <?= $avgCommunication ?>
              </span>
            </div>

            <div>
              <span class="fs-3" style="font-weight:bold;">Ability to Work Under Pressure Score: 
              <span class="text-primary">
                <?= $avgAbilityWorkUnderPress ?>
              </span>
            </div>

            <div>
              <span class="fs-3" style="font-weight:bold;">Leadership Score: 
              <span class="text-primary">
                <?= $avgLeadership ?>
              </span>
            </div>

            <div>
              <span class="fs-3" style="font-weight:bold;">Relationship Score:
              <span class="text-primary">
                <?= $avgRelationship ?>
              </span>
            </div>

            <div>
              <span class="fs-3" style="font-weight:bold;">Adaptability to Learning Score: 
              <span class="text-primary">
                <?= $avgAdaptabilityLearning ?>
              </span> 
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

  .progress-container {
    position: relative;
    margin-top: 10px;
  }
  .progress-percentage {
    position: absolute;
    top: -15px;
    right: 0;
    
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