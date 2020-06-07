
<?php include 'header.php'; 
    include 'datahandler.php';
?>

<!--------Form for uploading new file----------------------->
<div class="mainbox">
    <p>Only csv files are accepted. Please select the desired file beneath and click the upload button.</p>

    <form method="POST" action="data.php" enctype="multipart/form-data">
    Select file: <input type="file" name="filename" size="10">
                <input type="submit" value="Upload">
    <form>

<!--Code for uploading, checking for duplicates and split the csv into designated files-->
    <?php
        if(isset($_FILES['filename'])) { //get the form
            $fileName = $_FILES["filename"]["name"];
            $fileTemp = $_FILES["filename"]["tmp_name"];
            $ext = pathinfo($fileName, PATHINFO_EXTENSION); //check the file extension

            if ($ext != "csv") { //Check if the file uploaded has csv as extention
                echo '<script>alert("Only csv files can be uploaded")</script>';
            } else {
                $parentArray = array();
                $row = 1;
                if (($fp = fopen($_FILES["filename"]["tmp_name"], "r")) !== FALSE) {
                    while (($data = fgetcsv($fp, 3000, ",")) !== FALSE) {
                        $parentArray[] = $data;
                        $row ++;
                    }

                    $studArray = array();
                    $studRow = 1;
                    if (($studfp = fopen('data/students.csv', "r")) !== FALSE) {
                        while (($studdata = fgetcsv($studfp, 3000, ",")) !== FALSE) {
                            $studArray[] = $studdata;
                            $studRow ++;
                        }
                    }

                    $courseArray = array();
                    $courseRow = 1;
                    if (($coursefp = fopen('data/courses.csv', "r")) !== FALSE) {
                        while (($coursedata = fgetcsv($coursefp, 3000, ",")) !== FALSE) {
                            $courseArray[] = $coursedata;
                            $courseRow ++;
                        }
                    }

                    $gradeArray = array();
                    $gradeRow = 1;
                    if (($gradefp = fopen('data/grades.csv', "r")) !== FALSE) {
                        while (($gradedata = fgetcsv($gradefp, 3000, ",")) !== FALSE) {
                            $gradeArray[] = $gradedata;
                            $gradeRow ++;
                        }
                    }

                    //Split the array and push into their designated arrays
                    foreach($parentArray as $line) {
                        array_push($studArray, array($line[0], $line[1], $line[2], (strtotime($line[3]))));
                        array_push($courseArray, array($line[4], $line[5], $line[6], $line[7], $line[8], $line[9]));
                        array_push($gradeArray, array($line[0], $line[4], $line[9], $line[10]));
                    }

                    $studArray = validateArray($studArray);
                    $studArray = removeDuplicates($studArray);
                    $courseArray = validateArray($courseArray);
                    $courseArray = removeDuplicates($courseArray);
                    $gradeArray = validateGradeArray($gradeArray);
                    $gradeArray = removeDuplicates($gradeArray);

                    $getStudFile = fopen('data/students.csv', 'w+');
                    $getCourseFile = fopen('data/courses.csv', 'w+');
                    $getGradeFile = fopen('data/grades.csv', 'w+');

                    foreach($studArray as $row){
                        fputcsv($getStudFile, $row);
                    }
                    foreach($courseArray as $row){
                        fputcsv($getCourseFile, $row);
                    }
                    foreach($gradeArray as $row){
                        fputcsv($getGradeFile, $row);
                    }
                    echo '<script>alert("Upload successful!")</script>';

                    fclose($fp);
                }
            }
        }

    ?>

</div>

</body>
</html>