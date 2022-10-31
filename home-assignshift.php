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
}
$attendancegroupObj = new Attendancegroup();
$attendancegroupResult = $attendancegroupObj->search_attendance_group_list();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Attendance Setup - DoerHRM</title>
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
          <h4 class="m-0"><i class="fas fa-user-cog"></i> Assign Shift</h4>
        </div>
      </div>

      <ul class="nav nav-tabs row px-2">
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center active" data-toggle="tab" href="#attendancegroup"><span class="font-weight-bold">ATTENDANCE GROUP</span></a>
        </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="attendancegroup">
          <div style="margin: auto; width: 40%; padding: 20px;">
            <form method="POST" action="home-attendancesetup-insertAction.php">
              <table width="100%">
                <tr>
                  <th>Group ID</th>
                </tr>
                <tr>
                  <th colspan="2" width="100%"><input class="form-control rounded-0" type="text" name="agID"></th>
                </tr>
                <tr>
                  <th>Group Name</th>
                </tr>
                <tr>
                  <th colspan="2" width="100%"><input class="form-control rounded-0" type="text" name="agname"></th>
                </tr>
                <tr>
                  <th>Punch-In</th>
                </tr>
                <tr>
                  <th colspan="2" width="100%"><input class="form-control rounded-0" type="time" name="firstpunchintime"></th>
                </tr>
                <tr>
                  <th>Late In Buffer (min)</th>
                  <th>Absent Buffer (min)</th>
                </tr>
                <tr>
                  <th width="50%"><input class="form-control rounded-0" type="number" min="1" max="30" value="15" name="lateinbuffer"></th>
                  <th width="50%"><input class="form-control rounded-0" type="number" min="1" max="60" value="30" name="absentbuffer"></th>
                </tr>
                <tr>
                  <th>Break Time</th>
                  <th>Break Hours (hours)</th>
                </tr>
                <tr>
                  <th width="50%"><input class="form-control rounded-0" type="time" name="breaktime"></th>
                  <th width="50%"><input class="form-control rounded-0" type="number" min="0" max="5" value="1" name="breakhours"></th>
                </tr>
                <tr>
                  <th>Break Out Buffer (min)</th>
                  <th>Break In Buffer (min)</th>
                </tr>
                <tr>
                  <th width="50%"><input class="form-control rounded-0" type="number" min="0" max="15" step="5" value="10" name="breakoutbuffer"></th>
                  <th width="50%"><input class="form-control rounded-0" type="number" min="0" max="15" step="5" value="10" name="breakinbuffer"></th>
                </tr>
                <tr>
                  <th>Punch-Out</th>
                </tr>
                <tr>
                  <th colspan="2" width="100%"><input class="form-control rounded-0" type="time" name="secondpunchouttime"></th>
                </tr>
                <tr>
                  <th>Status</th>
                </tr>
                <tr>
                  <th colspan="2" width="100%"><input class="form-control rounded-0" type="text" name="status"></th>
                </tr>
                <tr>
                  <th><input type="submit" value="Add" class="btn btn-primary btn-block" style="margin-top: 10px;"></th>
                  <th><input type="reset" value="Reset" class="btn btn-secondary btn-block" style="margin-top: 10px;"></th>
                </tr>
              </table>
            </form>
          </div>

          <div style="margin: auto; width: 95%; padding: 20px;">
            <form method="GET">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th colspan="8" style="font-size: 24px;">Existing Attendance Group</th>
                  </tr>
                  <tr>
                    <th>Attendance Group Name</th>
                    <th>1st Punch In Time</th>
                    <th>1st Punch Out Time</th>
                    <th>Break Hours</th>
                    <th>2nd Punch In Time</th>
                    <th>2nd Punch Out Time</th>
                    <th>Status</th>
                    <th colspan="2">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <?php
                    if($attendancegroupResult) {
                      foreach ($attendancegroupResult as $row) {
                        echo "<tr>";
                        echo "<td>{$row['agname']}</td>";
                        echo "<td>{$row['firstpunchintime']}</td>";
                        echo "<td>{$row['breaktime']}</td>";
                        echo "<td>{$row['breakhours']}</td>";
                        echo "<td>{$row['secondpunchintime']}</td>";
                        echo "<td>{$row['secondpunchouttime']}</td>";
                        echo "<td>{$row['status']}</td>";
                        echo "<td><a href='home-attendancesetup-update.php?agID={$row['agID']}' class='btn btn-success'>Edit</a></td>
                              <td><a href='home-attendancesetup-deleteAction.php?agID={$row['agID']}' class='btn btn-danger'>Delete</a></td>";
                        echo "</tr>";
                      }
                    }
                    ?>
                  </tr>
                </tbody>
              </table>
            </form>
          </div>
        </div>
      </div>
      <!-- content -->

    </div>
  </div>
</div>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#sidebar-wrapper .active").removeClass("active");
      $("#attendancesetuptab").addClass("active").addClass("disabled");
      document.getElementById("attendancesetuptab").style.backgroundColor = "DeepSkyBlue";
    });
  </script>
  <?php include 'includes/form.php';?>
  <?php include 'includes/footer.php';?>
</body>
</html>