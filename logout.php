<?php

session_start();

foreach (array_keys($_SESSION) as $key) {
	if (str_starts_with($key, "tp_zakville.")) {
		unset($_SESSION[$key]);
	}
}

header("Location: login.php");
exit();
