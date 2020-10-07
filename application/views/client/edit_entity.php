
    <section class="page_content">
      <div class="add_entity_form">
        <?=$error_msg?>
        <h2>إضافة عقار جديد</h2>
        <form class="" action="" method="post" enctype="multipart/form-data">
          <div class="form-row ">
            <label for="title">العنوان</label>
            <input type="text" class="form-control" name="title" id="title" value="<?=$real_estate->title?>" />
          </div>

          <div class="form-row">
            <label for="price">السعر</label>
            <input type="text" class="form-control" name="price" id="price" value="<?=$real_estate->price?>" />
          </div>

          <div class="form-row">
            <label for="city">المدينة</label>
            <input type="text" class="form-control" name="city" id="city" value="<?=$real_estate->city?>" />
          </div>

          <div class="form-row">
            <label for="country">الدولة</label>
            <input type="text" class="form-control" name="country" id="country" value="<?=$real_estate->country?>" />
          </div>

          <div class="form-row">
            <label for="phone">رقم الهاتف</label>
            <input type="text" class="form-control" name="phone" id="phone" value="<?=$real_estate->phone?>" />
          </div>

          <div class="form-row">
            <label for="email">البريد الالكتروني</label>
            <input type="text" class="form-control" name="email" id="email" value="<?=$real_estate->email?>" />
          </div>

          <div class="form-row">
            <label for="images">صور للعقار <span>*حتى 29 صورة</span></label>

            <div class="thumbnail" id="thumbnail">
              <?php

                $imgs = $this->client_model->get_photos_for_real_estate($real_estate->id);

                if($imgs->num_rows() > 0){

                  $imgs = $imgs->result();

                  foreach ($imgs as $key => $value) {

                    $img = base_url().'uploads/'.$value->media_path;

                    echo "
                    <div class='edit-img-wrap'  >
                        <span class='close' title='حذف الصورة' data-img-id='$value->id'  onclick='showDetails(this)' >&times;</span>
                        <img src='$img' alt=''  />
                    </div>";

                    //echo "<img src='$img' alt='' style='width:150px' data-img-id='$value->id' />";

                  }

                }
              ?>

            </div>
          </div>

          <!-- <div class="form-row">
            <label for="images">صور للعقار <span>*حتى 29 صورة</span></label>
            <input type="file" class="form-control" name="images[]" multiple id="images" value="" accept="image/x-png,image/jpeg," />
          </div>

          <div class="form-row">
            <label for="images">فديو ان وجد <span>mp4 فقط</span></label>
            <input type="file" class="form-control" name="video" id="images" value="" accept="video/mp4,video/x-m4" />
          </div> -->


          <div class="form-row">
            <label for="type">نوع الاعلان</label>
            <select id="type" name="type" class="form-control" >
              <option value="1" <?php if($real_estate->type == 1) echo 'selected'; ?> >بيع</option>
              <option value="2" <?php if($real_estate->type == 2) echo 'selected'; ?> >شراء</option>
              <option value="3" <?php if($real_estate->type == 3) echo 'selected'; ?> >إيجار</option>
            </select>
          </div>

          <div class="form-row">
            <label for="description">وصف للعقار</label>
            <textarea name="description" id="description" class="form-control" rows="8" cols="80"><?=$real_estate->description?></textarea>
          </div>

          <input type="hidden" name="lat" id="lat" value="<?=$real_estate->lat?>">
          <input type="hidden" name="lng" id="lng" value="<?=$real_estate->lng?>">

          <div class="form-row">
            <div id="map"></div>
          </div>

          <div class="form-row">
            <button type="submit" name="button" class="btn btn-primary btn-block" >حفظ</button>
          </div>

        </form>
      </div>

    </section>

<script>
    // Initialize and add the map
    function initMap() {
      // The location of Uluru
      var markerLocation = {lat: <?=$real_estate->lat?> , lng: <?=$real_estate->lng?>};
      // The map, centered at Uluru
      var map = new google.maps.Map(document.getElementById('map'), {zoom: 8, center: markerLocation});
      // The marker, positioned at Uluru
      var marker = new google.maps.Marker({
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

    function addAdvSubmit(){
			$('#addAdvForm').valid();
			if($('#addAdvForm').valid() == true){
				document.getElementById('addAdvSubmit').style.pointerEvents = 'none';
				$('#preloadadv').css('display', 'block');
				var form= $("#addAdvForm");
				$.ajax({
					url : '<?php echo base_url();?>clients/Client/addAllAdvCo',
					data: form.serialize(),
					type: 'POST',
					success: function(data){
						console.log(data);
						if(data == "success"){
							SEMICOLON.widget.notifications( jQuery('#adv-success') );
							location.reload();
						}else{
							SEMICOLON.widget.notifications( jQuery('#adv-failed') );
							$('#preloadadv').css('display', 'none');
							document.getElementById('addAdvSubmit').style.pointerEvents = 'auto';
						}
					}
				});
			}
		}

function showDetails(animal) {
  var animalType = animal.getAttribute("data-img-id");
  //alert("The " + animal.innerHTML + " is a " + animalType + ".");
  animal.parentElement.remove();
}

</script>

<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBovYrdTvtypEFdtSqn3EwtJx-9CvWeBqk&callback=initMap">
</script>
