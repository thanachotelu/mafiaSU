<?php
    include "connection.php";
    session_start();

    if (isset($_SESSION['user_position'])) {
        $user_position = $_SESSION['user_position'];
    } else {
        echo "User position is not set.";
        exit();
    }

    try {
        $conn = new PDO("pgsql:host={$servername};port={$port};dbname={$dbname}", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }

    if (isset($_GET['form_id']) && isset($_GET['topic_id'])) {
        $form_id = $_GET['form_id'];
        $topic_id = $_GET['topic_id'];
    } else {
        echo "Invalid access.";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $question1 = $_POST['question1'];
        $question2 = $_POST['question2'];
        $question3 = $_POST['question3'];
        $question4 = $_POST['question4'];
        $question5 = $_POST['question5'];
        $question6 = $_POST['question6'];
        $question7 = $_POST['question7'];

        try {
            // สร้างคำสั่ง SQL เพื่อบันทึกข้อมูล โดยใช้ PDO prepared statement
            $sql = "INSERT INTO form_topic1_info (form_id, topic_id, job_perform, quality_of_work, teamwork, adaptability_to_change, time_management, creativity, adherence_policies_regulations)
                    VALUES (:form_id, :topic_id, :question1, :question2, :question3, :question4, :question5, :question6, :question7)";

            // เตรียมคำสั่ง SQL
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':form_id' => $form_id,
                ':topic_id' => $topic_id,
                ':question1' => $question1,
                ':question2' => $question2,
                ':question3' => $question3,
                ':question4' => $question4,
                ':question5' => $question5,
                ':question6' => $question6,
                ':question7' => $question7
            ]);

            switch ($user_position) {
                case 1:
                    $redirect_url = 'Chief/chief-dashboard.php';
                    break;
                case 2:
                    $redirect_url = 'Manager/manager-dashboard.php';
                    break;
                case 3:
                    $redirect_url = 'Officer/officer-dashboard.php';
                    break;
                default:
                    echo '<script>alert("Unauthorized access.");</script>';
                    exit();
            }
            // แสดงข้อความหากบันทึกสำเร็จ
            echo "<script>
                    alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                    window.location.href = '$redirect_url';
                </script>";
        } catch (PDOException $e) {
            // แสดงข้อความหากเกิดข้อผิดพลาด
            echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $e->getMessage();
        }
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn = null;
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MAFIA APPRAISAL<</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
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
                  <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="./officer-profile.php" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="./index.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <form method="POST">
            <div class="card-body">
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
                            value="1" />
                          <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question1" id="inlineRadio2"
                            value="2" />
                          <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question1" id="inlineRadio3"
                            value="3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question1" id="inlineRadio4"
                            value="4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question1" id="inlineRadio5"
                            value="5" />
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
                            value="1" />
                          <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question2" id="inlineRadio2"
                            value="2" />
                          <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question2" id="inlineRadio3"
                            value="3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question2" id="inlineRadio4"
                            value="4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question2" id="inlineRadio5"
                            value="5" />
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
                            value="1" />
                          <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question3" id="inlineRadio2"
                            value="2" />
                          <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question3" id="inlineRadio3"
                            value="3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question3" id="inlineRadio4"
                            value="4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question3" id="inlineRadio5"
                            value="5" />
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
                            value="1" />
                          <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question4" id="inlineRadio2"
                            value="2" />
                          <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question4" id="inlineRadio3"
                            value="3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question4" id="inlineRadio4"
                            value="4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question4" id="inlineRadio5"
                            value="5" />
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
                            value="1" />
                          <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question5" id="inlineRadio2"
                            value="2" />
                          <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question5" id="inlineRadio3"
                            value="3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question5" id="inlineRadio4"
                            value="4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question5" id="inlineRadio5"
                            value="5" />
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
                            value="1" />
                          <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question6" id="inlineRadio2"
                            value="2" />
                          <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question6" id="inlineRadio3"
                            value="3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question6" id="inlineRadio4"
                            value="4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question6" id="inlineRadio5"
                            value="5" />
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
                            value="1" />
                          <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question7" id="inlineRadio2"
                            value="2" />
                          <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question7" id="inlineRadio3"
                            value="3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question7" id="inlineRadio4"
                            value="4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question7" id="inlineRadio5"
                            value="5" />
                          <label class="form-check-label" for="inlineRadio5">5</label>
                        </div>
                        <div class="d-inline mx-3"> ดีมาก </div>
                      </div>
                    </div>

                </div>
              </div>
             <div class="btn-group" role="group">
                <button type="submit" class="btn btn-success">ยืนยัน</button>

                <?php
                switch ($user_position) {
                case 1:
                    $redirect_url = 'Chief/chief-dashboard.php';
                    break;
                case 2:
                    $redirect_url = 'Manager/manager-dashboard.php';
                    break;
                case 3:
                    $redirect_url = 'Officer/officer-dashboard.php';
                    break;
                default:
                    echo '<script>alert("Unauthorized access.");</script>';
                    exit();
            }
            ?>
            
                <button type="button" class="btn btn-danger" onclick="window.location.href='<?php echo $redirect_url; ?>'">ยกเลิก</button>
             </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>