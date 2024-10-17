<?php
include '../connection.php';

if (isset($_GET['e_id'])) {
    $e_id = $_GET['e_id'];

    $evaluator_query = "SELECT firstname, lastname FROM employees WHERE e_id = :e_id";
    $evaluator_stmt = $conn->prepare($evaluator_query);
    $evaluator_stmt->bindParam(':e_id', $e_id, PDO::PARAM_STR);
    $evaluator_stmt->execute();
    $evaluator = $evaluator_stmt->fetch(PDO::FETCH_ASSOC);

    if ($evaluator) {
        $evaluator_name = $evaluator['firstname'] . " " . $evaluator['lastname'];
    } else {
        $evaluator_name = "Unknown Evaluator";
    }

    $evaluation_query = "SELECT f.*, e.firstname, e.lastname
                         FROM form_appraisal_hist f
                         JOIN employees e ON f.evaluatee_id = e.e_id
                         WHERE f.evaluator_id = :e_id";
    $stmt = $conn->prepare($evaluation_query);
    $stmt->bindParam(':e_id', $e_id, PDO::PARAM_STR);
    $stmt->execute();
    $evaluations = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {
  echo "Invalid access.";
  exit();
}
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
        <div class="col-lg-12 d-flex align-items-stretch">
          <div class="card w-100">
            <div class="card-body">
              <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
              </div>
              <div class="table-responsive">
                <table class="table align-middle text-nowrap mb-0">
                  <tbody class="border-top">
                    <?php
                        if ($evaluations) {
                          echo "<h2>Evaluation Details for Employee ID: <b>$e_id $evaluator_name</b> </h2>";
                          echo "<table class='table'>
                                  <thead>
                                    <tr>
                                      <th>Form ID</th>
                                      <th>Evaluatee Name</th>
                                      <th>Evaluation Date</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>";
                  
                          foreach ($evaluations as $evaluation) {
                              $evaluatee_name = $evaluation['firstname'] . " " . $evaluation['lastname'];
                              echo "<tr>
                                      <td>{$evaluation['form_id']}</td>
                                      <td>$evaluatee_name</td>
                                      <td>{$evaluation['form_date']}</td>
                                      <td>
                                        <a href='evaluation-detail.php?form_id={$evaluation['form_id']}&topic_id={$evaluation['topic_id']}&e_id=$e_id' class='btn btn-info btn-sm'>View Form</a>
                                      </td>
                                    </tr>";
                          }
                          echo "</tbody></table>";
                          echo "<div class='mt-3'>
                                  <a href='evaluated_list.php' class='btn btn-info btn'>ย้อนกลับ</a>
                                </div>";
                      } else {
                          echo "<p>No evaluations found for this employee.</p>";
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div>
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

</html>