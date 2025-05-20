<?php

require 'functions.php';

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    require 'views/partials/head.php';
    require 'views/partials/nav.php';

    switch ($page) {
        case 'publicprofiles':
            require 'views/public-profiles.php';
            break;
        case 'yourtweets':
            require 'views/your-tweets.php';
            break;
        case 'search':
            require 'views/search.php';
            break;
        default:
            require 'views/home.php';
            break;
    }
} else {
    require 'views/partials/head.php';
    require 'views/partials/nav.php';
    require 'views/home.php';
}
require 'views/partials/footer.php';