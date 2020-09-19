<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" type="text/css"
              href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css">
        <link rel="stylesheet" href="/css/app.css">
        <title><?= $title ? $this->e($title).' | ' : '' ?>GKS</title>
    </head>
    <body>
        <div class="container">
            <header>
                <h1>Günter-Karl Scholz</h1>
                <nav>
                    <ul>
                        <li><a href="/portfolio">Portfolio</a></li>
                        <li><a href="/about">About</a></li>
                    </ul>
                </nav>
            </header>
            <main>
                <?= $this->section('content') ?>
            </main>
            <footer>
                &copy; gunterkarlscholz.be <?= date('Y') ?>
            </footer>
        </div>
    </body>
</html>
