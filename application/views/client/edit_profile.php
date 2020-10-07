<div class="row">
  <div class="col-md-12">
    <section class="page_content">
      <div class="add_entity_form">

        <h2>تعديل بياناتي</h2>
        <form class="" action="" method="post" enctype="multipart/form-data" onsubmit="return submitForm()">

          <div class="form-row ">
            <label for="title">الاسم</label>
            <input type="text" class="form-control" name="name" id="name" value="<?=$my_info->name;?>" required autocomplete="off" />
          </div>

          <div class="form-row">
            <label for="price">البريد الالكتروني</label>
            <input type="text" class="form-control" name="email" id="email" value="<?=$my_info->email;?>" required autocomplete="off" />
          </div>

          <div class="form-row">
            <label for="country">رقم الهاتف</label>
            <input type="text" class="form-control" name="phone" id="phone" value="<?=$my_info->phone;?>" required autocomplete="off" />
          </div>

          <div class="form-row">
            <button type="submit" id="submit_form" name="button" class="btn btn-success btn-block" >حفظ</button>
          </div>

        </form>
      </div>

    </section>
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
      //var submit = document.querySelector("#submit_form");
      $("#submit_form").attr("disabled", true);
      input.value = iti.getNumber();
      return true;
    }
  }

</script>
