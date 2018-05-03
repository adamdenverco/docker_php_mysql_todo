<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Todo PHP MySQL App</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
        <link rel="stylesheet" type="text/css" href="/assets/css/style.css?v=<?=time();?>" />
        <script src="https://use.fontawesome.com/f2f8c525f6.js"></script>
    </head>

    <body>

        <header class="container">
            <div class="row">
                <div class="col">
                    <h1>Todo PHP MySQL App</h1>
                </div>
            </div>
        </header>

        <nav class="container ">
            <div class="row">
                <div class="col">
                    <a href="/" class="<?php echo ($urlSegmentSection == 'todo') ? 'nav-active' : ''; ?>">Todo</a> 
                    | <a href="/todoinfo" class="<?php echo ($urlSegmentSection == 'todoinfo') ? 'nav-active' : ''; ?>">Todo Info</a> 
                    <?php if ($_SERVER['HTTP_HOST'] == 'localhost'): ?>
                        | <a href="http://localhost:8080/" target="_blank">phpMyAdmin</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="small-text">
                        <em>Your user data is associated with your IP address <strong><?=IP_USER_ADDRESS;?></strong></em>
                    </div>
                </div>
            </div>
        </div>

        <main class="container">
            <div class="row">
                <div class="col">
                    <?=$output?>
                </div>
            </div>
        </main>

        <footer class="container">
            <div class="row">
                <div class="col">
                    &copy; <?=date('Y')?> Todo PHP MySQL App 
                </div>
            </div>
        </footer>

    </body>

</html>
