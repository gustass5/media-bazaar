<?php

session_start();

require '../helpers.php';

checkLoggedIn();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <title>Schedule</title>
        <link rel='stylesheet' href='../css/main.css' />
    </head>
    <body>
        <nav class='flex items-center justify-end h-16 bg-blue-400 shadow-xl text-white'>
            <ul class='flex'>
                <a href="../index.php">
                    <li class='mx-3 cursor-pointer'>Home</li>
                </a>
                <a href="schedule.php">
                    <li class='mx-3 cursor-pointer'>Schedule</li>
                </a>
                <a href='user.php'>
                    <li>
                        <svg class='mx-3 h-6' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path class='fill-current' d="M20.822 18.096c-3.439-.794-6.64-1.49-5.09-4.418 4.72-8.912 1.251-13.678-3.732-13.678-5.082 0-8.464 4.949-3.732 13.678 1.597 2.945-1.725 3.641-5.09 4.418-3.073.71-3.188 2.236-3.178 4.904l.004 1h23.99l.004-.969c.012-2.688-.092-4.222-3.176-4.935z"/>
                        </svg>
                    </li>
                </a>
                <a href="../api/logout.php?token=<?= $_SESSION['user_token']?>">
                    <li class='mx-3 cursor-pointer'>Logout</li>
                </a>
            </ul>
        </nav>
    </body>
</html>