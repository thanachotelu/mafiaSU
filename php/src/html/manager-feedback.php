<?php
    include "connection.php";
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MAFIA APPRAISAL</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
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
                    <a href="./profile.php" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="./index.html" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Employee Feedback Form</h5>
            <p class="mb-0">This is a sample page </p>
          </div>

          <div class="container">
            <h2>Employee Feedback Form</h2>
            <form id="feedbackForm">

              <!-- Department Selection -->
              <div class="form-group">
                <label for="department">Department</label>
                <select id="department" name="department" required>
                  <option value="">--Select Department--</option>
                  <option value="HR">HR</option>
                  <option value="IT">IT</option>
                  <option value="Marketing">Marketing</option>
                </select>
                <small class="error" id="departmentError"></small>
              </div>

              <!-- Combined Employee Information (Dropdown) -->
              <div class="form-group">
                <label for="employee">Employee</label>
                <select id="employee" name="employee" required>
                  <option value="">--Select Employee--</option>
                </select>
                <small class="error" id="employeeError"></small>
              </div>

              <!-- Feedback Type -->
              <div class="form-group">
                <label for="feedbackType">Feedback Type</label>
                <select id="feedbackType" name="feedbackType" required>
                  <option value="">--Select Feedback Type--</option>
                  <option value="praise">Praise</option>
                  <option value="constructive">Constructive Feedback</option>
                  <option value="general">General Feedback</option>
                </select>
                <small class="error" id="feedbackTypeError"></small>
              </div>

              <!-- Feedback Details -->
              <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required>
                <small class="error" id="subjectError"></small>
              </div>

              <div class="form-group">
                <label for="details">Details</label>
                <textarea id="details" name="details" rows="5" required></textarea>
                <small class="error" id="detailsError"></small>
              </div>

              <!-- Date of Feedback -->
              <div class="form-group">
                <label for="feedbackDate">Date of Feedback</label>
                <input type="date" id="feedbackDate" name="feedbackDate" required>
              </div>

              <!-- CEO Signature -->
              <div class="form-group">
                <label for="signature">CEO Signature</label>
                <input type="text" id="signature" name="signature" required>
                <small class="error" id="signatureError"></small>
              </div>

              <div class="form-group">
                <input type="submit" value="Submit Feedback">
              </div>

            </form>
          </div>

          <script>
            const employeeData = {
              HR: [
                { id: 'HR001', name: 'Alice Johnson' },
                { id: 'HR002', name: 'Bob Smith' }
              ],
              IT: [
                { id: 'IT001', name: 'Charlie Brown' },
                { id: 'IT002', name: 'Dana White' }
              ],
              Marketing: [
                { id: 'MK001', name: 'Eve Adams' },
                { id: 'MK002', name: 'Frank Wright' }
              ]
            };

            const departmentSelect = document.getElementById('department');
            const employeeSelect = document.getElementById('employee');

            departmentSelect.addEventListener('change', function () {
              const department = departmentSelect.value;

              // Clear current options in Employee dropdown
              employeeSelect.innerHTML = '<option value="">--Select Employee--</option>';

              // If a department is selected, populate the Employee dropdown
              if (department) {
                const employees = employeeData[department];
                employees.forEach(employee => {
                  const option = document.createElement('option');
                  option.value = `${employee.id} - ${employee.name}`;
                  option.textContent = `${employee.id} - ${employee.name}`;
                  employeeSelect.appendChild(option);
                });
              }
            });

            document.getElementById('feedbackForm').addEventListener('submit', function (event) {
              event.preventDefault();

              var formValid = true;

              // Validate department selection
              var department = document.getElementById('department').value;
              if (department === '') {
                document.getElementById('departmentError').textContent = 'Please select a department.';
                formValid = false;
              } else {
                document.getElementById('departmentError').textContent = '';
              }

              // Validate Employee selection
              var employee = document.getElementById('employee').value;
              if (employee === '') {
                document.getElementById('employeeError').textContent = 'Please select an employee.';
                formValid = false;
              } else {
                document.getElementById('employeeError').textContent = '';
              }

              if (formValid) {
                alert('Feedback submitted successfully!');
                // You can add code here to submit the form data to the server
              }
            });
          </script>
    </div>
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
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
</body>

</html>