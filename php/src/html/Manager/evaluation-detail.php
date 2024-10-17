<?php
include '../connection.php';

// ตรวจสอบว่ามีการส่ง form_id มาหรือไม่
if (isset($_GET['form_id']) && isset($_GET['topic_id']) && isset($_GET['e_id'])) {
    $form_id = $_GET['form_id'];
    $topic_id = $_GET['topic_id'];
    $e_id = $_GET['e_id'];
}else {
    echo "Invalid access.";
    exit();
    }

    // ดึงรายละเอียดของแบบฟอร์มการประเมิน
    $query = "SELECT job_perform, quality_of_work, teamwork, adaptability_to_change, time_management, creativity, adherence_policies_regulations
              FROM form_topic1_info WHERE form_id = :form_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':form_id', $form_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $job_perform = $result['job_perform'] ?? null;
    $quality_of_work = $result['quality_of_work'] ?? null;
    $teamwork = $result['teamwork'] ?? null;
    $adaptability_to_change = $result['adaptability_to_change'] ?? null;
    $time_management = $result['time_management'] ?? null;
    $creativity = $result['creativity'] ?? null;
    $adherence_policies_regulations = $result['adherence_policies_regulations'] ?? null;

    if ($topic_id == 1) {
        $query = "SELECT job_perform, quality_of_work, teamwork, adaptability_to_change, time_management, creativity, adherence_policies_regulations 
                  FROM form_topic1_info WHERE form_id = :form_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->execute();
        $form_data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $job_perform = $result['job_perform'] ?? null;
        $quality_of_work = $result['quality_of_work'] ?? null;
        $teamwork = $result['teamwork'] ?? null;
        $adaptability_to_change = $result['adaptability_to_change'] ?? null;
        $time_management = $result['time_management'] ?? null;
        $creativity = $result['creativity'] ?? null;
        $adherence_policies_regulations = $result['adherence_policies_regulations'] ?? null;
        
        ?>
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



                <div class="container-fluid" >
                    <div class="container-fluid">
                    <div class="card">
                        <form >
                        <div class="card-body" >
                        <h5 class="card-title fw-semibold mb-4">ประเมินพฤติกรรมการปฏิบัติงาน</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                <div class="mb-3"> 
                                    <label class="form-label">ความรู้และทักษะในการทำงาน</label>  
                                    <p>- ความเข้าใจในหน้าที่การงาน ความเชี่ยวชาญ และระดับทักษะ </p>
                                </div>

                                <div class="mb-3">
                                    <div class="d-inline mx-3"> แย่มาก </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question1" id="inlineRadio1"
                                        value="1" <?php if($job_perform == 1) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question1" id="inlineRadio2"
                                        value="2" <?php if($job_perform == 2) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question1" id="inlineRadio3"
                                        value="3" <?php if($job_perform == 3) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio3">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question1" id="inlineRadio4"
                                        value="4" <?php if($job_perform == 4) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio4">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question1" id="inlineRadio5"
                                        value="5" <?php if($job_perform == 5) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio5">5</label>
                                    </div>
                                    <div class="d-inline mx-3"> ดีมาก </div>
                                </div>
                                </div>

                                <div class="mb-3">
                                <div class="mb-3"> 
                                    <label class="form-label">คุณภาพของงาน</label>  
                                    <p>- ความแม่นยำ ความใส่ใจในรายละเอียด และคุณภาพโดยรวมของงานที่เสร็จสมบูรณ์ </p>
                                </div>

                                <div class="mb-3">
                                    <div class="d-inline mx-3"> แย่มาก </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question2" id="inlineRadio1"
                                        value="1" <?php if($quality_of_work == 1) echo 'checked'; ?> disabled  />
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question2" id="inlineRadio2"
                                        value="2" <?php if($quality_of_work == 2) echo 'checked'; ?> disabled  />
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question2" id="inlineRadio3"
                                        value="3" <?php if($quality_of_work == 3) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio3">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question2" id="inlineRadio4"
                                        value="4" <?php if($quality_of_work == 4) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio4">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question2" id="inlineRadio5"
                                        value="5" <?php if($quality_of_work == 5) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio5">5</label>
                                    </div>
                                    <div class="d-inline mx-3"> ดีมาก </div>
                                </div>
                                </div>

                                <div class="mb-3">
                                <div class="mb-3"> 
                                    <label class="form-label">การทำงานเป็นทีมและการทำงานร่วมกัน</label>  
                                    <p>- ความเต็มใจที่จะร่วมมือและทำงานร่วมกับผู้อื่นได้ดี </p>
                                </div>

                                <div class="mb-3">
                                    <div class="d-inline mx-3"> แย่มาก </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question3" id="inlineRadio1"
                                        value="1" <?php if($teamwork == 1) echo 'checked'; ?> disabled  />
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question3" id="inlineRadio2"
                                        value="2" <?php if($teamwork == 2) echo 'checked'; ?> disabled  />
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question3" id="inlineRadio3"
                                        value="3" <?php if($teamwork == 3) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio3">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question3" id="inlineRadio4"
                                        value="4" <?php if($teamwork == 4) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio4">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question3" id="inlineRadio5"
                                        value="5" <?php if($teamwork == 5) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio5">5</label>
                                    </div>
                                    <div class="d-inline mx-3"> ดีมาก </div>
                                </div>
                                </div>

                                <div class="mb-3">
                                <div class="mb-3"> 
                                    <label class="form-label">ความสามารถในการปรับตัว</label>  
                                    <p>- ความสามารถในการปรับตัวให้เข้ากับสถานการณ์ใหม่ ความท้าทาย หรือการเปลี่ยนแปลงในที่ทำงาน </p>
                                </div>

                                <div class="mb-3">
                                    <div class="d-inline mx-3"> แย่มาก </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question4" id="inlineRadio1"
                                        value="1" <?php if($adaptability_to_change == 1) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question4" id="inlineRadio2"
                                        value="2" <?php if($adaptability_to_change == 2) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question4" id="inlineRadio3"
                                        value="3" <?php if($adaptability_to_change == 3) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio3">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question4" id="inlineRadio4"
                                        value="4" <?php if($adaptability_to_change == 4) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio4">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question4" id="inlineRadio5"
                                        value="5" <?php if($adaptability_to_change == 5) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio5">5</label>
                                    </div>
                                    <div class="d-inline mx-3"> ดีมาก </div>
                                </div>
                                </div>

                                <div class="mb-3">
                                <div class="mb-3"> 
                                    <label class="form-label">การจัดการเวลา</label>  
                                    <p>- ความสามารถในการจัดการเวลาที่มีจำกัด การวางแผนและการจัดระเบียบงาน</p>
                                </div>

                                <div class="mb-3">
                                    <div class="d-inline mx-3"> แย่มาก </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question5" id="inlineRadio1"
                                        value="1" <?php if($time_management == 1) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question5" id="inlineRadio2"
                                        value="2" <?php if($time_management == 2) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question5" id="inlineRadio3"
                                        value="3" <?php if($time_management == 3) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio3">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question5" id="inlineRadio4"
                                        value="4" <?php if($time_management == 4) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio4">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question5" id="inlineRadio5"
                                        value="5" <?php if($time_management == 5) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio5">5</label>
                                    </div>
                                    <div class="d-inline mx-3"> ดีมาก </div>
                                </div>
                                </div>

                                <div class="mb-3">
                                <div class="mb-3"> 
                                    <label class="form-label">ความคิดสร้างสรรค์และนวัตกรรม</label>  
                                    <p>- ความสามารถในการคิดนอกกรอบ คิดค้นไอเดียใหม่ๆ และนำเสนอแนวทางแก้ไขปัญหาที่สร้างสรรค์ ซึ่งรวมถึงความเปิดกว้างต่อการทดลองและความเต็มใจที่จะรับความเสี่ยงที่คำนวณมาแล้วเพื่อปรับปรุงกระบวนการหรือผลิตภัณฑ์ </p>
                                </div>

                                <div class="mb-3">
                                    <div class="d-inline mx-3"> แย่มาก </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question6" id="inlineRadio1"
                                        value="1" <?php if($creativity == 1) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question6" id="inlineRadio2"
                                        value="2" <?php if($creativity == 2) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question6" id="inlineRadio3"
                                        value="3" <?php if($creativity == 3) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio3">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question6" id="inlineRadio4"
                                        value="4" <?php if($creativity == 4) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio4">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question6" id="inlineRadio5"
                                        value="5" <?php if($creativity == 5) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio5">5</label>
                                    </div>
                                    <div class="d-inline mx-3"> ดีมาก </div>
                                </div>
                                </div>

                                <div class="mb-3">
                                <div class="mb-3"> 
                                    <label class="form-label">การปฏิบัติตามนโยบายและระเบียบข้อบังคับ</label>  
                                    <p>- ความมุ่งมั่นที่จะปฏิบัติตามนโยบาย ขั้นตอน และระเบียบข้อบังคับของอุตสาหกรรมของบริษัท ซึ่งรวมถึงความเข้าใจและการนำแนวทางด้านความปลอดภัย มาตรฐานจริยธรรม และข้อกำหนดการปฏิบัติตามมาใช้เพื่อให้แน่ใจว่าสภาพแวดล้อมการทำงานมีความปลอดภัยและมีประสิทธิผล </p>
                                </div>

                                <div class="mb-3">
                                    <div class="d-inline mx-3"> แย่มาก </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question7" id="inlineRadio1"
                                        value="1" <?php if($adherence_policies_regulations == 1) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question7" id="inlineRadio2"
                                        value="2" <?php if($adherence_policies_regulations == 2) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question7" id="inlineRadio3"
                                        value="3" <?php if($adherence_policies_regulations == 3) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio3">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question7" id="inlineRadio4"
                                        value="4" <?php if($adherence_policies_regulations == 4) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio4">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question7" id="inlineRadio5"
                                        value="5" <?php if($adherence_policies_regulations == 5) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio5">5</label>
                                    </div>
                                    <div class="d-inline mx-3"> ดีมาก </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <a href='evaluation-details.php?e_id=<?php echo $e_id;?>' class='btn btn-info btn'>ย้อนกลับ</a>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
                </div>
            </div>
<?php
    
    }elseif ($topic_id == 2) {
        $query = "SELECT skills_knowledge, behavior_attiude, communication, ability_work_un_press, leadership, relationship, adaptability_learning 
                  FROM form_topic2_info WHERE form_id = :form_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':form_id', $form_id, PDO::PARAM_INT);
        $stmt->execute();
        $form_data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $skills_knowledge = $form_data['skills_knowledge'] ?? null;
        $behavior_attiude = $form_data['behavior_attiude'] ?? null;
        $communication = $form_data['communication'] ?? null;
        $ability_work_un_press = $form_data['ability_work_un_press'] ?? null;
        $leadership = $form_data['leadership'] ?? null;
        $relationship = $form_data['relationship'] ?? null;
        $adaptability_learning = $form_data['adaptability_learning'] ?? null;
        
        ?>
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



                <div class="container-fluid" >
                    <div class="container-fluid">
                    <div class="card">
                        <form >
                        <div class="card-body" >
                        <h5 class="card-title fw-semibold mb-4">ประเมินพฤติกรรมของบุคคล</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                <div class="mb-3"> 
                                    <label class="form-label">ทักษะและความรู้</label>  
                                    <p>- ระดับความเชี่ยวชาญของพนักงานในบทบาทเฉพาะของตน รวมทั้งความสามารถทางเทคนิคและความเข้าใจในงานที่จำเป็น นอกจากนี้ยังประเมินว่าพนักงานสามารถอัปเดตข้อมูลเกี่ยวกับแนวโน้มของอุตสาหกรรมและนำความรู้ใหม่ไปใช้กับงานได้ดีเพียงใด</p>
                                </div>

                                <div class="mb-3">
                                    <div class="d-inline mx-3"> แย่มาก </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question1" id="inlineRadio1"
                                        value="1" <?php if($skills_knowledge == 1) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question1" id="inlineRadio2"
                                        value="2" <?php if($skills_knowledge == 2) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question1" id="inlineRadio3"
                                        value="3" <?php if($skills_knowledge == 3) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio3">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question1" id="inlineRadio4"
                                        value="4" <?php if($skills_knowledge == 4) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio4">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question1" id="inlineRadio5"
                                        value="5" <?php if($skills_knowledge == 5) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio5">5</label>
                                    </div>
                                    <div class="d-inline mx-3"> ดีมาก </div>
                                </div>
                                </div>

                                <div class="mb-3">
                                <div class="mb-3"> 
                                    <label class="form-label">พฤติกรรมและทัศนคติ</label>  
                                    <p>- กิริยามารยาทโดยรวม ความเป็นมืออาชีพ และทัศนคติของพนักงานที่มีต่องาน เพื่อนร่วมงานและหัวหน้างาน ซึ่งรวมถึงความเป็นบวก จริยธรรมในการทำงาน ความเคารพผู้อื่น และแนวทางในการรับมือกับความท้าทายหรือข้อเสนอแนะ </p>
                                </div>

                                <div class="mb-3">
                                    <div class="d-inline mx-3"> แย่มาก </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question2" id="inlineRadio1"
                                        value="1" <?php if($behavior_attiude == 1) echo 'checked'; ?> disabled  />
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question2" id="inlineRadio2"
                                        value="2" <?php if($behavior_attiude == 2) echo 'checked'; ?> disabled  />
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question2" id="inlineRadio3"
                                        value="3" <?php if($behavior_attiude == 3) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio3">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question2" id="inlineRadio4"
                                        value="4" <?php if($behavior_attiude == 4) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio4">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question2" id="inlineRadio5"
                                        value="5" <?php if($behavior_attiude == 5) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio5">5</label>
                                    </div>
                                    <div class="d-inline mx-3"> ดีมาก </div>
                                </div>
                                </div>

                                <div class="mb-3">
                                <div class="mb-3"> 
                                    <label class="form-label">ความสามารถในการสื่อสาร</label>  
                                    <p>- ความสามารถในการถ่ายทอดข้อมูลอย่างชัดเจนและมีประสิทธิภาพ ทั้งด้วยวาจาและลายลักษณ์อักษร ซึ่งรวมถึงการฟังอย่างตั้งใจ ความสามารถในการให้ข้อเสนอแนะเชิงสร้างสรรค์ และความสามารถของพนักงานในการสื่อสารภายในทีมหรือกับลูกค้า </p>
                                </div>

                                <div class="mb-3">
                                    <div class="d-inline mx-3"> แย่มาก </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question3" id="inlineRadio1"
                                        value="1" <?php if($communication == 1) echo 'checked'; ?> disabled  />
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question3" id="inlineRadio2"
                                        value="2" <?php if($communication == 2) echo 'checked'; ?> disabled  />
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question3" id="inlineRadio3"
                                        value="3" <?php if($communication == 3) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio3">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question3" id="inlineRadio4"
                                        value="4" <?php if($communication == 4) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio4">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question3" id="inlineRadio5"
                                        value="5" <?php if($communication == 5) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio5">5</label>
                                    </div>
                                    <div class="d-inline mx-3"> ดีมาก </div>
                                </div>
                                </div>

                                <div class="mb-3">
                                <div class="mb-3"> 
                                    <label class="form-label">ความสามารถในการทำงานภายใต้ความกดดัน</label>  
                                    <p>- ความสามารถของพนักงานในการสงบสติอารมณ์ มีสมาธิ และมีประสิทธิภาพเมื่อเผชิญกับสถานการณ์ที่กดดัน กำหนดเวลาที่กระชั้นชิด หรือความท้าทายที่ไม่คาดคิด นอกจากนี้ยังพิจารณาถึงวิธีการจัดการปริมาณงานโดยไม่เสียสละคุณภาพ </p>
                                </div>

                                <div class="mb-3">
                                    <div class="d-inline mx-3"> แย่มาก </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question4" id="inlineRadio1"
                                        value="1" <?php if($ability_work_un_press == 1) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question4" id="inlineRadio2"
                                        value="2" <?php if($ability_work_un_press == 2) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question4" id="inlineRadio3"
                                        value="3" <?php if($ability_work_un_press == 3) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio3">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question4" id="inlineRadio4"
                                        value="4" <?php if($ability_work_un_press == 4) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio4">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question4" id="inlineRadio5"
                                        value="5" <?php if($ability_work_un_press == 5) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio5">5</label>
                                    </div>
                                    <div class="d-inline mx-3"> ดีมาก </div>
                                </div>
                                </div>

                                <div class="mb-3">
                                <div class="mb-3"> 
                                    <label class="form-label">ความเป็นผู้นำ</label>  
                                    <p>- ความสามารถในการสร้างแรงบันดาลใจ ชี้นำ และให้คำปรึกษาแก่ผู้อื่น ความเป็นผู้นำรวมถึงการตัดสินใจ ความรับผิดชอบ การมอบหมายงานอย่างมีประสิทธิผล และการส่งเสริมสภาพแวดล้อมการทำงานเชิงบวก แม้ว่าพนักงานจะไม่ได้อยู่ในตำแหน่งผู้นำอย่างเป็นทางการก็ตาม</p>
                                </div>

                                <div class="mb-3">
                                    <div class="d-inline mx-3"> แย่มาก </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question5" id="inlineRadio1"
                                        value="1" <?php if($leadership == 1) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question5" id="inlineRadio2"
                                        value="2" <?php if($leadership == 2) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question5" id="inlineRadio3"
                                        value="3" <?php if($leadership == 3) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio3">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question5" id="inlineRadio4"
                                        value="4" <?php if($leadership == 4) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio4">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question5" id="inlineRadio5"
                                        value="5" <?php if($leadership == 5) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio5">5</label>
                                    </div>
                                    <div class="d-inline mx-3"> ดีมาก </div>
                                </div>
                                </div>

                                <div class="mb-3">
                                <div class="mb-3"> 
                                    <label class="form-label">การสร้างความสัมพันธ์</label>  
                                    <p>- ความสามารถในการสร้างและรักษาความสัมพันธ์ในการทำงานเชิงบวกกับเพื่อนร่วมงาน ลูกค้า และหัวหน้างาน ซึ่งรวมถึงการทำงานเป็นทีม การทำงานร่วมกัน การแก้ไขข้อขัดแย้ง และความสามารถในการมีส่วนสนับสนุนต่อวัฒนธรรมที่ทำงานที่ดี </p>
                                </div>

                                <div class="mb-3">
                                    <div class="d-inline mx-3"> แย่มาก </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question6" id="inlineRadio1"
                                        value="1" <?php if($relationship == 1) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question6" id="inlineRadio2"
                                        value="2" <?php if($relationship == 2) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question6" id="inlineRadio3"
                                        value="3" <?php if($relationship == 3) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio3">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question6" id="inlineRadio4"
                                        value="4" <?php if($relationship == 4) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio4">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question6" id="inlineRadio5"
                                        value="5" <?php if($relationship == 5) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio5">5</label>
                                    </div>
                                    <div class="d-inline mx-3"> ดีมาก </div>
                                </div>
                                </div>

                                <div class="mb-3">
                                <div class="mb-3"> 
                                    <label class="form-label">ความสามารถในการปรับตัวและการเรียนรู้</label>  
                                    <p>- ความสามารถของพนักงานในการปรับตัวเข้ากับงานใหม่ บทบาทใหม่ หรือสภาพแวดล้อมการทำงานที่เปลี่ยนแปลงไป นอกจากนี้ยังรวมถึงความเต็มใจที่จะเรียนรู้ เติบโตในอาชีพ และนำเครื่องมือหรือวิธีการใหม่ ๆ มาใช้เพื่อปรับปรุงประสิทธิภาพการทำงาน </p>
                                </div>

                                <div class="mb-3">
                                    <div class="d-inline mx-3"> แย่มาก </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question7" id="inlineRadio1"
                                        value="1" <?php if($adaptability_learning == 1) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question7" id="inlineRadio2"
                                        value="2" <?php if($adaptability_learning == 2) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question7" id="inlineRadio3"
                                        value="3" <?php if($adaptability_learning == 3) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio3">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question7" id="inlineRadio4"
                                        value="4" <?php if($adaptability_learning == 4) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio4">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="question7" id="inlineRadio5"
                                        value="5" <?php if($adaptability_learning == 5) echo 'checked'; ?> disabled />
                                    <label class="form-check-label" for="inlineRadio5">5</label>
                                    </div>
                                    <div class="d-inline mx-3"> ดีมาก </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <a href='evaluation-details.php?e_id=<?php echo $e_id;?>' class='btn btn-info btn'>ย้อนกลับ</a>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
                </div>
            </div>
<?php

    } else {
        echo "Invalid topic ID.";
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
  <?php
    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn = null;
    ?>
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