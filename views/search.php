<!-- grid -->
<div class="container mt-5 text-center">
    <div class="row">
        <div class="col-7">
            <!-- tweet cards -->

            <?php
            $q = UserId($_GET['q']);
            echo '<h1 class="mb-5">Search Results for: <strong>"'.$q.'"</strong></h1>';
            $result = tweets("search", $q);
            displayTweets($result);
            ?>
        </div>
        <div class="col-3">
            <?php
            search();

            echo "<hr>";

            if (isset($_SESSION['user_id'])):
                postTweetForm();
            endif;
            ?>
        </div>
    </div>
</div>