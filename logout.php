<?php

session_start();

foreach (array_keys($_SESSION) as $key) {
	if (str_starts_with($key, "tp_zakville.")) {
		if (str_ends_with($key, ".demonyms") || str_ends_with($key, ".flags")) {
			continue;
		}
		unset($_SESSION[$key]);
	}
}

header("Location: login.php");
exit();
