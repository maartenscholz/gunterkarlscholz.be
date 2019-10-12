<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" type="text/css"
              href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css">
        <link rel="stylesheet" href="css/app.css">
        <title><?= $title ? $this->e($title).' | ' : '' ?>GKS</title>
    </head>
    <body>
        <div class="container">
            <aside>
                <ul>
                    <li><a href="/portfolio">Portfolio</a></li>
                </ul>
            </aside>
            <main>
                <?= $this->section('content') ?>
            </main>
        </div>
    </body>
</html>
