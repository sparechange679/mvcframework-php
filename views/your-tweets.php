<!-- grid -->
<div class="container mt-5 text-center">
    <div class="row">
        <div class="col-7">
            <!-- tweet cards -->
            <?php
            $id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
            $result = tweets("yourtweets", $id);
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