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
$assignShiftObj = new AssignShift();
$assignShiftResult = $assignShiftObj->get_shift($_GET["shiftID"]);

$dbc = @mysqli_connect('localhost','root', '', 'calendar') or die('Could not connect to MySQL:' . mysqli_connect_error());

$q1 = "SELECT * FROM user ORDER BY userID ASC";
$r1 = @mysqli_query($dbc, $q1);

$q2 = "SELECT agname FROM attendance_group ORDER BY agID ASC";
$r2 = @mysqli_query($dbc, $q2);
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
                if($assignShiftResult) {
                    foreach ($assignShiftResult as $row) {
            ?>
            
            <form method="POST" action="home-assignShiftUpdateAction.php">
            <input type="hidden" name="shiftID" value="<?php echo $row['shiftID'];?>"/>
              <table width="100%">
                <tr>
                  <th>User ID</th>
                </tr>
                <tr>
                <th colspan="2" width="100%">
                    <select name="userData" class="form-control">
                    <?php 
                      while ($row = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {
                        if (!(empty($row['firstname']) && empty($row['lastname']))) {
                          if (is_null($row['corporateID']) && !is_null($row['companyID'])) {
                    ?>
                          <option value="<?php echo $row['userID'] . ", ". $row['firstname'] . " " . $row['lastname'] . ", 0, " . $row['companyID'] ?>">
                            <?php 
                            echo $row['firstname'] . " " . $row['lastname'];
                            ?>
                          </option>
                    <?php
                          } elseif (!is_null($row['corporateID']) && is_null($row['companyID'])) {
                    ?>
                          <option value="<?php echo $row['userID'] . ", ". $row['firstname'] . " " . $row['lastname'] . ", " . $row['corporateID'] . ", 0"; ?>">
                            <?php 
                            echo $row['firstname'] . " " . $row['lastname'];
                            ?>
                          </option>
                    <?php
                          } elseif (is_null($row['corporateID']) && is_null($row['companyID'])) {
                    ?>
                          <option value="<?php echo $row['userID'] . ", ". $row['firstname'] . " " . $row['lastname'] . ", 0, 0"; ?>">
                            <?php 
                            echo $row['firstname'] . " " . $row['lastname'];
                            ?>
                          </option>
                    <?php
                          } elseif (!(is_null($row['corporateID']) && is_null($row['companyID']))) {
                    ?>
                          <option value="<?php echo $row['userID'] . ", ". $row['firstname'] . " " . $row['lastname'] . ", " . $row['corporateID'] . ", " . $row['companyID']; ?>">
                            <?php 
                            echo $row['firstname'] . " " . $row['lastname'];
                            ?>
                          </option>
                    <?php
                          }
                        }
                      }
                    ?>
                    </select>
                  </th>
                </tr>
                <tr>
                  <th>Shift Group ID</th>
                </tr>
                <tr>
                  <th colspan="2" width="100%">
                    <select id="agname" name="agname" class="form-control">
                    <?php 
                      while ($row = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
                    ?>
                          <option value="<?php echo $row['agname']; ?>"><?php echo $row['agname'];?></option>
                    <?php
                      }
                    ?>
                  </select>
                  </th>
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