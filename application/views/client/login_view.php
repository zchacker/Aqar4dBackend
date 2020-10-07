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
      <div class="form-row">
        <a href="<?=base_url()?>client/register" class="btn btn-warning btn-block" >الاشتراك بالموقع</a>
      </div>
    </form>
  </div>
</div>
