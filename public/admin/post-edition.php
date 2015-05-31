<?php

require_once(__DIR__ . '/../../bootstrap.php');

use \MyBlog\Posts\Post;
use \MyBlog\Posts\Factory as PostsFactory;
use \MyBlog\Utils\NavigationHelper;
use \MyBlog\Http\Request;
use MyBlog\Validation\ValidationErrorsCollection;
use MyBlog\Validation\HasValidationErrorsException;

$is_new_post = !isset($_GET['article_id']);
$posts_manager = PostsFactory::getPostsManager();
$navigation_helper = new NavigationHelper();

if ($is_new_post) {
    $post = new Post();
} else {
    $post = $posts_manager->getOnePostById($_GET['article_id']);
    if (!$post) {
        $navigation_helper->redirectClient('/admin');
    }
}

$validation_errors = new ValidationErrorsCollection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post'])) {
    if (isset($_POST['post']['title'])) {
        $post->setTitle($_POST['post']['title']);
    }

    if (isset($_POST['post']['slug'])) {
        $post->setSlug($_POST['post']['slug']);
    }

    if (isset($_POST['post']['content_short'])) {
        $post->setContentShort($_POST['post']['content_short']);
    }

    if (isset($_POST['post']['content'])) {
        $post->setContent($_POST['post']['content']);
    }

    $request = new Request();
    $uploaded_files = $request->getRequestFilesFromGlobals();

    if (isset($uploaded_files['post']['illustration_original'])) {
        $post->setUploadedIllustrationOriginal($uploaded_files['post']['illustration_original']);
    }

    if (isset($uploaded_files['post']['illustration_preview'])) {
        $post->setUploadedIllustrationPreview($uploaded_files['post']['illustration_preview']);
    }

    try {
        $posts_manager->validatePost($post);
        $posts_manager->savePost($post);
        $navigation_helper->redirectClient('/admin');
    } catch (HasValidationErrorsException $e) {
        $validation_errors = $e->getValidationErrorsCollection();
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
                <li><a href="/admin">Administration</a></li>
                <li class="active"><a href="/admin/post-edition.php">Ajouter un article</a></li>
                <li><a href="/">Déconnexion</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="page-content">
    <div class="container">
        <?php if ($is_new_post): ?>
            <h1>Ajout d'un nouvel article</h1>
        <?php else: ?>
            <h1>Modification d'un article</h1>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Méta-données</legend>

                <?php $errors = $validation_errors->getErrorsForField('title'); ?>
                <div class="form-group<?php if($errors): ?> has-error<?php endif; ?>">
                    <label for="title" class="control-label">Titre</label>
                    <?php if ($errors): ?>
                        <?php foreach ($errors as $error): ?>
                            <p class="text-danger"><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <input type="text" name="post[title]" id="title" class="form-control"
                           value="<?php echo $post->getTitle(); ?>"/>
                </div>

                <?php $errors = $validation_errors->getErrorsForField('slug'); ?>
                <div class="form-group<?php if($errors): ?> has-error<?php endif; ?>">
                    <label for="slug" class="control-label">Alias</label>
                    <?php if ($errors): ?>
                        <?php foreach ($errors as $error): ?>
                            <p class="text-danger"><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <input type="text" name="post[slug]" id="slug" class="form-control"
                           value="<?php echo $post->getSlug(); ?>"/>
                </div>
            </fieldset>
            <fieldset>
                <legend>Médias</legend>

                <?php $errors = $validation_errors->getErrorsForField('illustration_original'); ?>
                <div class="form-group<?php if($errors): ?> has-error<?php endif; ?>">
                    <label for="illustration_original" class="control-label">Illustration</label>
                    <?php if ($errors): ?>
                        <?php foreach ($errors as $error): ?>
                            <p class="text-danger"><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <input type="file" name="post[illustration_original]" id="illustration_original"/>
                </div>

                <?php $errors = $validation_errors->getErrorsForField('illustration_preview'); ?>
                <div class="form-group<?php if($errors): ?> has-error<?php endif; ?>">
                    <label for="illustration_preview" class="control-label">Prévisualisation de l'illustration</label>
                    <?php if ($errors): ?>
                        <?php foreach ($errors as $error): ?>
                            <p class="text-danger"><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <input type="file" name="post[illustration_preview]" id="illustration_preview"/>
                </div>
            </fieldset>
            <fieldset>
                <legend>Contenu</legend>

                <?php $errors = $validation_errors->getErrorsForField('content_short'); ?>
                <div class="form-group<?php if($errors): ?> has-error<?php endif; ?>">
                    <label for="content_short" class="control-label">Contenu (version courte)</label>
                    <?php if ($errors): ?>
                        <?php foreach ($errors as $error): ?>
                            <p class="text-danger"><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <textarea id="content_short" name="post[content_short]"
                              class="form-control"><?php echo $post->getContentShort(); ?></textarea>
                </div>

                <?php $errors = $validation_errors->getErrorsForField('content'); ?>
                <div class="form-group<?php if($errors): ?> has-error<?php endif; ?>">
                    <label for="content" class="control-label">Contenu</label>
                    <?php if ($errors): ?>
                        <?php foreach ($errors as $error): ?>
                            <p class="text-danger"><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <textarea id="content" name="post[content]"
                              class="form-control"><?php echo $post->getContent(); ?></textarea>
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
