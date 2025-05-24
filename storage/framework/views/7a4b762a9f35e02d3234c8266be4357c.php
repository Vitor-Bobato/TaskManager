<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent("title", "TaskManager"); ?></title>
    <link href="<?php echo e("assets/css/bootstrap.min.css"); ?>" rel="stylesheet" >

      <?php echo $__env->yieldContent("style"); ?>
  </head>
  <body class="d-flex align-items-center py-4 bg-body-tertiary">
    <div>
        <?php echo $__env->yieldContent("content"); ?>
    </div>
    <script src="<?php echo e(asset("assets/js/bootstrap.min.js")); ?>"></script>
  </body>
</html>
<?php /**PATH C:\Users\paulo\laravel\TaskManager\resources\views/layouts/default.blade.php ENDPATH**/ ?>