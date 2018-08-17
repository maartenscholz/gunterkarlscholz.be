<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
        <?php if ($debugBar): ?>
            <link rel="stylesheet" href="/debugbar/css">
        <?php endif; ?>
        <title><?= $title ? $this->e($title).' | ' : '' ?>GKS</title>
    </head>
    <body>

        <?php if ($authenticated): ?>
            <?= $this->fetch('admin::_navigation') ?>
        <?php endif; ?>

        <div class="container">
            <div class="row">
                <div class="col s12">
                    <?= $this->section('content') ?>
                </div>
            </div>
        </div>

        <script
                src="https://code.jquery.com/jquery-3.3.1.min.js"
                integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
        <?php if ($debugBar): ?>
            <script type="text/javascript" src="/debugbar/js"></script>
            <script type="text/javascript">jQuery.noConflict(true);</script>
            <?= $debugBar->render() ?>
        <?php endif; ?>
        <script>
            $(document).ready(function(){
                $('.sidenav').sidenav();
                $('.input-field select').formSelect();
                $('table .dropdown-trigger').dropdown({
                    constrainWidth: false,
                    alignment: 'right',
                });
            });
        </script>
    </body>
</html>
