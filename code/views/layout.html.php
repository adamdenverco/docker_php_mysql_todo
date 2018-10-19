<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Todo PHP MySQL App</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css?v=<?=$setDevVersion?>" />
  </head>

  <body>

    <?php if (isThisDev()): ?>
      <section class="container">
        <div class="row">
          <div class="col">
            <div class="alert alert-info">
              <?=$devTopMessage?>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>

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
          <?php if (isThisDev()): ?>
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

  <script type="text/javascript" src="//use.fontawesome.com/f2f8c525f6.js"></script>
  <script type="text/javascript" src="//code.jquery.com/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="//code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
  <script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script type="module" src="/assets/js/main.js<?= $setDevVersion; ?>>"></script>

</html>
