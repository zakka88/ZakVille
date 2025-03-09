<?php

session_start();
session_destroy();

header("Location: ./login-simulation.php");
exit();
