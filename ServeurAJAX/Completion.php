<?php
    function utf8($n) {
       // $n=utf8_decode($n);
    return (utf8_encode($n));
    }	

    $conn = mysqli_connect("127.0.0.1", "root", "", "myDB");

    $q = mysqli_real_escape_string($conn,trim($_GET['term']));
   
    $sql="SELECT `LibAliment` FROM `ALIMENT` WHERE `LibAliment` LIKE '%". $q ."%'";
   $query = mysqli_query($conn,$sql);

    $return = array();

    while ($lib_aliment_sugg=mysqli_fetch_assoc($query)) {
     if($lib_aliment_sugg['LibAliment']!="Aliment")
      {$result=$lib_aliment_sugg['LibAliment'];
       array_push($return,$result);
       }
    }
  $return=array_map("utf8",$return);
    $json=json_encode($return); 
    mysqli_close($conn);
    echo $json;
?>

