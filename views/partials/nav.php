<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="http://localhost/mvcframework-php/">Twitter</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        aria-current="page"
                        href="http://localhost/mvcframework-php/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=yourtweets">Your Tweets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=publicprofiles">Public Profiles</a>
                </li>
            </ul>
            <?php if (isset($_SESSION['user_id'])): ?>
                <form class="d-flex" method="POST" action="http://localhost/mvcframework-php/controllers/auth.php?action=logout">
                    <button class="btn btn-outline-success" type="submit">
                        Logout
                    </button>
                </form>
            <?php else: ?>
                <div class="d-flex">
                    <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#authModal">
                        Login/Sign up
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>