<?php

session_start();

session_start();
session_destroy();
header("Location: login.php");
exit();






//   unset($_SESSION['connected'], $_SESSION['pseudo']);
//   header("Location: index.php");



//  session_start();

//  foreach (array_keys($_SESSION) as $key) {
//  	if (str_starts_with($key, "tp_zakville.")) {
// 		unset($_SESSION[$key]);	}
// }

// header("Location: login.php");
//  exit();
//  


?>