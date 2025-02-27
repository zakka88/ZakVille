<?php

session_start();

foreach (array_keys($_SESSION) as $key) {
	unset($_SESSION[$key]);
}

header("Location: login.php");
exit();
