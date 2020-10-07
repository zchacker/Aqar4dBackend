<div class="row">
  <div class="col-md-12">
    <section class="page_content">
      <div class="add_entity_form">
        <?=$error_msg?>
        <h2>إضافة عقار جديد</h2>
        <form class="" action="" method="post" enctype="multipart/form-data">
          <div class="form-row ">
            <label for="title">العنوان</label>
            <input type="text" class="form-control" name="title" id="title" value="" required>
          </div>

          <div class="form-row">
            <label for="price">السعر</label>
            <input type="text" class="form-control" name="price" id="price" value="" required>
          </div>

          <div class="form-row">
            <label for="country">الدولة</label>
            <select class="form-control" name="country"  id="country" onchange="javascript:select_country(this)">
              <option value="0"></option>
              <option value="1">السعودية</option>
              <option value="2">خارج السعودية</option>
            </select>
          </div>

          <div class="form-row" id="provinces" style="display:none;">
            <label for="provinces">المنطقة</label>
          </div>

          <div class="form-row" id="city" style="display:none;">
            <label for="city">المدينة</label>

          </div>

          <div class="form-row" id="neighborhood" style="display:none;">
            <label for="neighborhood">الحي</label>

          </div>

          <div class="" id="non-saudi" style="display:none;">

          </div>


          <!-- <input type="text" class="form-control" name="country" id="country" value=""> -->


          <!-- <div class="form-row">
            <label for="phone">رقم الهاتف</label>
            <input type="text" class="form-control" name="phone" id="phone" value="">
          </div>

          <div class="form-row">
            <label for="email">البريد الالكتروني</label>
            <input type="text" class="form-control" name="email" id="email" value="">
          </div> -->

          <div class="form-row">
            <label for="images">صور للعقار <span>*حتى 29 صورة</span></label>
            <div class="input-images"></div>
            <!-- <input type="file" class="form-control" name="images[]" multiple id="images" value="" accept="image/x-png,image/jpeg,"> -->
          </div>

          <div class="form-row">
            <label for="images">فديو ان وجد <span>mp4 فقط</span></label>
            <input type="file" class="form-control" name="video" id="images" value="" accept="video/mp4,video/x-m4">
          </div>


          <div class="form-row">
            <label for="type">نوع الاعلان</label>
            <select id="type" name="type" class="form-control" >
              <option  value="1">بيع</option>
              <option value="2">شراء</option>
              <option value="3">إيجار</option>
            </select>
          </div>

          <div class="form-row">
            <label for="description">وصف للعقار</label>
            <textarea name="description" id="description" class="form-control" rows="8" cols="80"></textarea>
          </div>

          <input type="hidden" name="lat" id="lat" value="24.459145802677078">
          <input type="hidden" name="lng" id="lng" value="39.66354448280333">

          <div class="form-row">
            <button type="button" name="button" class="btn btn-success" onclick="javascript:getLocation()">تحديد موقعي الحالي</button>
          </div>
          <div class="form-row">
            <div id="map"></div>
          </div>

          <div class="form-row">
            <button type="submit" id="submit_form" name="button" class="btn btn-success btn-block" disabled>إضافة</button>
          </div>

        </form>
      </div>

    </section>
  </div>
</div>

<script>

    var marker ;
    var map;

    $('.input-images').imageUploader();

    //var x = document.getElementById("demo");

    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        //x.innerHTML = "Geolocation is not supported by this browser.";
        alert('تحديد الموقع غير مدعوم في متصفحك');
      }
    }

    function showPosition(position) {
      var pos = {
        lat: position.coords.latitude ,
        lng: position.coords.longitude
      };

      map.setCenter(pos);
      map.setZoom(18);
      marker.setPosition(pos);

      //x.innerHTML = "Latitude: " + position.coords.latitude +
      //"<br>Longitude: " + position.coords.longitude ;
    }

    // Initialize and add the map
    function initMap() {
      // The location of Uluru
      var markerLocation = {lat: 24.459145802677078 , lng: 39.66354448280333};
      // The map, centered at Uluru
      map = new google.maps.Map(document.getElementById('map'), {zoom: 8, center: markerLocation});
      // The marker, positioned at Uluru
      marker = new google.maps.Marker({
          position: markerLocation,
          map: map,
          draggable: true
       });

       marker.addListener('dragend', function() {
         // map.setZoom(8);
         // map.setCenter(marker.getPosition());

         var x = marker.getPosition().lat();
         var y = marker.getPosition().lng();

         document.getElementById("location_x").value = x;
         document.getElementById("location_y").value = y;
       });

    }

    function select_country(country){
        var url = '<?php echo base_url();?>web_api/get_provinces';
        var select_value = country.value;

        if(select_value == 1){
          var nonsaudi = $('#non-saudi');
          nonsaudi.empty();

          $.ajax({
            url: url,
            type:'GET',
            success:function(data){
              console.log(data);
              var full_data = '<label for="province">المنطقة</label>'+data;
              var provinces = $('#provinces');
              provinces.empty();
              provinces.append(full_data);
              provinces.show();
            }
          });
        }else{
          var html = '<div class="form-row">';
          html += '<input type="text" class="form-control" name="countries" id="countries" value="" required>';
          html += '</div>';

          html += '<div class="form-row">';
          html += '<label for="city">المنطقة</label>';
          html += '<input type="text" class="form-control" name="province" id="province" value="" required>';
          html += '</div>';

          html += '<div class="form-row">';
          html += ' <label for="city">المدينة</label>';
          html +=  '<input type="text" class="form-control" name="city" id="city" value="" required>';
          html += '</div>';

          html += '<div class="form-row">';
          html +=  ' <label for="city">الحي</label>';
          html +=   '<input type="text" class="form-control" name="neighborhood" id="neighborhood" value="" required>';
          html += '</div>';

          var nonsaudi = $('#non-saudi');
          nonsaudi.empty();
          nonsaudi.append(html);
          nonsaudi.show();

        }


    }

    function select_province(province){
      var url = '<?php echo base_url();?>web_api/get_citis';
      var select_value = province.value;
      console.log("provinceid="+select_value);

      $.ajax({
        url: url,
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
    }

    function select_city(city){
      var url = '<?php echo base_url();?>web_api/get_neighborhoods';
      var select_value = city.value;
      console.log("cityid="+select_value);

      $.ajax({
        url: url,
        type:'POST',
        data: "cityid="+select_value ,
        success:function(data){
          console.log(data);
          var full_data = '<label for="city">الحي</label>'+data;
          var neighborhoods = $('#neighborhood');
          neighborhoods.empty();
          neighborhoods.append(full_data);
          neighborhoods.show();
        }
      });
    }

    function select_neighborhood(neighborhood){
      var select_value = neighborhood.value;
      if(select_value != 0)
        $('#submit_form').prop('disabled', false);
    }




</script>

<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBovYrdTvtypEFdtSqn3EwtJx-9CvWeBqk&callback=initMap">
</script>
