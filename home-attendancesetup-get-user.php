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

$q1 = "SELECT * FROM user WHERE userID = '".$_GET['userID']."'";
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
          <a class="nav-link rounded-0 text-center active" data-toggle="pill" href="#attendancegroup"><span class="font-weight-bold">User Profile Details</span></a>
        </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="attendancegroup">
          <div style="margin: 10px auto 0px auto; width: 40%; padding: 20px;">
            <table class="table table-striped text-center">
              <tbody id="userTable">
                <?php
                  while ($row = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {
                    echo '<tr><th style="font-size: 24px; text-align: center;">'. $row["firstname"] . " " . $row["lastname"] .'</th></tr>';
                    if ($row['profilepic'] != null) {
                      echo '<tr><td style="text-align:center"><img style="width:200px;" src="data:image/jpg;base64,' . base64_encode($row['profilepic']) . '" alt="No Image"></td></tr>';
                    } else {
                      echo '<tr><td><img style="width:60px;" src="img/profile.jpg" alt="No Image"></td></tr>';
                    }
                    echo "<tr><th>User ID</th></tr>";
                    echo "<tr><td>" . $row["userID"] . "</td></tr>";
                    echo "<tr><th>User Full Name</th></tr>";
                    echo "<tr><td>" . $row["firstname"] . " " . $row["lastname"] . "</td></tr>";
                    echo "<tr><th>Job Position</th></tr>";
                    echo "<tr><td>" . $row["jobposition"] . "</td></tr>";
                    echo "<tr><th>Corporate ID</th></tr>";
                    echo "<tr><td>" . $row["corporateID"] . "</td></tr>";
                    echo "<tr><th>Company ID</th></tr>";
                    echo "<tr><td>" . $row["companyID"] . "</td></tr>";
                    echo "<tr><th>Role</th></tr>";
                    echo "<tr><td>" . $row["role"] . "</td></tr>";
                    echo "<tr><th>Email Address</th></tr>";
                    echo "<tr><td>" . $row["email"] . "</td></tr>";
                    echo "<tr><th>Status</th></tr>";
                    echo "<tr><td>" . $row["status"] . "</td></tr>";
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