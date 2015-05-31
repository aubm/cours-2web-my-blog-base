<?php

require_once(__DIR__ . '/../../bootstrap.php');

$posts_manager = \MyBlog\Posts\Factory::getPostsManager();
$posts = $posts_manager->getAllPosts();
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
<nav class="navbar navbar-inverse navbar-fixed-top main-navbar">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#main-menu-collapse">
                <span class="sr-only">Activer la navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/admin" class="navbar-brand">Mon blog - Administration</a>
        </div>
        <div class="collapse navbar-collapse" id="main-menu-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/admin">Administration</a></li>
                <li><a href="/admin/post-edition.php">Ajouter un article</a></li>
                <li><a href="/">Déconnexion</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="page-content">
    <div class="container">
        <table class="table table-condensed table-hover table-vertical-center">
            <thead>
            <tr>
                <th>Titre</th>
                <th>Alias</th>
                <th>Contenu</th>
                <th>Date de publication</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><a href="/admin/post-edition.php?article_id=<?php echo $post->getId(); ?>">
                            <?php echo $post->getTitle(); ?></a></td>
                    <td><?php echo $post->getSlug(); ?></td>
                    <td><?php echo $post->getContentShort(); ?> ...</td>
                    <td><?php echo $post->getPublishedAt(); ?></td>
                    <td>
                        <form method="post" action="/admin/delete-post.php">
                            <input type="hidden" name="post_id" value="<?php echo $post->getId(); ?>"/>
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
