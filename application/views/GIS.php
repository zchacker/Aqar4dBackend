<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=base_url()?>css/boot4/bootstrap.min.css">
    <script src="<?=base_url()?>js/boot4/jquery.min.js" charset="utf-8"></script>
    <title>معلومات الاراضي في السعودية</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <h2>معلومات المدن السعودية</h2>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form class="" action="" method="post">

            <div class="form-row">
              <label for="">المنطقة</label>
              <select class="form-control" name="" onchange="javascript:select_province(this)">
                <option value=""></option>
                <?php foreach ($provinces as $key => $value): ?>
                  <option value="<?=$value->id?>"><?=$value->nameAr?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-row" id="city" style="display:none;">
              <label for="city">المدينة</label>

            </div>

            <div class="form-row" id="neighborhood" style="display:none;">
              <label for="neighborhood">الحي</label>

            </div>

          </form>
        </div>
        <div class="col-md-8">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>الاسم</th>
              </tr>
            </thead>
            <tbody id="table_body">

            </tbody>
          </table>
        </div>
      </div>
    </div>

<script type="text/javascript">

  function select_province(province){

    var form_url  = '<?php echo base_url();?>web_api/cities_form';
    var table_url = '<?php echo base_url();?>web_api/cities_table';
    var select_value = province.value;

    console.log("provinceid="+select_value);

    $.ajax({
      url: form_url,
      type:'POST',
      data: "provinceid="+select_value ,
      success:function(data){
        console.log(data);
        var full_data = '<label for="city">المدينة</label>'+data;
        var cities = $('#city');
        cities.empty();
        cities.append(full_data);
        cities.show();
      }
    });


    $.ajax({
      url: table_url,
      type:'POST',
      data: "provinceid="+select_value ,
      success:function(data){
        console.log(data);
        var full_data = data;
        var cities = $('#table_body');
        cities.empty();
        cities.append(full_data);
        cities.show();
      }
    });

  }

  function select_city(province){

    var form_url  = '<?php echo base_url();?>web_api/neighborhoods_form';
    var table_url = '<?php echo base_url();?>web_api/neighborhoods_form';
    var select_value = province.value;

    console.log("cityid="+select_value);

    // $.ajax({
    //   url: form_url,
    //   type:'POST',
    //   data: "provinceid="+select_value ,
    //   success:function(data){
    //     console.log(data);
    //     var full_data = '<label for="neighborhood">الحي</label>'+data;
    //     var cities = $('#neighborhood');
    //     cities.empty();
    //     cities.append(full_data);
    //     cities.show();
    //   }
    // });


    $.ajax({
      url: table_url,
      type:'POST',
      data: "cityid="+select_value ,
      success:function(data){
        console.log(data);
        var full_data = data;
        var cities = $('#table_body');
        cities.empty();
        cities.append(full_data);
        cities.show();
      }
    });

  }


</script>
  </body>
</html>
