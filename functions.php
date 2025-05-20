<?php
session_start();

$config = require 'config.php';

$link = mysqli_connect("{$config['hostname']}", "{$config['username']}", "{$config['password']}", "{$config['database']}");

if (!$link) {
    echo "Error: Unable to connect to MySQL.";
}

function lenValidate($condition, $min = 1, $max = INF)
{
    $errors = "";
    if (strlen($condition) > $min || strlen($condition) < $max) {
        $errors = "Your Tweet cannot be less than {$min} but not more than {$max} characters long.";
    }

    return $errors;
}

function validateFields($condition)
{
    $errors = "";
    if (empty($condition)) {
        $errors = $condition . " is required.";
    }
    return $errors;
}

function showErrors($errors)
{
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error;
        }
    }
}

function UserId($value)
{
    return isset($value) ? $value : 0;
}

function ValueExist($value)
{
    return isset($value) ? trim($value) : '';
}

function ValidateEmail($email)
{
    $errors = '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors = "Invalid email format.";
    }
    return $errors;
}

function WhereSelect($query, $type, $variable)
{
    global $link;
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, $type, $variable);
    mysqli_stmt_execute($stmt);

    return $stmt;
}

//display search box for tweet searches
function search()
{
    echo '<form class="row g-3">
                <label for="search"><input type="hidden" value="search" id="page" name="page"></label>
                <div class="col-md-6">
                    <label for="q"><input type="text" class="form-control" id="q" name="q"></label>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>';
}

//display tweet form to post tweets
function postTweetForm()
{
    echo '<form class="row g-3">
                <div class="alert alert-success tweet-success" role="alert"></div>
                <div class="alert alert-danger tweet-danger" role="alert"></div>
                <div class="col-12">
                    <label for="tweet"></label>
                    <textarea class="form-control" style="resize: none" id="tweet" cols="5"
                              rows="10"
                              name="tweet"></textarea>
                </div>
                <div class="col-12">
                    <button type="button" class="btn btn-primary" id="tweetBtn">Post Tweet</button>
                </div>
            </form>';
}

//retrieve tweets on the page
function tweets($type, $params = null)
{
    global $link;

    $select = "SELECT * FROM tweets";
    $whereClause = "";
    $orderByClause = "ORDER BY id DESC";

    switch ($type) {
        case 'all':
            //$select = "";
            break;
        case 'search':
            if ($params === null) {
                return null;
            }

            $whereClause = "WHERE body LIKE '%{$params}%'";
            break;
        case 'yourtweets':
            if ($params === null) {
                return null;
            }

            $params = mysqli_real_escape_string($link, $params);
            $whereClause = "WHERE user_id = " . $params;
            break;
        default:
            break;
    }

    $stmt = mysqli_query($link, $select . ' ' . $whereClause . ' ' . $orderByClause);

    if (mysqli_num_rows($stmt) == 0) {
        echo "There are no Tweets yet.";
    }
    return $stmt;
}

//get users
function users($type, $params = null)
{
    global $link;

    $select = "SELECT * FROM users";
    $whereClause = "";
    $orderByClause = "ORDER BY id DESC";

    switch ($type) {
        case 'all':
            //$select = "";
            break;
        case 'show':
            if ($params === null) {
                return null;
            }

            $params = mysqli_real_escape_string($link, $params);
            $whereClause = "WHERE id = " . $params;
            break;
        default:
            break;
    }

    $stmt = mysqli_query($link, $select . ' ' . $whereClause . ' ' . $orderByClause);

    if (mysqli_num_rows($stmt) == 0) {
        echo "There are no Users yet.";
    }
    return $stmt;
}

//display tweets to user
function displayTweets($stmt)
{
    global $link;

    while ($row = mysqli_fetch_assoc($stmt)) {
        $userStmt = "SELECT email FROM users WHERE id = " . $row['user_id'];
        $userQuery = mysqli_query($link, $userStmt);
        $user = mysqli_fetch_assoc($userQuery);
        $userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

        echo '<div class="card mb-3 ">
            <div class="card-body">
                <h5 class="card-title"><a href="?page=publicprofiles&id=' . $row["user_id"] . '">' . $user["email"] . '</a></h5>
                <p class="card-text">' . $row["body"] . '<em> 1min ago</em></p>
                ';
        if ($userId != $row["user_id"]):
            echo '<button type="button" data-userId="' . $row["user_id"] . '" class="btn btn-primary follow-btn">Follow</button>';
        endif;
        echo '</div>
        </div>';
    }
}

//display users
function displayUsers($stmt)
{
    while ($row = mysqli_fetch_assoc($stmt)) {
        echo '<div class="card mb-3 ">
            <div class="card-body">
                <h5 class="card-title"><a href="?page=publicprofiles&id=' . $row["id"] . '">' . $row["email"] . '</a></h5>
            </div>
        </div>';
    }
}

//display tweets for users
function displayUserTweets($stmt)
{
    global $link;
    $row = mysqli_fetch_assoc($stmt);
    $userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
    $tweetStmt = "SELECT body FROM tweets WHERE user_id = " . $row['id'];
    $tweet = mysqli_query($link, $tweetStmt);

    if (mysqli_num_rows($tweet) == 0) {
        echo "There are no Tweets for this User yet.";
    }

    while ($res = mysqli_fetch_assoc($tweet)) {
        echo '<div class="card mb-3 ">
            <div class="card-body">
                <h5 class="card-title">' . $row["email"] . '</h5>
                <p class="card-text">' . $res["body"] . '<em> 1min ago</em></p>
                ';
        if ($userId != $row["id"]):
            echo '<button type="button" data-userId="' . $row["id"] . '" class="btn btn-primary follow-btn">Follow</button>';
        endif;
        echo '</div>
        </div>';
    }
}