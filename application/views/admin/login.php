<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=base_url()?>css/boot4/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>image-preview-uploader/image-uploader.css">
    <link rel="stylesheet" href="<?=base_url()?>fontawesome/css/all.css">
    <link rel="stylesheet" href="<?=base_url()?>phone-list-code/css/intlTelInput.css">
    <link rel="stylesheet" href="<?=base_url()?>css/main-style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">

    <script src="<?=base_url()?>js/boot4/jquery.min.js" charset="utf-8"></script>
    <script src="<?=base_url()?>js/boot4/bootstrap.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?=base_url()?>image-preview-uploader/image-uploader.js"></script>
    <title>تسجيل الدخول</title>

  </head>
  <body>
    <div class="container-fluid">
      <!-- main content of documnet -->
      <div class="row">
        <div class="register_form">
          <?=$msg?>
          <h2>تسجيل الدخول</h2>
          <!-- https://twitter.com/larraa2019/status/1183109555275874305 -->
          <form class="" action="" method="post">
            <div class="form-row">
              <label for="email">البريد الالكتروني</label>
              <input type="email" class="form-control" id="email" name="email" value="" autocomplete="no" />
            </div>
            <div class="form-row">
              <label for="pass">كلمة المرور</label>
              <input type="password" class="form-control" id="pass" name="pass" value="" autocomplete="no" />
            </div>
            <div class="form-row">
              <button type="submit" class="btn btn-success btn-block" name="button">الدخول إلى حسابك</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
