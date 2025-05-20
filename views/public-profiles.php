<!-- grid -->
<div class="container mt-5 text-center">
    <div class="row">
        <div class="col-7">
            <!-- tweet cards -->
            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $result = users("show", $id);
                displayUserTweets($result);
            } else {

                $result = users("all");

                displayUsers($result);
            }
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