<?php

/* let's start */

class time_on_site {


   function time_on_site() {

      $this -> userID  = $_COOKIE["time_on_site_ID"]; // user's ID
      $this -> timeonsite  = $_COOKIE["time_on_site_TT"]; // user's total time on site
      $this -> userentered  = $_COOKIE["time_on_site_ST"]; // time when user entered the site
      $this -> useronline  = $_COOKIE["time_on_site_TO"]; // time that the user has been online this sesion
      $this -> ScriptID = 0; // ID to generate diferent scripts in case of multiple call of display() function

      if ($this -> userID != "") {

         if ($this -> userentered == "") {

            $this -> userentered = time();
            setcookie("time_on_site_ST", $this -> userentered);
         }

         $this -> userLPT = time() - $this -> userentered - $this -> useronline;

         $this -> timeonsite += $this -> userLPT;
         setcookie("time_on_site_TT", $this -> timeonsite, time()+60*60*60*60*60);

         $this -> useronline = time() - $this -> userentered;
         setcookie("time_on_site_TO", $this -> useronline);

         $this -> useronline = time_on_site::normalizare($this -> useronline);
         $this -> timeonsite = time_on_site::normalizare($this -> timeonsite);
      }

      if ($this -> userID == "") {

         time_on_site::newID();
      }

   }

   function newID() {

         $this -> userID = md5(rand());
         $this -> userentered = time();
         $this -> useronline = 0;
         $this -> timeonsite = 0;
         setcookie("time_on_site_ID", $this -> userID, time()+(60*60*24*365*10));
         setcookie("time_on_site_ST", $this -> userentered);
         setcookie("time_on_site_TO", $this -> useronline);
         setcookie("time_on_site_TT", $this -> timeonsite, time()+(60*60*24*365*10));
   }

   function normalizare($secunde) {

	     $minute  = $secunde / 60;
	     $secunde = $secunde % 60;
	     $ore     = $minute  / 60;
	     $minute  = $minute  % 60;
      $zile    = $ore     / 24;
	     $ore     = $ore     % 24;

	     return $timp = array("days" => (int)$zile, "hours" => $ore, "minutes" => $minute, "seconds" => $secunde);
   }

   function display_time($type){

      $this -> ScriptID++;

      if ($type == "current_page") {

         $time_start_multiply = 0;
      }

      if ($type == "current_session") {

         $time_start_multiply = $this -> useronline["days"]*24*60*60 + $this -> useronline["hours"]*60*60 + $this -> useronline["minutes"]*60 + $this -> useronline["seconds"];
      }

      if ($type == "total_time") {

         $time_start_multiply = $this -> timeonsite["days"]*24*60*60 + $this -> timeonsite["hours"]*60*60 + $this -> timeonsite["minutes"]*60 + $this -> timeonsite["seconds"];
      }

      echo "
	           <script type=\"text/javascript\">
	           document.writeln(\"<span id=\\\"time_on_site" . $this -> ScriptID . "\\\"></span>\");

	           zi_inceput" . $this -> ScriptID . " = new Date();
	           ceas_start" . $this -> ScriptID . " = zi_inceput" . $this -> ScriptID . ".getTime();

	           function initStopwatch" . $this -> ScriptID . "() {

               var timp_pe_pag" . $this -> ScriptID . " = new Date();
   	           return((timp_pe_pag" . $this -> ScriptID . ".getTime()+(1000*$time_start_multiply) - ceas_start" . $this -> ScriptID . ")/1000);
	           }
	           function getSecs" . $this -> ScriptID . "() {


            	  var tSecs" . $this -> ScriptID . " = Math.round(initStopwatch" . $this -> ScriptID . "());
	              var iSecs" . $this -> ScriptID . " = tSecs" . $this -> ScriptID . " % 60;
	              var iMins" . $this -> ScriptID . " = Math.round((tSecs" . $this -> ScriptID . "-30)/60);
	              var iHour" . $this -> ScriptID . " = Math.round((iMins" . $this -> ScriptID . "-30)/60);
	              var iMins" . $this -> ScriptID . " = iMins" . $this -> ScriptID . " % 60;
	              var iDays" . $this -> ScriptID . " = Math.round((iHour" . $this -> ScriptID . "-11)/24);
               if (iDays" . $this -> ScriptID . " == -0) {iDays" . $this -> ScriptID . " *= (-1)}; // Stupid Opera :)
	              var iHour" . $this -> ScriptID . " = iHour" . $this -> ScriptID . " % 24;
	              var sSecs" . $this -> ScriptID . " = \"\" + ((iSecs" . $this -> ScriptID . " > 9) ? iSecs" . $this -> ScriptID . " : \"0\" + iSecs" . $this -> ScriptID . ");
	              var sMins" . $this -> ScriptID . " = \"\" + ((iMins" . $this -> ScriptID . " > 9) ? iMins" . $this -> ScriptID . " : \"0\" + iMins" . $this -> ScriptID . ");
	              var sHour" . $this -> ScriptID . " = \"\" + ((iHour" . $this -> ScriptID . " > 9) ? iHour" . $this -> ScriptID . " : \"0\" + iHour" . $this -> ScriptID . ");

               document.getElementById('time_on_site" . $this -> ScriptID . "').innerHTML=iDays" . $this -> ScriptID . "+\":\"+sHour" . $this -> ScriptID . "+\":\"+sMins" . $this -> ScriptID . "+\":\"+sSecs" . $this -> ScriptID . ";
               window.setTimeout('getSecs" . $this -> ScriptID . "()',1000);

	           }
               window.setTimeout('getSecs" . $this -> ScriptID . "()',1000)

	           </script>
      ";


   }
}

?>