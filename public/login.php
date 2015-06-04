<?php
include('../bootstrap.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authentication_helper = \MyBlog\Security\Factory::getAuthenticationHelper();
    $navigation_helper = new \MyBlog\Utils\NavigationHelper();
    if ($authentication_helper->authenticate($_POST['username'], $_POST['password'])) {
        $navigation_helper->redirectClient('admin/index.php');
    } else {
        $error = 'Nom d\'utilisation ou mot de passe incorrect';
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
                <li><a href="/index.php">Accueil</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="page-content">
    <div class="container">
        <form method="post">
            <?php if(isset($error)): ?>
                <p class="text-danger">
                    <?= $error ?>
                </p>
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Nom d'utilisation</label>
                <input type="text" id="username" name="username" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-control"/>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
