<?php
    //navigation on all pages
    include "header.php";
    include 'classes/Student.php';
    

    // $grades = fetchArray('data/grades.csv'); hvorfor kan ikke den være her?
    $allStudents = fetchArray('data/students.csv');
    $studentsArray = getStudents($allStudents);


    //This is viewable for users. Count unique students and display the table with details
    echo '<div class="mainbox"><h2>There is a total of ' . count($studentsArray) . ' students in the system</h2>';
    echo displayStudTable($studentsArray);
    echo '</div>';




    //Make an array from a csv file
    function fetchArray($filePath) {
        $fileArray = array_map('str_getcsv', file($filePath));
        return $fileArray;
    }

    //Fetch students and make each into a new object/student
    function getStudents($allStudents) {
        $grades = fetchArray('data/grades.csv'); //get file with grades and credits
        $objectArray = array();
        foreach ($allStudents as $student) {
            //This line comes from the students.csv file
            $newStudent = new Student($student[0], $student[1], $student[2], date('d/m/y', $student[3])); 

            // But also display calculated values in table
            $newStudent->courseComp = $newStudent->courseComp($grades);
            $newStudent->courseFail = $newStudent->courseFail($grades);
            $newStudent->gpa = $newStudent->findGPA($grades);
            $newStudent->status = $newStudent->findStatus($newStudent->gpa);
            
            // Push this data into an array
            array_push($objectArray, $newStudent);
        } 
        //Return the array
        usort($objectArray, 'sortStud'); //Sort accourding to GPA
        //$objectArray = validateStudentArray($objectArray);
        return $objectArray;
    }
    //_______________________________________________________
    


    //Display the table containing headers, and go thorough all details pr student
    function displayStudTable($studentsArray) {
        echo '<table>
                    <tr>
                        <th>Student number</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Date of birth</th>
                        <th>Courses passed</th>
                        <th>Courses failed</th>
                        <th>GPA</th>
                        <th>Status</th>
                    </tr>';
    
        foreach ($studentsArray as $students) {
            $students->displayStudRows(); //Function from student class
        }
        echo '</table>';
    }
    //____________________________________________________________________________-

echo "<br><br><br>";


?>

</body>
</html>