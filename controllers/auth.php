<?php

global $link;

require '../functions.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        // Authentication logic
        case 'auth':
            // Collect and sanitize input
            $email = ValueExist($_POST['email']);
            $password = ValueExist($_POST['password']);
            $authValue = ValueExist($_POST['authValue']);

            $errors = [];

            // Basic validation
            if (empty($email) || empty($password) || $authValue === '') {
                $errors[] = "All fields are required.";
            }

            if (strlen($email) < 6) {
                $errors[] = "Your email must be at least 6 characters long.";
            }

            if (strlen($password) < 6) {
                $errors[] = "Your password must be at least 6 characters long.";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            }

            if (empty($errors)) {
                if ($authValue === '0') {
                    // Sign up
                    $stmt = WhereSelect("SELECT id FROM users WHERE email = ?", "s", $email);
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) > 0) {
                        $errors[] = "An account with this email already exists.";
                    } else {
                        // Register new user
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = mysqli_prepare($link, "INSERT INTO users (email, password) VALUES (?, ?)");
                        mysqli_stmt_bind_param($stmt, "ss", $email, $hashedPassword);
                        if (mysqli_stmt_execute($stmt)) {
                            $_SESSION['user_id'] = mysqli_insert_id($link);
                            echo "User Sign Up successful!";
                        } else {
                            $errors[] = "Error during registration. Please try again.";
                        }
                        mysqli_stmt_close($stmt);
                    }
                } elseif ($authValue === '1') {
                    // LOGIN PROCESS
                    $stmt = WhereSelect("SELECT id, password FROM users WHERE email = ?", "s", $email);
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $userId, $hashedPassword);
                        mysqli_stmt_fetch($stmt);

                        if (password_verify($password, $hashedPassword)) {
                            $_SESSION['user_id'] = $userId;
                            echo "Login successful!";
                        } else {
                            $errors[] = "Incorrect password.";
                        }
                    } else {
                        $errors[] = "No account found with that email.";
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $errors[] = "Invalid Authentication Value. Please try again.";
                }
            }

            // Display errors if any
            showErrors($errors);
            break;

        // Logout
        case 'logout':
            session_destroy();
            header('Location: http://localhost/mvcframework-php/');
            break;
        default:
            break;
    }
}