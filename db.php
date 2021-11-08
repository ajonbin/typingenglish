<?php

//Connect DB    
include('./function/connect_db.php');

//Show table
/*
$sql = "show fields from user";
$result = mysql_query($sql);
$i = 1;
while ($row = mysql_fetch_array($result)) { //go through one field at a time
 echo "Field $i: ";
 print_r($row); //display all information about A field which can be accessed thru the "$row" array.
 $i++;
}
*/

//Create User
$sql = "CREATE TABLE user(
          uid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(256) NOT NULL,
          password VARCHAR(256) NOT NULL,
          reg_date DATE NOT NULL
          )";
mysql_query($sql); 
echo mysql_error();

//Create Table

$sql = "CREATE TABLE new_words(user varchar(256) not null, new_words text)";
mysql_query($sql); 
echo mysql_error();

//Delete Table

/*
$sql = "DROP TABLE articles";
mysql_query($sql); 
echo mysql_error();
*/

//Create articles
$sql = "CREATE TABLE articles(
          aid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          title TEXT NOT NULL,
          content TEXT NOT NULL,
          owner VARCHAR(256) NOT NULL,
          date DATE NOT NULL,
          category VARCHAR(256),
          tag1 VARCHAR(256),
          tag2 VARCHAR(256),
          tag3 VARCHAR(256),
          tag4 VARCHAR(256),
          tag5 VARCHAR(256),
          source TEXT,
          voice TEXT,
          annotation TEXT
          )";
mysql_query($sql); 
echo mysql_error();


//Delete
/*
$sql = "DELETE FROM new_words";
mysql_query($sql); 
echo mysql_error();
*/



//Query

/*
$result = mysql_query("select * from articles");
while ($row = mysql_fetch_array($result))
{
  print_r($row);
  echo "<br>";

}
*/
    
?>