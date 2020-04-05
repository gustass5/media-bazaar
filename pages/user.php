<?php

session_start();

require '../helpers.php';

checkLoggedIn();

$fetchUserDataSql = 'SELECT emp_id, emp_first_name, emp_last_name FROM employee WHERE emp_id=:user_id';
$fetchUserAddressSql = 'SELECT emp_id, emp_street, emp_house_number, emp_postcode, emp_city FROM employee_address WHERE emp_id=:user_id';
$fetchUserPersonalSql = 'SELECT emp_id, emp_email, emp_phone_number, AES_DECRYPT(emp_password, "secret") as password FROM employee_personal WHERE emp_id=:user_id';

$userName = fetchUserData($_SESSION['user_id'], $fetchUserDataSql);
$userAddress = fetchUserData($_SESSION['user_id'], $fetchUserAddressSql);
$userPersonal = fetchUserData($_SESSION['user_id'], $fetchUserPersonalSql);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>User</title>
    <link rel='stylesheet' href='../css/main.css' />
</head>
    <body>
        <nav class='flex items-center justify-end mb-12 h-16 bg-blue-400 shadow-xl text-white'>
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

        <main class='flex items-center justify-center'>
            <section class='flex flex-col px-12 py-6 bg-white shadow w-1/2'>
                <h1 class="mb-6 text-2xl text-blue-500 border-b border-blue-500">Your information</h1>
                
                <form id="user-form" class='flex flex-col' action="user.php" method="post">
                    <label class='mb-2 font-bold' for="first-name">First name</label>
                    <div id='first-name-field' class='mb-2 cursor-pointer ' onClick="enableFieldEdit(this.id)">
                        <div class='flex items-baseline justify-between'>
                            <?php echo htmlspecialchars($userName['emp_first_name']) ?>

                            <svg class='h-4 text-blue-500' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path class='fill-current' d="M19.769 9.923l-12.642 12.639-7.127 1.438 1.438-7.128 12.641-12.64 5.69 5.691zm1.414-1.414l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z"/>
                            </svg>
                        </div>
                        <input class='mb-2 border text-lg hidden w-full' type="text" id="first-name" name="first-name" value="<?php echo htmlspecialchars($userName['emp_first_name']) ?>">
                    </div>
                    <label class='mb-2 font-bold' for="last-name">Last name</label>
                   
                    <div id='last-name-field' class='mb-2 cursor-pointer ' onClick="enableFieldEdit(this.id)">
                        <div class='flex items-baseline justify-between'>
                            <?php echo htmlspecialchars($userName['emp_last_name']) ?>

                            <svg class='h-4 text-blue-500' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path class='fill-current' d="M19.769 9.923l-12.642 12.639-7.127 1.438 1.438-7.128 12.641-12.64 5.69 5.691zm1.414-1.414l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z"/>
                            </svg>
                        </div>
                        <input class='mb-2 border text-lg hidden w-full' type="text" id="last-name" name="last-name" value="<?php echo htmlspecialchars($userName['emp_last_name']) ?>">
                    </div>

                    <h2 class="mb-6 text-2xl text-blue-500 border-b border-blue-500">Address</h2>
                    
                    <label class='mb-2 font-bold' for="street">Street name</label>
                    <div id='street-field' class='mb-2 cursor-pointer ' onClick="enableFieldEdit(this.id)">
                        <div class='flex items-baseline justify-between'>
                            <?php echo htmlspecialchars($userAddress['emp_street']) ?>

                            <svg class='h-4 text-blue-500' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path class='fill-current' d="M19.769 9.923l-12.642 12.639-7.127 1.438 1.438-7.128 12.641-12.64 5.69 5.691zm1.414-1.414l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z"/>
                            </svg>
                        </div>
                        <input class='mb-2 border text-lg hidden w-full' type="text" id="street" name="street" value="<?php echo htmlspecialchars($userAddress['emp_street']) ?>">
                    </div>


                    <label class='mb-2 font-bold' for="house-number">House number</label>
                    <div id='house-number-field' class='mb-2 cursor-pointer ' onClick="enableFieldEdit(this.id)">
                        <div class='flex items-baseline justify-between'>
                            <?php echo htmlspecialchars($userAddress['emp_house_number']) ?>

                            <svg class='h-4 text-blue-500' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path class='fill-current' d="M19.769 9.923l-12.642 12.639-7.127 1.438 1.438-7.128 12.641-12.64 5.69 5.691zm1.414-1.414l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z"/>
                            </svg>
                        </div>
                        <input class='mb-2 border text-lg hidden w-full' type="text" id="house-number" name="house-number" value="<?php echo htmlspecialchars($userAddress['emp_house_number']) ?>">
                    </div>

                    <label class='mb-2 font-bold' for="postcode">Postcode</label>
                    <div id='postcode-field' class='mb-2 cursor-pointer ' onClick="enableFieldEdit(this.id)">
                        <div class='flex items-baseline justify-between'>
                            <?php echo htmlspecialchars($userAddress['emp_postcode']) ?>

                            <svg class='h-4 text-blue-500' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path class='fill-current' d="M19.769 9.923l-12.642 12.639-7.127 1.438 1.438-7.128 12.641-12.64 5.69 5.691zm1.414-1.414l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z"/>
                            </svg>
                        </div>
                        <input class='mb-2 border text-lg hidden w-full' type="text" id="postcode" name="postcode" value="<?php echo htmlspecialchars($userAddress['emp_postcode']) ?>">
                    </div>

                    <label class='mb-2 font-bold' for="city">City</label>
                    <div id='city-field' class='mb-2 cursor-pointer ' onClick="enableFieldEdit(this.id)">
                        <div class='flex items-baseline justify-between'>
                            <?php echo htmlspecialchars($userAddress['emp_city']) ?>

                            <svg class='h-4 text-blue-500' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path class='fill-current' d="M19.769 9.923l-12.642 12.639-7.127 1.438 1.438-7.128 12.641-12.64 5.69 5.691zm1.414-1.414l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z"/>
                            </svg>
                        </div>
                        <input class='mb-2 border text-lg hidden w-full' type="text" id="city" name="city" value="<?php echo htmlspecialchars($userAddress['emp_city']) ?>">
                    </div>
                    
                    <h2 class="mb-6 text-2xl text-blue-500 border-b border-blue-500">Personal information</h2>
                    
                    <label class='mb-2 font-bold' for="email">Email address</label>
                    <div id='email-field' class='mb-2 cursor-pointer ' onClick="enableFieldEdit(this.id)">
                        <div class='flex items-baseline justify-between'>
                            <?php echo htmlspecialchars($userPersonal['emp_email']) ?>

                            <svg class='h-4 text-blue-500' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path class='fill-current' d="M19.769 9.923l-12.642 12.639-7.127 1.438 1.438-7.128 12.641-12.64 5.69 5.691zm1.414-1.414l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z"/>
                            </svg>
                        </div>
                        <input class='mb-2 border text-lg hidden w-full' type="text" id="email" name="email" value="<?php echo htmlspecialchars($userPersonal['emp_email']) ?>">
                    </div>

                    <label class='mb-2 font-bold' for="phone">Phone number</label>
                    <div id='phone-field' class='mb-6 cursor-pointer ' onClick="enableFieldEdit(this.id)">
                        <div class='flex items-baseline justify-between'>
                            <?php echo htmlspecialchars($userPersonal['emp_phone_number']) ?>

                            <svg class='h-4 text-blue-500' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path class='fill-current' d="M19.769 9.923l-12.642 12.639-7.127 1.438 1.438-7.128 12.641-12.64 5.69 5.691zm1.414-1.414l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z"/>
                            </svg>
                        </div>
                        <input class='mb-4 border text-lg hidden w-full' type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($userPersonal['emp_phone_number']) ?>">
                    </div>

                    <button class='p-1 bg-blue-500 text-white hover:bg-blue-400' type="submit" name="login">Update</button>
                </form>
            </section>
        </main>
        <script src='../js/user.js'></script>
    </body>
</html>