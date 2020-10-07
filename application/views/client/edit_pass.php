<div class="row">
  <div class="col-md-12">
    <section class="page_content">
      <div class="add_entity_form">

        <h2>تعديل بياناتي</h2>
        <form class="" action="" method="post" enctype="multipart/form-data" onsubmit="return submitForm()">

          <div class="form-row ">
            <label for="title">كلمة المرور الحالية</label>
            <input type="text" class="form-control" name="pass" id="pass"  required autocomplete="off" />
          </div>

          <div class="form-row">
            <label for="price">كلمة المرور الجديدة</label>
            <input type="text" class="form-control" name="new-pass" id="new-pass"  required autocomplete="off" />
          </div>

          <div class="form-row">
            <label for="country">تأكيد كلمة المرور</label>
            <input type="text" class="form-control" name="new-pass2" id="new-pass2"  required autocomplete="off" />
          </div>

          <div class="form-row">
            <button type="submit" id="submit_form" name="button" class="btn btn-success btn-block" >حفظ</button>
          </div>

        </form>
      </div>

    </section>
  </div>
</div>


<script>

  function submitForm() {
    $("#submit_form").attr("disabled", true);
  }

</script>
