<?php
include('../services/posts_manager.php');

$post = null;
$url_post_slug = null;
if (isset($_GET['postSlug'])) {
    $url_post_slug = $_GET['postSlug'];
}

if ($url_post_slug !== null) {
    $post = getOnePostBySlug($_GET['postSlug']);
}

if ($post === null) {
    header("Location: index.php");
    exit();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="/dist/app.min.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/dist/jquery.min.js"></script>
    <script type="text/javascript" src="/dist/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top main-navbar">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#main-menu-collapse">
                <span class="sr-only">Activer la navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-brand">Mon blog</a>
        </div>
        <div class="collapse navbar-collapse" id="main-menu-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/index.php">Accueil</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="page-content">
    <div class="container">
        <article class="text-justify">
            <header class="details-header-image">
                <img src="images/originals/<?php echo $post['illustration_original']; ?>" class="img-responsive"/>
            </header>
            <h1><?php echo $post['title']; ?></h1>
            <section>
                <p><?php echo $post['content']; ?></p>
            </section>
        </article>
    </div>
</div>
</body>
</html>
