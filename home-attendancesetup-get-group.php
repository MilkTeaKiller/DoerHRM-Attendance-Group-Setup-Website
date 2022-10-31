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
$dbc = @mysqli_connect('localhost','root', '', 'calendar') or die('Could not connect to MySQL:' . mysqli_connect_error());

$q1 = "SELECT * FROM attendance_group WHERE agname = '".$_GET['agname']."'";
$r1 = @mysqli_query($dbc, $q1);

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

      <ul class="nav nav-pills row px-2 nav-justified">
        <li class="nav-item">
          <a class="nav-link rounded-0 text-center active" data-toggle="pill" href="#attendancegroup"><span class="font-weight-bold">Attendance Group Details</span></a>
        </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="attendancegroup">
          <div style="margin: 10px auto 0px auto; width: 40%; padding: 20px;">
            <table class="table table-striped text-center">
              <tbody id="groupTable">
                <?php
                  while ($row = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {
                    echo '<tr><th style="font-size: 24px; text-align: center;">'. $row["agname"] .'</th></tr>';
                    echo "<tr><th>Attendance Group ID</th></tr>";
                    echo "<tr><td>" . $row["agID"] . "</td></tr>";
                    echo "<tr><th>First Punch In Time</th></tr>";
                    echo "<tr><td>" . $row["firstpunchintime"] . "</td></tr>";
                    echo "<tr><th>Break Time</th></tr>";
                    echo "<tr><td>" . $row["breaktime"] . "</td></tr>";
                    echo "<tr><th>Break Hours</th></tr>";
                    echo "<tr><td>" . $row["breakhours"] . "</td></tr>";
                    echo "<tr><th>Second Punch In Time</th></tr>";
                    echo "<tr><td>" . $row["secondpunchintime"] . "</td></tr>";
                    echo "<tr><th>Second Punch Out Time</th></tr>";
                    echo "<tr><td>" . $row["secondpunchouttime"] . "</td></tr>";
                    echo "<tr><th>Late In Buffer</th></tr>";
                    echo "<tr><td>" . $row["lateinbuffer"] . "</td></tr>";
                    echo "<tr><th>Absent Buffer</th></tr>";
                    echo "<tr><td>" . $row["absentbuffer"] . "</td></tr>";
                    echo "<tr><th>Break Out Buffer</th></tr>";
                    echo "<tr><td>" . $row["breakoutbuffer"] . "</td></tr>";
                    echo "<tr><th>Break In Buffer</th></tr>";
                    echo "<tr><td>" . $row["breakinbuffer"] . "</td></tr>";
                  }
                ?>
              </tbody>
            </table><br /><br />
            <a href="home-attendancesetup.php" class="btn btn-primary">Go Back</a>
          </div>
        </div>
      </div>
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