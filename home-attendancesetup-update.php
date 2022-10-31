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
$attendancegroupResult = $attendancegroupObj->get_attendance_group($_GET["agID"]);
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
          <h4 class="m-0"><i class="fas fa-user-cog"></i> Attendance Setup</h4>
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
            <?php
                if($attendancegroupResult) {
                    foreach ($attendancegroupResult as $row) {
            ?>
            
            <form method="POST" action="home-attendancesetup-updateAction.php">
            <input type="hidden" name="agID" value="<?php echo $row['agID'];?>"/>
              <table width="100%">
                <tr>
                  <th>Group Name</th>
                </tr>
                <tr>
                  <th colspan="2" width="100%"><input class="form-control rounded-0" type="text" name="agname" value="<?php echo $row['agname'];?>"></th>
                </tr>
                <tr>
                  <th>First Punch-In Time</th>
                </tr>
                <tr>
                  <th colspan="2" width="100%"><input class="form-control rounded-0" type="time" name="firstpunchintime" value="<?php echo $row['firstpunchintime'];?>"></th>
                </tr>
                <tr>
                  <th>Late In Buffer (min)</th>
                  <th>Absent Buffer (min)</th>
                </tr>
                <tr>
                  <th width="50%"><input class="form-control rounded-0" type="number" min="1" max="30" name="lateinbuffer"></th>
                  <th width="50%"><input class="form-control rounded-0" type="number" min="1" max="60" name="absentbuffer"></th>
                </tr>
                <tr>
                  <th>Break Time</th>
                  <th>Break Hours (hours)</th>
                </tr>
                <tr>
                  <th width="50%"><input class="form-control rounded-0" type="time" name="breaktime" value="<?php echo $row['breaktime'];?>"></th>
                  <th width="50%"><input class="form-control rounded-0" type="number" name="breakhours" min="0" max="5"></th>
                </tr>
                <tr>
                  <th>Break Out Buffer (min)</th>
                  <th>Break In Buffer (min)</th>
                </tr>
                <tr>
                  <th width="50%"><input class="form-control rounded-0" type="number" min="0" max="15" step="5" name="breakoutbuffer"></th>
                  <th width="50%"><input class="form-control rounded-0" type="number" min="0" max="15" step="5" name="breakinbuffer"></th>
                </tr>
                <tr>
                  <th>Punch-Out</th>
                </tr>
                <tr>
                  <th colspan="2" width="100%"><input class="form-control rounded-0" type="time" name="secondpunchouttime" value="<?php echo $row['secondpunchouttime'];?>"></th>
                </tr>
                <tr>
                    <th>Status</th>
                </tr>
                <tr>
                <th colspan="2" width="100%"><input class="form-control rounded-0" type="text" name="status" value="<?php echo $row['status'];?>"></th>
                </tr>
                <tr>
                    <th><a href="home-attendancesetup.php" class="btn btn-primary btn-block" style="margin-top: 10px;">Go Back</a></th>
                    <th><input type="submit" value="Update" class="btn btn-success btn-block" style="margin-top: 10px;"></th>
                </tr>
              </table>
            </form>
            <?php
                    }
                }
            ?>
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