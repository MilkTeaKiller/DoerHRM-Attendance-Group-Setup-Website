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

// To get the objects for managing database
$attendancegroupObj = new Attendancegroup();
$attendancegroupResult = $attendancegroupObj->search_attendance_group_list();
$assignShiftObj = new AssignShift();
$assignShiftResult = $assignShiftObj->search_shift_list();
$manageShiftObj = new ManageShift();
$manageShiftResult = $manageShiftObj->search_manage_shift_list();

// To get the connection for MYSQL phpmyadmin
$dbc = @mysqli_connect('localhost','root', '', 'calendar') or die('Could not connect to MySQL:' . mysqli_connect_error());

// To get the data using SQL Code
$q1 = "SELECT * FROM user ORDER BY userID ASC";
$r1 = @mysqli_query($dbc, $q1);

$q2 = "SELECT agname FROM attendance_group ORDER BY agID ASC";
$r2 = @mysqli_query($dbc, $q2);

$q3 = "SELECT * FROM user JOIN company ON user.companyID = company.companyID ORDER BY userID ASC";
$r3 = @mysqli_query($dbc, $q3);

$q4 = "SELECT * FROM corporate ORDER BY corporateID ASC";
$r4 = @mysqli_query($dbc, $q4);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Attendance Setup - DoerHRM</title>
  <?php
  include 'includes/header.php';
  ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    // Searching for the value that I want to find.
    $(document).ready(function() {
      $("#shiftTableInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#shiftTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });

      $("#groupTableInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#groupTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });

      $("#userTableInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#userTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });

      $("#corporateIDChoice").on("change", function() {
        var value = $(this).val().toLowerCase();
        $("#corporateUsers option").filter(function() {
          $(this).toggle($(this).attr("class").toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>
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
          <a class="nav-link text-center active" data-toggle="pill" href="#attendancegroup"><span class="font-weight-bold">Add Attendance Group</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-center" data-toggle="pill" href="#manage_attendancegroup"><span class="font-weight-bold">Manage Attendance Group</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-center" data-toggle="pill" href="#assign_shift"><span class="font-weight-bold">Assign Shift</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-center" data-toggle="pill" href="#manage_shift"><span class="font-weight-bold">Manage Shifts</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-center" data-toggle="pill" href="#manage_users"><span class="font-weight-bold">Manage Users</span></a>
        </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="attendancegroup">
          <div style="margin: 10px auto 0px auto; width: 40%; padding: 20px;">
          <!-- Insert the attendance data for the attendance group -->
            <form method="POST" action="home-attendancesetup-insertAction.php" autocomplete="off">
              <table width="100%">
             
                <tr>
                  <th>Group Name</th>
                </tr>
                <tr>
                  <th colspan="2" width="100%"><input class="form-control" type="text" name="agname"></th>
                </tr>
                <tr><td><br /></td></tr>
                <tr>
                  <th>Punch-In</th>
                </tr>
                <tr>
                  <th colspan="2" width="100%"><input class="form-control" type="time" name="firstpunchintime"></th>
                </tr>
                <tr><td><br /></td></tr>
                <tr>
                  <th>Late In Buffer (min)</th>
                  <th>Absent Buffer (min)</th>
                </tr>
                <tr>
                  <th width="50%"><input class="form-control" type="number" min="1" max="30" value="15" name="lateinbuffer"></th>
                  <th width="50%"><input class="form-control" type="number" min="1" max="60" value="30" name="absentbuffer"></th>
                </tr>
                <tr><td><br /></td></tr>
                <tr>
                  <th>Break Time</th>
                  <th>Break Hours (hours)</th>
                </tr>
                <tr>
                  <th width="50%"><input class="form-control" type="time" name="breaktime"></th>
                  <th width="50%"><input class="form-control" type="number" min="0" max="5" value="1" name="breakhours"></th>
                </tr>
                <tr><td><br /></td></tr>
                <tr>
                  <th>Break Out Buffer (min)</th>
                  <th>Break In Buffer (min)</th>
                </tr>
                <tr>
                  <th width="50%"><input class="form-control" type="number" min="0" max="15" step="5" value="10" name="breakoutbuffer"></th>
                  <th width="50%"><input class="form-control" type="number" min="0" max="15" step="5" value="10" name="breakinbuffer"></th>
                </tr>
                <tr><td><br /></td></tr>
                <tr>
                  <th>Punch-Out</th>
                </tr>
                <tr>
                  <th colspan="2" width="100%"><input class="form-control" type="time" name="secondpunchouttime"></th>
                </tr>
                <tr><td><br /></td></tr>
                <tr>
                  <th>Status</th>
                </tr>
                <tr>
                  <th colspan="2" width="100%">
                    <select name="status" class="form-control">
                      <option>Active</option>
                      <option>Inactive</option>
                    </select>
                  </th>
                </tr>
                <tr><td><br /></td></tr>
                <tr>
                  <th><input type="submit" value="Add" class="btn btn-primary btn-block" style="margin-top: 10px;"></th>
                  <th><input type="reset" value="Reset" class="btn btn-secondary btn-block" style="margin-top: 10px;"></th>
                </tr>
              </table>
            </form>
          </div>
        </div>
        <div class="tab-pane" id="manage_attendancegroup">
          <div style="margin: 10px auto 0px auto; width: 95%; padding: 20px;">
          <!-- To show all attendance groups and can edit and delete -->
            <form method="GET">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th colspan="8" style="font-size: 24px;">Existing Attendance Group</th>
                    <th colspan="2"><input type="text" class="form-control" id="groupTableInput" placeholder="Search group.."></th>
                  </tr>
                  <tr>
                    <th>Attendance Group ID (Shift ID)</th>
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
                <tbody id="groupTable">
                  <tr>
                    <!-- PHP Code to get the data from the database -->
                    <?php
                    if($attendancegroupResult) {
                      foreach ($attendancegroupResult as $row) {
                        echo "<tr>";
                        echo "<td>{$row['agID']}</td>";
                        echo "<td><a href='home-attendancesetup-get-group?agname=" . $row["agname"] . "'>{$row['agname']}</td>";
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
        <!-- Assign Shift Part -->
        <div class="tab-pane" id="assign_shift">
          <div style="margin: 10px auto 0px auto; width: 50%; padding: 20px; height: 600px; overflow-y:auto;">
          <h1>Assign Shift</h1><br /><br />
          <!-- Assign Shift to assign the shift to each user -->
            <form method="POST" action="home-assignShiftInsertAction.php">
              <table width="100%">
                <tr>
                  <th width="100%">
                  <select id="corporateIDChoice" name="userData" class="form-control">
                    <option value="none">
                        Choose Corporate ID
                      </option>
                    <?php 
                      while ($row = mysqli_fetch_array($r4, MYSQLI_ASSOC)) {
                    ?>
                          <option value="<?php echo $row['corporateID']; ?>">
                            <?php 
                            echo $row['corporateID'];
                            ?>
                          </option>
                    <?php
                      }
                    ?>
                    </select>
                  </th>
                </tr>
                <tr><td><br /></td></tr>
                <tr>
                  <th>Choose User</th>
                </tr>
                <tr>
                  <th width="100%">
                    <!-- To select a user -->
                    <select id="corporateUsers" name="userData" class="form-control">
                    <?php 
                      while ($row = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {
                        if (!(empty($row['firstname']) && empty($row['lastname']))) {
                          if (is_null($row['corporateID']) && !is_null($row['companyID'])) {
                    ?>
                          <option class="<?php echo $row['corporateID']; ?>" value="<?php echo $row['userID'] . ", ". $row['firstname'] . " " . $row['lastname'] . ", 0, " . $row['companyID'] ?>">
                            <?php 
                            echo $row['firstname'] . " " . $row['lastname'];
                            ?>
                          </option>
                    <?php
                          } elseif (!is_null($row['corporateID']) && is_null($row['companyID'])) {
                    ?>
                          <option class="<?php echo $row['corporateID']; ?>" value="<?php echo $row['userID'] . ", ". $row['firstname'] . " " . $row['lastname'] . ", " . $row['corporateID'] . ", 0"; ?>">
                            <?php 
                            echo $row['firstname'] . " " . $row['lastname'];
                            ?>
                          </option>
                    <?php
                          } elseif (is_null($row['corporateID']) && is_null($row['companyID'])) {
                    ?>
                          <option class="<?php echo $row['corporateID']; ?>" value="<?php echo $row['userID'] . ", ". $row['firstname'] . " " . $row['lastname'] . ", 0, 0"; ?>">
                            <?php 
                            echo $row['firstname'] . " " . $row['lastname'];
                            ?>
                          </option>
                    <?php
                          } elseif (!(is_null($row['corporateID']) && is_null($row['companyID']))) {
                    ?>
                          <option class="<?php echo $row['corporateID']; ?>" value="<?php echo $row['userID'] . ", ". $row['firstname'] . " " . $row['lastname'] . ", " . $row['corporateID'] . ", " . $row['companyID']; ?>">
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
                <tr><td><br /></td></tr>
                <tr>
                  <!-- This is to choose shift ID -->
                  <th >Shift ID (Attendance group ID)</th>
                </tr>
                <tr>
                  <th width="100%">
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
                <tr><td><br /></td></tr>
                <tr>
                  <th><input type="submit" value="Assign" class="btn btn-primary btn-block" style="margin-top: 10px;"></th>
                </tr>
              </table>
            </form>
          </div>
        </div>
        <!-- MANAGE SHIFTS PART -->
        <div class="tab-pane" id="manage_shift">
          <div style="margin: 10px auto 0px auto; width: 100%; padding: 20px;">
          <!-- This is to show all shifts from the database. -->
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th colspan="3" style="font-size: 24px;">Existing Shifts</th>
                    <th colspan="2"><input type="text" class="form-control" id="shiftTableInput" placeholder="Search shift.."></th>
                  </tr>
                  <tr>
                    <th>Username</th>
                    <th>Shift Group Name</th>
                    <th>Company ID</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody id="shiftTable">
                  <tr>
                    <?php
                    if($assignShiftResult) {
                      foreach ($assignShiftResult as $row) {
                        echo "<tr>";
                        echo "<td><a href='home-attendancesetup-get-user?userID=" . $row["userID"] . "'>{$row['username']}</td>";
                        echo "<td><a href='home-attendancesetup-get-group?agname=" . $row["agname"] . "'>{$row['agname']}</td>";
                        echo "<td>" . $row["companyID"] . "</td>";
                        echo "<td><a href='home-assignShiftUpdate.php?shiftID={$row['shiftID']}' class='btn btn-success'>Edit</a></td>
                              <td><a href='home-assignShiftDeleteAction.php?shiftID={$row['shiftID']}' class='btn btn-danger'>Delete</a></td>";
                        echo "</tr>";
                      }
                    }
                    ?>
                  </tr>
                </tbody>
              </table>
          </div>
        </div>
        <div class="tab-pane" id="manage_users">
          <div style="margin: 10px auto 0px auto; width: 95%; padding: 20px; height: 600px; overflow-y:auto;">
          <!-- This is to show all users from the database. -->
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th colspan="5" style="font-size: 24px;">Manage Users</th>
                    <th colspan="2"><input type="text" class="form-control" id="userTableInput" placeholder="Search user.."></th>
                  </tr>
                  <tr>
                    <th>Profile Picture</th>
                    <th>User ID</th>
                    <th>User Full Name</th>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="userTable">
                    <?php
                      while ($row = mysqli_fetch_array($r3, MYSQLI_ASSOC)) {
                        if ($row['profilepic'] != null) {
                          echo '<tr><td><img style="width:60px;" src="data:image/jpg;base64,' . base64_encode($row['profilepic']) . '" alt="No Image"></td>';
                        } else {
                          echo '<tr><td><img style="width:60px;" src="img/profile.jpg" alt="No Image"></td>';
                        }
                        echo "<td>" . $row["userID"] . "</td>";
                        echo "<td><a href='home-attendancesetup-get-user?userID=" . $row["userID"] . "'>" . $row["firstname"] . " " . $row["lastname"] . "</a></td>";
                        echo "<td>" . $row["company"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["status"] . "</td></tr>";
                      }
                    ?>
                </tbody>
              </table>
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