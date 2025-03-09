<?php
require "./assets/function/authentificatione.php"
?>

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


   <style>
    a {
        color: white;
        font-size: 45px;
        text-shadow:  2px 2px 1px black;
        
        
        &:hover{
            color: orangered;
        }
    }
    
    li{
        list-style: none;

    }
   </style>

    <header>
        <nav>

            


            <ul>
             
                <li  <?php if($nav = "profile"): ?>active<?php endif ?>">
                    <a href="profile.php">PROFILE</a>
                </li>

               
                <li  <?php if ($nav = "home"): ?> active <?php endif ?>">
                    <a href="index.php">HOME </a>
                </li>
                             
                <?php if(!is_connected()): ?>
                <li  <?php if ($nav = "login"): ?> active <?php endif ?>">
                    <a href="login.php">LOGIN </a>
                </li>
                <?php else: ?>
                <li  <?php if ($nav = "logout"): ?> active <?php endif ?>">
                    <a href="logout.php">LOGOUT </a>
                </li>
                <?php endif; ?>
                
                
            </ul>

        </nav>
    </header>




<br>
<br>

    </div>

</body>

</html>