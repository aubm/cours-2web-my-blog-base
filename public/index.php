<?php
include('../posts_mocks.php');
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
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu-collapse">
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
                <div class="articles-list">
                    <div class="row">
                        <?php foreach($posts as $post): ?>
                            <div class="col-sm-4">
                                <article class="article-card">
                                    <div class="thumbnail">
                                        <div class="image-wrapper">
                                        <img src="images/thumbnails/<?php echo $post['illustration_preview']; ?>"/>
                                        </div>
                                        <div class="caption">
                                            <h3><?php echo $post['title']; ?></h3>
                                            <p><?php echo $post['content_short']; ?> ...</p>
                                            <p>
                                                <a href="/post-details.php" class="btn btn-primary" role="button">Lire la suite</a>
                                            </p>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
