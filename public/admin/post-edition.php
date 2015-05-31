<?php

require_once(__DIR__ . '/../../bootstrap.php');

use \MyBlog\Posts\Post;
use \MyBlog\Posts\Factory as PostsFactory;
use \MyBlog\Utils\NavigationHelper;
use \MyBlog\Http\Request;

$is_new_post = !isset($_GET['article_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post'])) {
    $request = new Request();
    $navigation_helper = new NavigationHelper();
    $posts_manager = PostsFactory::getPostsManager();
    if ($is_new_post) {
        $post = new Post($_POST['post']);

        $uploaded_files = $request->getRequestFilesFromGlobals();

        if (isset($uploaded_files['post']['illustration_original'])) {
            $post->setUploadedIllustrationOriginal($uploaded_files['post']['illustration_original']);
        }

        if (isset($uploaded_files['post']['illustration_preview'])) {
            $post->setUploadedIllustrationPreview($uploaded_files['post']['illustration_preview']);
        }

        $posts_manager->savePost($post);
        $navigation_helper->redirectClient('/admin');
    }
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
        <nav class="navbar navbar-inverse navbar-fixed-top main-navbar">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu-collapse">
                        <span class="sr-only">Activer la navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="/admin" class="navbar-brand">Mon blog - Administration</a>
                </div>
                <div class="collapse navbar-collapse" id="main-menu-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="/admin">Administration</a></li>
                        <li class="active"><a href="/admin/post-edition.php">Ajouter un article</a></li>
                        <li><a href="/">Déconnexion</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="page-content">
            <div class="container">
                <?php if($is_new_post): ?>
                    <h1>Ajout d'un nouvel article</h1>
                <?php else: ?>
                    <h1>Modification d'un article</h1>
                <?php endif; ?>
                <form method="post" enctype="multipart/form-data">
                    <fieldset>
                        <legend>Méta-données</legend>
                        <div class="form-group">
                            <label for="title">Titre</label>
                            <input type="text" name="post[title]" id="title" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="slug">Alias</label>
                            <input type="text" name="post[slug]" id="slug" class="form-control"/>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Médias</legend>
                        <div class="form-group">
                            <label for="illustration_original">Illustration</label>
                            <input type="file" name="post[illustration_original]" id="illustration_original"/>
                        </div>
                        <div class="form-group">
                            <label for="illustration_preview">Prévisualisation de l'illustration</label>
                            <input type="file" name="post[illustration_preview]" id="illustration_preview"/>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Contenu</legend>
                        <div class="form-group">
                            <label for="content_short">Contenu (version courte)</label>
                            <textarea id="content_short" name="post[content_short]" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="content">Contenu</label>
                            <textarea id="content" name="post[content]" class="form-control"></textarea>
                        </div>
                    </fieldset>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
