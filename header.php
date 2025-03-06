



<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> <?php

if (isset($title)):
    echo $title;
else:
    echo "newsite";
    
endif;

?> </title>
    <link rel="stylesheet" href="./assets//styles//main.css">
</head>

<body>

    <header>
        <nav>

            <h1>ville</h1>


            <ul>
             
                <li  <?php if($nav = "profile"): ?>active<?php endif ?>">
                    <a href="profile.php">PROFILE</a>
                </li>

               
                <li  <?php if ($nav = "home"): ?> active <?php endif ?>">
                    <a href="index.php">HOME </a>
                </li>
                             
            
                <li  <?php if ($nav = "login"): ?> active <?php endif ?>">
                    <a href="login.php">LOGIN </a>
                </li>
                
                
                
            </ul>

        </nav>
    </header>




<br>
<br>

    </div>

</body>

</html>