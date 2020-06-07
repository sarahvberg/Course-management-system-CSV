<?php

require 'datahandler.php';

class Course {

    private $courseCode;
    private $courseName;
    private $year;
    private $semester;
    private $instructor;
    private $courseCredit;
    public $numOfStuds;
    public $numOfStudsPass;
    public $numOfStudsFail;
    public $avgGrades;

    function __construct($courseCode, $courseName, $year, $semester, $instructor, $courseCredit){
        $this->courseCode = $courseCode;
        $this->courseName = $courseName;
        $this->year = $year;
        $this->setSemester($semester);
        $this->instructor = $instructor;
        $this->setCredits($courseCredit);
        $this->numOfStuds = array();
        $this->numOfStudsPass = array();
        $this->numOfStudsFail = array();
        $this->avgGrades = array();
    }

    function displayCourseRows(){
        echo '<tr>
            <td>' . $this->courseCode . '</td>
            <td>' . $this->courseName . '</td>
            <td>' . $this->year . '</td>
            <td>' . $this->semester . '</td>
            <td>' . $this->instructor . '</td>
            <td>' . $this->courseCredit . '</td>
            <td>' . $this->numOfStuds . '</td>
            <td>' . $this->numOfStudsPass . '</td>
            <td>' . $this->numOfStudsFail . '</td>
            <td>' . $this->avgGrades . '</td>
       </tr>';
   }


   //Setting which values that are accaptable for the semester
   function setSemester($semester) {
        if($semester == "Fall" || $semester == "Spring" || $semester == "Summer") {
            return $this->semester = $semester;
        } else {
            echo "The semester is not valid! It have to be fall, spring or summer";
        }
   }

   //Setting which values that are accaptable for the credits
   function setCredits($courseCredit) {
        if($courseCredit == 10 || $courseCredit == 7 || $courseCredit == 5) {
            return $this->courseCredit = $courseCredit;
        } else {
            echo "The credit is not valid! It have to be 10, 7 or 5";
        }
   }

   //How many students is registered in each course
   function numOfStuds($totalStuds) {
    $this->numOfStuds = array();

    foreach($totalStuds as $students){
        if($students[1] == $this->courseCode){
            array_push($this->numOfStuds, $students);
        }
    }
    return sizeof($this->numOfStuds);
    }


    //How many passed each course
    function numOfStudsPass($totalStuds) {
        $this->numOfStudsPass = array();

        foreach($totalStuds as $pass){
            if($pass[1] == $this->courseCode && gradeValidation($pass[3]) == true){
                array_push($this->numOfStudsPass, $pass);
            }
        }
        return sizeof($this->numOfStudsPass);
    }

    //How many failed each course
    function numOfStudsFail($totalStuds) {
        $this->numOfStudsFail = array();

        foreach($totalStuds as $fail){
            if($fail[1] == $this->courseCode && gradeValidation($fail[3]) == false){
                array_push($this->numOfStudsFail, $fail);
            }
        }
        return sizeof($this->numOfStudsFail);
    }


    /**
     * Find the avarage grade for each student
     * @param { array } $array is an array from grades.csv
     * @return { string } $avgGrade -> the average grade for the course
    */
    function findAVGgrade($array) {
        $grades = ["F", "E", "D", "C", "B", "A"];
        $gradeTemp = $this->avgGrades;
        $tempSum = 0;
        $tempCount = 0;
        $avgGrade = '';
        foreach ($array as $stud) {
            if ($stud[1] == $this->courseCode) {
                $stud[3] = strtoupper($stud[3]);
                // Getting key from grades array
                $point = array_search($stud[3], $grades);
                array_push($gradeTemp, $point);
            }
        }
        if(count($gradeTemp)) {
            
            $tempSum = array_sum($gradeTemp);
            $tempCount = count($gradeTemp);

            $gradeTemp = array_filter($gradeTemp);
            $average = $tempSum / $tempCount;
            
        } 
        $avgGrade = $grades[round($average)];
        return $avgGrade;
    }

}



?>