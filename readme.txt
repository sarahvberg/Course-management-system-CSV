This file will explain how to use access the website, how it works,
and simply go into some of the details around it.


______How to start______
Put the whole folder into htdocs in XAMPP, start apache and mysql, 
and open index.php in localhost. 


________How to use_________
The system start with three students, and three courses, so that
the tables are already filled out a bit when first entering.
The test_input file provides one more student and one more course,
as well as more grades in several courses.


_______Design_________
I have not put to much weight on the design. For example I use <br> on the forms etc to
make them look more organized, eventhough I know this using <br> is not best practice.
Parts of this design will also be implemented in assignment number 2.


_____File structure__________
- "index.php" is just a front for making the design more organized
- "data" folder holds all the csv files needed, included the provided test-input.
- "classes" folder holds the two classes, Course and Student.
- I have gathered functions and code in their designated areas, to make it more organized.
- "datahandler.php" is a tiny library of functions.


_____Div comments________
- birthdays are written month, day, year in the test_input file, and will be stored
as unix values in students.csv. When displayed in the table, it will be displayed as
day, month, year. 
