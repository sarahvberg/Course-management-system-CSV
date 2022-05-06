<?php
    //navigation on all pages
    include "header.php";
    include 'classes/Course.php';

    
    
    $allCourses = fetchArray('data/courses.csv');
    $coursesArray = getCourses($allCourses);


    echo '<div class="mainbox"><h2>There is a total of ' . count($allCourses) . ' courses in the system</h2>';
    echo displayCourseTable($coursesArray);
    echo '</div>';




    //Make an array from a csv file
    function fetchArray($filePath) {
        $fileArray = array_map('str_getcsv', file($filePath));
        return $fileArray;
    }

    function getCourses($allCourses) {
        $totalStuds = fetchArray('data/grades.csv');
        $objectArray = array();
        foreach ($allCourses as $course) {
            //This line comes from the courses.csv file
            $newCourse = new Course($course[0], $course[1], $course[2], $course[3], $course[4], $course[5]); 

            // But also display calculated values in table
            $newCourse->numOfStuds = $newCourse->numOfStuds($totalStuds);
            $newCourse->numOfStudsPass = $newCourse->numOfStudsPass($totalStuds);
            $newCourse->numOfStudsFail = $newCourse->numOfStudsFail($totalStuds);
            $newCourse->avgGrades = $newCourse->findAVGgrade($totalStuds);
            
            // Push this data into an array
            array_push($objectArray, $newCourse);
        } 
        //Return the array
        usort($objectArray, 'sortCourses'); //Sort 
        return $objectArray;
    }


    //Display the table with headers, and foreach through the data
    //displayCourseRows comes from Course.php
    function displayCourseTable($courseArray) {
        echo '<table>
                <tr>
                    <th>Course code</th>
                    <th>Name</th>
                    <th>Year</th>
                    <th>Semester</th>
                    <th>Instructor</th>
                    <th>Number of credits</th>
                    <th>Registered students</th>
                    <th>Students passed</th>
                    <th>Students failed</th>
                    <th>Avarage grade</th>
                </tr>';

        foreach ($courseArray as $courses) {
            $courses->displayCourseRows(); 
        }
        echo '</table>';
    }


?>

</body>
</html>
