<?php
    include "connection.php";
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MAFIA APPRAISAL<</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/appraisal.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
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
          <a href="./index.php" class="text-nowrap logo-img">
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
              <a class="sidebar-link" href="./emp-forms.php" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Forms</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="#" aria-expanded="false">
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
              <a class="sidebar-link" href="./index.php" aria-expanded="false">
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
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">form 1</h5>
              <div class="card">
                <div class="card-body">
                  <form>
                    <!-- <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Email address</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                      <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div> -->
                    <div class="mb-3">
                      <div class="mb-3"> 
                        <label class="form-label">ความรู้และทักษะในการทำงาน</label>  
                        <p>- ความเข้าใจในหน้าที่การงาน ความเชี่ยวชาญ และระดับทักษะ </p>
                      </div>

                      <div class="mb-3">
                        <div class="d-inline mx-3"> แย่มาก </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question1" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question1" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question1" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question1" id="inlineRadio4"
                            value="option4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question1" id="inlineRadio5"
                            value="option5" />
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
                          <input class="form-check-input" type="radio" name="question2" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question2" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question2" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question2" id="inlineRadio4"
                            value="option4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question2" id="inlineRadio5"
                            value="option5" />
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
                          <input class="form-check-input" type="radio" name="question3" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question3" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question3" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question3" id="inlineRadio4"
                            value="option4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question3" id="inlineRadio5"
                            value="option5" />
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
                          <input class="form-check-input" type="radio" name="question4" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question4" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question4" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question4" id="inlineRadio4"
                            value="option4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question4" id="inlineRadio5"
                            value="option5" />
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
                          <input class="form-check-input" type="radio" name="question5" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question5" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question5" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question5" id="inlineRadio4"
                            value="option4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question5" id="inlineRadio5"
                            value="option5" />
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
                          <input class="form-check-input" type="radio" name="question6" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question6" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question6" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question6" id="inlineRadio4"
                            value="option4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question6" id="inlineRadio5"
                            value="option5" />
                          <label class="form-check-label" for="inlineRadio5">5</label>
                        </div>
                        <div class="d-inline mx-3"> ดีมาก </div>
                      </div>
                    </div>

                  </form>
                </div>
              </div>
              
              <h5 class="card-title fw-semibold mb-4">form 2</h5>
              <div class="card">
                <div class="card-body">
                  <form>
                    <!-- <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Email address</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                      <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div> -->
                    <div class="mb-3">
                      <div class="mb-3"> 
                        <label class="form-label">ทักษะและความรู้</label>  
                        <p>- ระดับความเชี่ยวชาญของพนักงานในบทบาทเฉพาะของตน รวมทั้งความสามารถทางเทคนิคและความเข้าใจในงานที่จำเป็น นอกจากนี้ยังประเมินว่าพนักงานสามารถอัปเดตข้อมูลเกี่ยวกับแนวโน้มของอุตสาหกรรมและนำความรู้ใหม่ไปใช้กับงานได้ดีเพียงใด</p>
                      </div>

                      <div class="mb-3">
                        <div class="d-inline mx-3"> แย่มาก </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question7" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question7" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question7" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question7" id="inlineRadio4"
                            value="option4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question7" id="inlineRadio5"
                            value="option5" />
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
                          <input class="form-check-input" type="radio" name="question8" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question8" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question8" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question8" id="inlineRadio4"
                            value="option4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question8" id="inlineRadio5"
                            value="option5" />
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
                          <input class="form-check-input" type="radio" name="question9" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question9" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question9" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question9" id="inlineRadio4"
                            value="option4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question9" id="inlineRadio5"
                            value="option5" />
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
                          <input class="form-check-input" type="radio" name="question10" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question10" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question10" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question10" id="inlineRadio4"
                            value="option4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question10" id="inlineRadio5"
                            value="option5" />
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
                          <input class="form-check-input" type="radio" name="question11" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question11" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question11" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question11" id="inlineRadio4"
                            value="option4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question11" id="inlineRadio5"
                            value="option5" />
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
                          <input class="form-check-input" type="radio" name="question12" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question12" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question12" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question12" id="inlineRadio4"
                            value="option4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question12" id="inlineRadio5"
                            value="option5" />
                          <label class="form-check-label" for="inlineRadio5">5</label>
                        </div>
                        <div class="d-inline mx-3"> ดีมาก </div>
                      </div>
                    </div>

                    <div class="mb-3">
                      <div class="mb-3"> 
                        <label class="form-label">ความสามารถในการปรับตัวและการเรียนรู้</label>  
                        <p>- ความสามารถของพนักงานในการปรับตัวเข้ากับงานใหม่ บทบาทใหม่ หรือสภาพแวดล้อมการทำงานที่เปลี่ยนแปลงไป นอกจากนี้ยังรวมถึงความเต็มใจที่จะเรียนรู้ เติบโตในอาชีพ และนำเครื่องมือหรือวิธีการใหม่ ๆ มาใช้เพื่อปรับปรุงประสิทธิภาพการทำงาน </p>

                      <div class="mb-3">
                        <div class="d-inline mx-3"> แย่มาก </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question13" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question13" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question13" id="inlineRadio3"
                            value="option3" />
                          <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question13" id="inlineRadio4"
                            value="option4" />
                          <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="question13" id="inlineRadio5"
                            value="option5" />
                          <label class="form-check-label" for="inlineRadio5">5</label>
                        </div>
                        <div class="d-inline mx-3"> ดีมาก </div>
                      </div>
                    </div>

                  </form>
                </div>
              </div>
            </div>
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-success">ยืนยัน</button>
              <button type="button" class="btn btn-danger">ยกเลิก</button>
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
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>