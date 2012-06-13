<?
mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("Schooledcloud") or die(mysql_error());

//Front page algorithm
$time = date("Y-m-d H:i:s");
$time = strtotime($time);
$time = $time - 3600;
$x = 0;
$stop = 0;
$result = mysql_query("SELECT * FROM Groups ORDER BY date DESC");
	echo '<div class="file"><img src="http://upload.wikimedia.org/wikipedia/commons/b/be/Aiga_uparrow_inv.gif" width="20" height="20"><a href="/';
	$uFileLocations = $row['id'];
	$uFileName = $row['title'];
	$uUp = $row['up'];
	$uDown = $row['down'];
	$uDate = $row['date'];
	$fId = $row['id'];
	
	  $s = ($uUp - $uDown);
      $order = log(max(abs($s), 1), 10);
        
        if($s > 0) {
            $sign = 1;
        } elseif($s < 0) {
            $sign = -1;
        } else {
            $sign = 0;
        }
        
        $seconds = $uDate - 1134028003;
        
        $score = round($order + (($sign * $seconds)/45000), 7);
		
		//Confindence
		
		$n = $uUp + $uDown;
        
        if($n === 0) {
            $confindence = 0;
        }
		else
		{
        $z = 1.281551565545; // 80% confidence
        $p = floor($uUp) / $n;
        
        $left = $p + 1/(2*$n)*$z*$z;
        $right = $z*sqrt($p*(1-$p)/$n + $z*$z/(4*$n*$n));
        $under = 1+1/$n*$z*$z;
        
        $confindence = ($left - $right) / $under;
		}
		
		//Controversey
		$controversey = ($uUp + $uDown) / max(abs($score), 1);
	
	
	$Rating = 800/(($uUP + $uDown) + $uUp);
	echo $uFileLocations;
	echo '">' . $uFileName . "</a>";
	echo " Rating: " . $Rating . " Score: " . $score . " Confidence: " . $confidence . " Contreoversy: " . $controversy;
	echo '</div> ';
	
	
	mysql_query("UPDATE Groups SET score='$score' WHERE id='$fId'");
	
	$x++;
  //End of front page algorithm
  ?>