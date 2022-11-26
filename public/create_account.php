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

// Handle create_account form submission.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the email and password from the form.
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email= $_POST['email'];
    $password = $_POST['password'];

    // Create an array of errors.
    $validationErrors = [];

    // Validate inputs (primitive).

    if (empty($firstName)) {
        $validationErrors[] = 'First name must not be empty.';
    }

    if (empty($lastName)) {
        $validationErrors[] = 'Last name must not be empty.';
    }

    if (empty($email)) {
        $validationErrors[] = 'Email must not be empty.';
    }

    if (empty($password)) {
        $validationErrors[] = 'Password must not be empty.';
    }

    // Return validation errors if any.
    if (count($validationErrors) > 0) {
        // redirect to the create account page with the errors
        header('Location: create_account.php?error=' . implode(',', $validationErrors));
        exit;
    }

    // Attempt to log in.

    try {
        $userService->create($firstName, $lastName, $email, $password);

        // Redirect to the index page.
        header('Location: index.php');
        exit;
    } catch (\Exception $e) {
        // Redirect to the create account page with the error.
        header('Location: create_account.php?error=' . $e->getMessage());
        exit;
    }
}

$head = new Head('Create Account');

?>

<html>
    <?php $head->render(); ?>
    <body>
        <div class="app">
            <div class="auth-container">
                <h1>Create an account</h1>

                <?php

                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    $errors = explode(',', $error);
                    foreach ($errors as $error) {
                        echo "<p class='error'>$error</p>";
                    }
                }

                ?>

                <form action="create_account.php" method="POST">
                    <input type="text" name="first_name" placeholder="First name" />
                    <input type="text" name="last_name" placeholder="Last name" />
                    <input type="email" name="email" placeholder="Email">
                    <input type="password" name="password" placeholder="Password">
                    <input type="submit" value="Create account">
                </form>

                <p>Already have an account? <a href="login.php">Log in!</a></p>
            </div>
        </div>
    </body>
</html>
