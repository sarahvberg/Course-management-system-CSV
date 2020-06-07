<?php

require 'datahandler.php';

class Student {

    public $studentNo;
    private $studentName;
    private $studentSurName;
    private $birthDate;
    public $courseComp;
    public $courseFail;
    public $gpa;
    public $status;

    //Constructors is a function that is called everytime u make an object of the class
    //This constructor takes a csv path as a param, that you specify when creating an object
    function __construct($studentNo, $studentName, $studentSurName, $birthDate) {
        $this->studentNo = $studentNo;
        $this->studentName = $studentName;
        $this->studentSurName = $studentSurName;
        $this->birthDate = $birthDate;
        $this->courseComp = array();
        $this->courseFail = array();
    
    }
    
        
    public function displayStudRows(){
        echo '<tr>
            <td>' . $this->studentNo . '</td>
            <td>' . $this->studentName . '</td>
            <td>' . $this->studentSurName . '</td>
            <td>' . $this->birthDate . '</td>
            <td>' . $this->courseComp . '</td>
            <td>' . $this->courseFail . '</td>
            <td>' . $this->gpa . '</td>
            <td>' . $this->status . '</td>
       </tr>';
    }

    
    /**
     * How many courses has the student passed
     * @param { array } $grades is fetched from grades.csv
    */  
    function courseComp($grades) {
        $this->courseComp = array();

        foreach($grades as $grade){
            if($grade[0] == $this->studentNo && gradeValidation($grade[3]) == true){
                array_push($this->courseComp, $grade);
            }
        }
        return sizeof($this->courseComp);
    }
    //_________________________________________________________________________________



    /**
     * How many courses has the student failed
     * @param { array } $grades is fetched from grades.csv
    */  
    function courseFail($grades) {
        $this->courseFail = array();

        foreach($grades as $grade){
            if($grade[0] == $this->studentNo && gradeValidation($grade[3]) == false){
                array_push($this->courseFail, $grade);
            }
        }
        return sizeof($this->courseFail);
    }
    //_______________________________________________________________________________



    /**
     * calculate gpa with sum(course_credit x grade) / sum(credits_taken).
     * @param { array } $array is fetched from grades.csv
    */    
    function findGPA($array) {
        //$courseCredit = 0;
        $pointPerCourse = array();
        $point = 0;
        $mulCredit = 0;
        $gradeCredit = 0;
        $gradeCreditSum = 0;
        $result = 0;

        //Storing this in an array in this order makes F=0, E=1 etc.
        $grades = ["F", "E", "D", "C", "B", "A"];
        
        // Find the sum of credits pr student
        foreach ($array as $course) {
            if ($course[0] == $this->studentNo) {
                $mulCredit += $course[2];
            }
        }

        // Find course_credit sum, multiplied with grade
        foreach ($array as $stud) {
            if ($stud[0] == $this->studentNo) {
                
                $point = array_search($stud[3], $grades);
                $courseCredit = $stud[2];
                $gradeCredit = $point*$courseCredit;
                array_push($pointPerCourse, $gradeCredit);
            }
        }
        $gradeCreditSum = array_sum($pointPerCourse);
        // calculate sum(course_credit x grade) / sum(credits_taken).
        $result = $gradeCreditSum / $mulCredit;
        $result = round($result, 2);
        
        return $result;
    }
    //__________________________________________________________________________________


    //Find status based on the outcome of findGPA
    //If GPA is mora than or equal to 0, and less or equal to 1.99 etc...
    function findStatus($gpa){ 
        if($gpa >= 0 && $gpa <= 1.99){ 
            return "Unsatisfactory";
        } elseif($gpa >= 2 && $gpa <= 2.99){
            return "Satisfactory";
        } elseif($gpa >= 3 && $gpa <= 3.99){
            return "Honour";
        } elseif($gpa >= 4 && $gpa <= 5){
            return "High Honour";
        }
    }
    //______________________________________________________________


}








?>