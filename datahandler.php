<?php


//This file contains functions that can be used by both courses and students
//and works like a small library of functions.
  

  function gradeValidation($grade){
    switch($grade){
      case "A":
      case "B":
      case "C":
      case "D":
      case "E":
        return true;
      case "F":
        return false;
    }
  }
    
/**
 * Sort students in studenttable accourding to their gpa, descending
 * Compare the gpa between students
 * @param {object} $a is one student's gpa
 * @param {object} $b another student's gpa
 * move the lowest one down, and the highest forward
 */
  function sortStud($a, $b) {
    return $a->gpa < $b->gpa;
  }


/**
 * Sort courses in coursetable accourding to number of students, ascending
 * Compare the number of registered students 
 * @param {object} $a is one course's registered students
 * @param {object} $b another course's registered students
 * If they have the same amount, leave it be
 * If th
 */
function sortCourses($a, $b) {
  if($a->numOfStuds == $b->numOfStuds) {
    return 0;
  } else { 
    return $a->numOfStuds < $b->numOfStuds ? -1 : 1;
  }
}

/**
 * Validate both course and student array to make sure that no
 * student can have the same student number, and that only one course
 * can have a specific coursecode.
 * Find duplicate and remove it.
 * @param { array } $array - array to be validated.
 * 
*/
function validateArray($array) {
  $temp_array = array();
  $i = 0;
  $key_array = array();
 
  foreach($array as $val) {
       if (!in_array($val[0], $key_array)) {
          $key_array[$i] = $val[0];
          $temp_array[$i] = $val;
      }
      $i++; 
  }
  return $temp_array;
} 

/** 
  * Same function as validateArray, but since grades
  * does not have a single key, i need to check against 
  * both studentno and course, so that the student can get
  * grades in more than one course, but not more grades in one course
  *
  * @param {array} $array - the array to be checked.
*/
function validateGradeArray($array) {
  $temp_array = array();
  $i = 0;
  $key_array = array();
 
  foreach($array as $val) {
       if ( !in_array($val[0], $key_array) && !in_array($val[1], $key_array) ) {
          $key_array[$i] = $val[0] . $val[1]; //
          $temp_array[$i] = $val;
      }
      $i++; 
  }
  return $temp_array;
} 

  /**
   * Check for duplicates in the uploaded new file 
   * @param { array } $array - array to check and clean
   * 
  */
  function removeDuplicates($array) {
    $array = array_map("unserialize", array_unique(array_map("serialize",  $array)));
    $array = array_values($array);
    return $array;
}

?>