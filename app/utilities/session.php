<?php

function displaySessionsMessages(): string
{
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}

	$output = "";

	$sessionErrorName = "tp_zakville.errors";
	if (isset($_SESSION[$sessionErrorName]) && count($_SESSION[$sessionErrorName]) > 0) {
		foreach ($_SESSION[$sessionErrorName] as $key => $value) {
			$output .= "
			<div class='alert alert-error'>
				<p>$value</p>
				<button type='button' onclick='this.parentElement.remove()'>&times;</button>
			</div>
			";

			unset($_SESSION[$sessionErrorName][$key]);
		}
	}

	$sessionSuccessName = "tp_zakville.success";
	if (isset($_SESSION[$sessionSuccessName]) && count($_SESSION[$sessionSuccessName]) > 0) {
		foreach ($_SESSION[$sessionSuccessName] as $key => $value) {
			$output .= "
			<div class='alert alert-success'>
				<p>$value</p>
				<button type='button' onclick='this.parentElement.remove()'>&times;</button>
			</div>
			";
			unset($_SESSION[$sessionSuccessName][$key]);
		}
	}

	return $output;
}

function notifyMessage(string $type, string $message, $redirectTo = ""): void
{
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}

	$sessionName = "tp_zakville." . $type;

	if (!isset($_SESSION[$sessionName])) {
		$_SESSION[$sessionName] = [];
	}

	$_SESSION[$sessionName][] = $message;

	if (empty(trim($redirectTo))) {
		$redirectTo = $_SERVER["HTTP_REFERER"];
	}

	header("Location: " . $redirectTo);
	exit();
}
