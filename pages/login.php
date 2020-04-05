<?php
session_start();

require_once '../core/config.php';
require_once '../helpers.php';

if(checkLoggedIn(false)){
    header('Location: ../index.php');
}

$error = '';

if(isset($_POST['login'])){
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;

    $sql = 'SELECT emp_id, emp_email, AES_DECRYPT(emp_password, "secret") as password FROM employee_personal WHERE emp_email = :email';
    
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':email', $_POST['email']);
    $statement->execute();
    
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if($user === false){
        $error = 'Incorrect email/password combination';
    }else{
        if($passwordAttempt === $user['password']){
            $userToken = bin2hex(openssl_random_pseudo_bytes(24));
            $_SESSION['user_id'] = $user['emp_id'];
            $_SESSION['user_token'] = $userToken;
            $_SESSION['logged_in'] = time();
            header('Location: ../index.php');
            exit;
        }else{
            $error = 'Incorrect email/password combination';
        }
    }

}
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel='stylesheet' href='../css/main.css' />
        <link rel='stylesheet' href='../css/background.css' />
    </head>
    <body>
        <img class='absolute bottom-0 right-0' src='../public/logo.png' />
        <main class='flex h-screen items-center justify-center my-auto'>
                <section class='flex flex-col px-4 py-2 bg-white shadow'>
                    <h1 class="mb-4 text-2xl text-blue-500 border-b border-blue-500">Login</h1>
                    <form id="login-form" class='flex flex-col' action="login.php" method="post">
                        <label class='mb-3' for="email">Email address</label>
                        <input class='mb-3 border text-lg' type="text" id="email" name="email">
                        <label class='mb-3' for="password">Password</label>
                        <input class='mb-3 border text-lg' class='mb-1' type="password" id="password" name="password">
                        <button class='p-2 mb-2 bg-blue-500 text-white hover:bg-blue-400' type="submit" name="login">Login</button>
                        <?php if(!empty($error)) echo htmlspecialchars($error); ?>
                    </form>
                </section>
        </main>
    </body>
</html>