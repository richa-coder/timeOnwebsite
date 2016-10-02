//ref Dragos Protung
<?php

include ("time_on_site.class.php");


$test = new time_on_site;
//time spent on current page(dynamic)
echo "<br> Curent time on page: ";
$test -> display_time("current_page"); 
//tym spent on current session
echo "<br> Curent time on site: ";
$test -> display_time("current_session"); 
//tym spent on site
echo "<br> Total time on site: ";
$test -> display_time("total_time"); 
// time on site for current session(array,static)
echo "<br> Curent time on site: ";
print_r($test -> useronline); 
// tym on site from all visits(array,static)
echo "<br> Total time on site: ";
print_r($test -> timeonsite); 


?>