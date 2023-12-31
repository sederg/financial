<?php
use yii\bootstrap4\Alert;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Analisis Económico | Entrar</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../frontend\web\css\font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../frontend/web//dist/css/adminlte.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../frontend/web/plugins/iCheck/square/blue.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <link rel="shortcut icon" href="<?=Yii::$app->urlManager->baseUrl.'/images/analisis_ico1.png'?>"></head>
<body class="hold-transition login-page">
  <div class="container">
       
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
<!-- jQuery -->
<script src="../../frontend/web/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../frontend/web/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- iCheck -->
<script src="../../frontend/web/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass   : 'iradio_square-blue',
      increaseArea : '20%' // optional
    })
  })
</script>
</body>
</html>
