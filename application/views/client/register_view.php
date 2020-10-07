<!-- main content of documnet -->
<div class="row">
  <div class="register_form">
    <h2>الاشتراك بالموقع</h2>
    <?=@$msg?>

    <!-- to get document about country list from github -->
    <!-- https://github.com/jackocnr/intl-tel-input -->
    <!-- https://twitter.com/larraa2019/status/1183109555275874305 -->
    <form class="" action="" method="post" onsubmit="return submitForm()">
      <div class="form-row">
        <label for="name">الاسم</label>
        <input type="text" class="form-control" id="name" name="name" value="<?=@$_POST['name']?>" required />
      </div>

      <div class="form-row">
        <div class="row">
          <div class="col-md-12">
            <label for="phone">رقم الهاتف</label>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="tel" class="form-control" id="phone" name="phone" value="<?=@$_POST['phone']?>" required />
          </div>
        </div>
      </div>

      <div class="form-row">
        <label for="email">البريد الالكتروني</label>
        <input type="email" class="form-control" id="email" name="email" value="<?=@$_POST['email']?>"  required />
      </div>

      <div class="form-row">
        <label for="pass1">كلمة المرور</label>
        <input type="password" class="form-control" id="pass1" name="pass1" value="" autocomplete="no" required />
      </div>

      <div class="form-row">
        <label for="pass2">تأكيد كلمة المرور</label>
        <input type="password" class="form-control" id="pass2" name="pass2" value="" autocomplete="no"  required />
      </div>

      <div class="form-row">
        <button type="submit" class="btn btn-success btn-block" onclick="" name="button">الاشتراك بالموقع</button>
      </div>


      <div class="form-row">
        <a href="<?=base_url()?>client/login" class="btn btn-warning btn-block" >تسجل الدخول إلى حسابك</a>
      </div>

    </form>
  </div>
</div>


<script src="<?=base_url()?>phone-list-code/js/intlTelInput.js"></script>
<script>
  var input = document.querySelector("#phone");
  var iti = window.intlTelInput(input,{
    utilsScript: "<?=base_url()?>phone-list-code/js/utils.js?1570635132854" // just for formatting/placeholders etc
  });


  function submitForm() {
    var valid = iti.isValidNumber();
    if(!valid){
      alert("لقد أدخلت رقم هاتف غير صحيح");
      return false;
    }else{
      var input = document.querySelector("#phone");
      input.value = iti.getNumber();
      return true;
    }
  }

</script>
