<?php
require_once 'core/init.php';
$user = new User();
if(!$user->isLoggedIn()){
  Redirect::to("login.php");
}else{
  $resultresult = $user->data();
  $userlevel = $resultresult->role;
  if($resultresult->verified == false || $resultresult->superadmin == true){
    $user->logout();
    Redirect::to("login.php?error=error");
  }

  $user_id = $resultresult->userID;

  $attendancerecordObj = new Attendancereport();
  $attendanceResult = $attendancerecordObj->search_attendance_record_list($user_id);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Attendance Report - DoerHRM</title>
  <?php
  include 'includes/header.php';
  ?>
</head>
<body>
  <?php include 'includes/topbar.php';?>
  <div class="d-flex" id="wrapper">
    <?php include 'includes/navbar.php';?>
    <div id="page-content-wrapper">
    <div class="container-fluid" id="content">

      <div class="row my-4">
        <div class="col">
          <h4 class="m-0"><i class="fas fa-chart-bar"></i> Attendance Report</h4>
        </div>
      </div>

      <ul class="nav nav-tabs row px-2">
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center active" data-toggle="tab" href="#individual"><span class="font-weight-bold">INDIVIDUAL</span></a>
        </li>
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center" data-toggle="tab" href="#group"><span class="font-weight-bold">GROUP</span></a>
        </li>
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center" data-toggle="tab" href="#subordinate"><span class="font-weight-bold">SUBORDINATE</span></a>
        </li>
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center" data-toggle="tab" href="#department"><span class="font-weight-bold">DEPARTMENT</span></a>
        </li>
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center" data-toggle="tab" href="#company"><span class="font-weight-bold">COMPANY</span></a>
        </li>
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center" data-toggle="tab" href="#corporate"><span class="font-weight-bold">CORPORATE</span></a>
        </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="individual">
          <table class="table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Punch In Time(M)</th>
                <th>Punch Out Time(M)</th>
                <th>Punch In Time(A)</th>
                <th>Punch Out Time(A)</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if($attendanceResult) {
                foreach ($attendanceResult as $row) {
                  echo "<tr>";
                  echo "<td>{$row['Date']}</td>";
                  echo "<td>{$row['punchIn_morning']}</td>";
                  echo "<td>{$row['punchOut_morning']}</td>";
                  echo "<td>{$row['punchIn_afternoon']}</td>";
                  echo "<td>{$row['punchOut_afternoon']}</td>";
                  echo "</tr>";
                }
              }
              ?>
            </tbody>
          </table><br /><br />
          <form method="post" action="home-attendancereport-download.php">
            <input type="submit" name="export_report" value="Download Report As Excel File" class="btn btn-primary">
          </form>
        </div>

        <div class="tab-pane" id="group">
        </div>

        <div class="tab-pane" id="subordinate">
        </div>

        <div class="tab-pane" id="department">
        </div>

        <div class="tab-pane" id="company">
        </div>

        <div class="tab-pane" id="corporate">
        </div>
      </div>
      <!-- content -->

    </div>
  </div>
</div>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#sidebar-wrapper .active").removeClass("active");
      $("#attendancereporttab").addClass("active").addClass("disabled");
      document.getElementById("attendancereporttab").style.backgroundColor = "DeepSkyBlue";
    });
  </script>
  <?php include 'includes/form.php';?>
  <?php include 'includes/footer.php';?>
</body>
</html>