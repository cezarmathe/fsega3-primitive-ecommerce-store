<?php

namespace ECommerce\Public;

require_once __DIR__ . '/../vendor/autoload.php';

use ECommerce\App\Repository\UsersRepository;
use ECommerce\App\Service\UsersService;
use ECommerce\App\Components\Head;

session_start();

$repository = new UsersRepository();
$userService = new UsersService($repository);

if (UsersService::isLoggedIn()) {
    header('Location: index.php');
    exit();
}

// Handle login form submission.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the email and password from the form.
    $email= $_POST['email'];
    $password = $_POST['password'];

    // Create an array of errors.
    $validationErrors = [];

    // Validate inputs (primitive).

    if (empty($email)) {
        $validationErrors[] = 'Email must not be empty.';
    }

    if (empty($password)) {
        $validationErrors[] = 'Password must not be empty.';
    }

    // Return validation errors if any.
    if (count($validationErrors) > 0) {
        // redirect to the login page with the errors
        header('Location: login.php?error=' . implode(',', $validationErrors));
        exit;
    }

    // Attempt to log in.

    try {
        $userService->login($email, $password);

        // Redirect to the index page.
        header('Location: index.php');
        exit;
    } catch (\Exception $e) {
        // Redirect to the login page with the error.
        header('Location: login.php?error=' . $e->getMessage());
        exit;
    }
}

$head = new Head('Log in');

?>

<html>
    <?php echo $head->render(); ?>
    <body>
        <div class="app">
            <div class="auth-container">
                <h1>Login</h1>

                <?php

                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    $errors = explode(',', $error);
                    foreach ($errors as $error) {
                        echo "<p class='error'>$error</p>";
                    }
                }

                ?>

                <form action="login.php" method="POST">
                    <input type="email" name="email" placeholder="Email">
                    <input type="password" name="password" placeholder="Password">
                    <input type="submit" value="Login">
                </form>

                <p>Don't have an account? <a href="create_account.php">Create an account!</a></p>
            </div>
        </div>
    </body>
</html>
