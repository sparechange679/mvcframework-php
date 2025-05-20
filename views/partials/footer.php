<div class="container">
    <footer
        class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 my-5 border-top">
        <div class="col mb-3">
            <p class="text-body-secondary">
                <a
                    href="http://localhost/mvcframework-php/"
                    class="d-flex align-items-center mb-3 link-body-emphasis text-decoration-none"
                    aria-label="Bootstrap">Twitter</a>
                &copy; 2025
            </p>
        </div>
        <div class="col mb-3"></div>
        <div class="col mb-3">
            <h5>Section</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="http://localhost/mvcframework-php/" class="nav-link p-0 text-body-secondary">Home</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="?page=yourtweets" class="nav-link p-0 text-body-secondary">Your Tweets</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="?page=publicprofiles" class="nav-link p-0 text-body-secondary">Public Profiles</a>
                </li>
            </ul>
        </div>
        <div class="col mb-3">
            <h5>Section</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="http://localhost/mvcframework-php/" class="nav-link p-0 text-body-secondary">Home</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="?page=yourtweets" class="nav-link p-0 text-body-secondary">Your Tweets</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="?page=publicprofiles" class="nav-link p-0 text-body-secondary">Public Profiles</a>
                </li>
            </ul>
        </div>
        <div class="col mb-3">
            <h5>Section</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="http://localhost/mvcframework-php/" class="nav-link p-0 text-body-secondary">Home</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="?page=yourtweets" class="nav-link p-0 text-body-secondary">Your Tweets</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="?page=publicprofiles" class="nav-link p-0 text-body-secondary">Public Profiles</a>
                </li>
            </ul>
        </div>
    </footer>
</div>

<?php
require 'modal-auth.php';
?>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        const modalTitle = $('#modalTitle');
        const authValue = $('#authValue');
        const authBtn = $('#authBtn');
        const toggleAuthBtn = $('#toggleAuthBtn');
        const successAlert = $('.alert-success');
        const errorAlert = $('.alert-danger');

        // Hide alerts initially
        successAlert.hide();
        errorAlert.hide();

        toggleAuthBtn.on('click', function (e) {
            e.preventDefault();
            if (authValue.val() === "1") {
                modalTitle.text('Sign Up');
                authValue.val(0);
                authBtn.text('Sign Up');
                toggleAuthBtn.text('Login');
            } else {
                modalTitle.text('Login');
                authValue.val(1);
                authBtn.text('Login');
                toggleAuthBtn.text('Sign Up');
            }
            // Hide alerts when toggling
            successAlert.hide();
            errorAlert.hide();
        });

        authBtn.click(function (e) {
            e.preventDefault();
            const email = $('#email').val();
            const password = $('#password').val();
            const authValueVal = $('#authValue').val();

            // Hide alerts before new request
            successAlert.hide();
            errorAlert.hide();

            if (email === '' || password === '') {
                errorAlert.text('All fields are required.').show();
                return;
            }

            $.ajax({
                url: 'http://localhost/mvcframework-php/controllers/auth.php?action=auth',
                type: 'POST',
                data: {
                    email: email,
                    password: password,
                    authValue: authValueVal
                },
                success: function (response) {
                    // Check for success or error in response
                    if (response.toLowerCase().includes('successful')) {
                        successAlert.html(response).show();
                        errorAlert.hide();

                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        errorAlert.html(response).show();
                        successAlert.hide();
                    }
                },
                error: function () {
                    errorAlert.text('An error occurred. Please try again.').show();
                    successAlert.hide();
                }
            });
        });

        // tweet posting
        const tweetBtn = $("#tweetBtn");
        const tweet = $("#tweet");
        const tweetSuccessAlert = $('.tweet-success');
        const tweetErrorAlert = $('.tweet-danger');

        tweetBtn.click(function () {
            // Hide alerts before new request
            tweetSuccessAlert.hide();
            tweetErrorAlert.hide();

            if (tweet.val() === '') {
                errorAlert.text('Please write a tweet to post.').show();
                return;
            }

            $.ajax({
                url: 'http://localhost/mvcframework-php/controllers/tweets.php?action=postTweet',
                type: 'POST',
                data: {
                    tweet: tweet.val()
                },
                success: function (response) {
                    // Check for success or error in response
                    if (response.toLowerCase().includes('successful')) {
                        tweetSuccessAlert.html(response).show();
                        tweetErrorAlert.hide();

                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        tweetErrorAlert.html(response).show();
                        tweetSuccessAlert.hide();
                    }
                },
                error: function () {
                    tweetErrorAlert.text('An error occurred when posting your tweet. Please try again.').show();
                    tweetSuccessAlert.hide();
                }
            });
        });

        const followBtn = $(".follow-btn");
        followBtn.click(function () {
            alert("hi there!");
        });
    });
</script>
</body>

</html>