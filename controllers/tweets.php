<?php

global $link;

require '../functions.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // handle tweets logic
    switch ($action) {
        case "postTweet":
            // Collect and sanitize input
            $tweet = ValueExist($_POST['tweet']);
            $userId = UserId($_SESSION['user_id']);

            $errors = [];

            // Basic validation
            $errors[] = validateFields($tweet);

            $errors[] = lenValidate($tweet, 6, 160);

            $tweet = htmlspecialchars($tweet);

            if (empty($errors)) {
                // Register new user
                $stmt = mysqli_prepare($link, "INSERT INTO tweets (user_id, body) VALUES (?, ?)");
                mysqli_stmt_bind_param($stmt, "ss", $userId, $tweet);
                if (mysqli_stmt_execute($stmt)) {
                    echo "Tweet posted successful!";
                } else {
                    $errors[] = "Error during tweet posting. Please try again.";
                }
                mysqli_stmt_close($stmt);
            }

            // Display errors if any
            showErrors($errors);
            break;
        default:
            break;
    }
}