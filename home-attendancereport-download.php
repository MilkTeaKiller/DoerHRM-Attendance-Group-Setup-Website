<?php
    if(isset($_POST["export_report"]))  
    {   
        $curDate = date("Ymd");
        // CREATE CONNECTION
        $dbc = @mysqli_connect ('localhost', 'root', '', 'calendar') OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
        header('Content-Type: application/xls; charset=utf-8');  
        header('Content-Disposition: attachment; filename=attendance_report('.$curDate.').xls');
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $query = "SELECT * from attendance_record ORDER BY recordID ASC";  
        $result = mysqli_query($dbc, $query);  

        echo '<table border="1">';
        echo '<tr><th colspan="7" style="font-size:25px; font-weight:bold;"><br />Attendance Report<br />';
        echo '<p style="text-align:right; font-size:12px;">Date:'.date("d/m/Y").'<br /></p><br /></th></tr>';
        echo '<tr><th>Record ID</th><th>Date</th><th>User ID</th><th>Punch-in morning</th><th>Punch-out morning</th><th>Punch-in Afternoon</th><th>Punch-out Afternoon</th></tr>';
        while ($row = mysqli_fetch_assoc($result)){
            echo "<tr><td>".$row['recordID']."</td><td>".$row['Date']."</td><td>".$row['userID']."</td><td>".$row['punchIn_morning']."</td><td>".$row['punchOut_morning']."</td><td>".$row['punchIn_afternoon']."</td><td>".$row['punchOut_afternoon']."</td></tr>";
        }

        echo '<tr><td colspan="7"><p style="font-size:20px; font-weight:bold; text-align:center;">DOER HRM<br /><br /></p></td></tr></table>';
    }  
?>