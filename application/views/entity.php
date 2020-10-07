<section class="">
  <div class="container">
    <?php
      $old_date_timestamp = strtotime($real_estate->add_time);
      $new_date = date('Y-m-d', $old_date_timestamp);
    ?>
    <div class="entity_wrap">
        <div class="row">
          <div class="col-md-12">
            <div class="entity-title">
              <h2><?=$real_estate->title?></h2>
              <strong>إعلان رقم : </strong> <span> <?=$real_estate->id?> </span> | <strong> بواسطة:   </strong> <span> <a href="#"> <?=$real_estate->user_name?> </a> </span>
            </div>
          </div>
          <div class="col-md-12">
            <?php
              $real_estate_media = $this->client_model->get_photos_for_real_estate($real_estate->id)->result();
              $i = 0;
              foreach ($real_estate_media as $key => $value) {
                $img = base_url().'uploads/'.$value->media_path;
                echo "
                <a href='$img' target='_blank'>
                  <img src='$img' alt=''class='center' >
                </a>
                ";
                break;
              }
            ?>
          </div>
        </div>

        <!--<div class="row" style="display:none;">
          <div class="col-md-12">
            <div id="slider" class="carousel slide" data-ride="carousel">
              <!-- Indicators
              <ul class="carousel-indicators">
                <?php
                  // $real_estate_media = $this->client_model->get_photos_for_real_estate($real_estate->id)->result();
                  // $i = 0;
                  // foreach ($real_estate_media as $key => $value) {
                  //   if($i == 0)
                  //     echo '<li data-target="#slider" data-slide-to="'.$i.'" class="active"></li>';
                  //   else
                  //     echo '<li data-target="#slider" data-slide-to="'.$i.'" ></li>';
                  //
                  //     $i++;
                  // }
                ?>
              </ul>

              <!-- The slideshow
              <div class="carousel-inner">
                <?php
                  // $i = 0;
                  // foreach ($real_estate_media as $key => $value) {
                  //   $img = base_url().'uploads/'.$value->media_path;
                  //   echo '<br/>';
                  //   if($i == 0){
                  //     echo '<div class="carousel-item active">
                  //       <img src="'.$img.'" alt="" >
                  //     </div>';
                  //   }else{
                  //     echo '<div class="carousel-item ">
                  //       <img src="'.$img.'" alt="" >
                  //     </div>';
                  //   }
                  //
                  //   $i++;
                  // }
                ?>
              </div>

              <!-- Left and right controls
              <a class="carousel-control-prev" href="#slider" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </a>
              <a class="carousel-control-next" href="#slider" data-slide="next">
                <span class="carousel-control-next-icon"></span>
              </a>
            </div>
          </div>
        </div>-->

        <div class="row line_siprator2">
          <strong> تاريخ الاضافة: </strong> &nbsp <span> <?=$new_date?> ميلادي</span>
        </div>

        <div class="row line_siprator">
          <div class="col-md-2">
            <span class="real_estate_type"> <i class="fas fa-ad"></i> <?=$real_estate->ad_type?> </span>
          </div>
          <div class="col-md-2">
            <span class="real_estate_price_value"> <i class='fas fa-money-bill-alt'></i> <?=$real_estate->price?></span>
          </div>
          <div class="col-md-8">
            <span class="real_estate_price_value"> <i class='fas fa-map-marker-alt'></i> <?=$real_estate->country?> - <?=$real_estate->city?></span>
          </div>

        </div>

        <div class="row line_siprator">
          <div class="col-md-3">
            <strong>نوع العقار: </strong> <span class="">  <?=$real_estate->type_name?> </span>
          </div>
          <div class="col-md-4">
            <strong>المحافظة/الولاية: </strong> <span class="">  <?=$real_estate->province?> </span>
          </div>
          <div class="col-md-4">
            <strong>المدينة : </strong> <span class="">  <?=$real_estate->city?> </span>
          </div>
        </div>

        <div class="row line_siprator2">
          <div class="col-md-4">
            <strong>الحي : </strong> <span class="">  <?=$real_estate->neighborhood?> </span>
          </div>
        </div>

        <div class="row line_siprator">
          <div class="col-md-12">
            <h3>وصف أكثر : -</h3>
            <p><?=$real_estate->description?></p>
          </div>
        </div>

        <div class="row line_siprator">
            <div class="col-md-12">
              <h3>الصور: - </h3>

              <?php
                $real_estate_media = $this->client_model->get_photos_for_real_estate($real_estate->id)->result();
                $i = 0;
                foreach ($real_estate_media as $key => $value) {
                  $img = base_url().'uploads/'.$value->media_path;
                  echo "
                  <a href='$img' target='_blank'>
                    <img src='$img' alt=''class='center' >
                  </a>
                  ";
                }
              ?>

            </div>

        </div>



              <?php

                  $real_estate_video = $this->client_model->get_video_for_real_estate($real_estate->id);
                  $rows = $real_estate_video->num_rows();
                  if($rows == 1){
                    $video = base_url().'uploads/'.$real_estate_video->result()[0]->media_path;

                    echo '<div class="row line_siprator">
                      <div class="col-md-12">
                      <h3>فديو :- </h3>';

                    echo "
                      <video src='$video' controls>
                        متصفحك لا يدعم هذا النوع من الفديوهات
                      </video>
                    ";

                    echo '</div>
                      </div>';
                  }
              ?>


        <div class="row line_siprator">
          <h3>موقع العقار على الخريطة :- </h3>
          <div id="map"></div>
        </div>

        <?php
          //var_dump($_SESSION['logged_in']['user_id']);
          if($this->session->userdata('logged_in') && ($_SESSION['logged_in']['user_id']) == $real_estate->add_by ){
        ?>
        <div class="row">
          <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <a href="<?=base_url()?>client/edit_entity/<?=$real_estate->id?>" class="btn btn-warning btn-block">تعديل</a>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <a href="javascript:void(0)" class="btn btn-danger btn-block">حذف</a>
          </div>
        </div>
        <?php } ?>

    </div>

  </div>
</section>


<script src="<?=base_url()?>js/boot4/jquery.min.js" charset="utf-8"></script>
<script src="<?=base_url()?>js/boot4/popper.min.js" charset="utf-8"></script>
<script src="<?=base_url()?>js/boot4/bootstrap.js" charset="utf-8"></script>
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBovYrdTvtypEFdtSqn3EwtJx-9CvWeBqk&callback=initMap">
</script>


<script type="text/javascript">
    // Initialize and add the map
    function initMap() {
      // The location of Uluru
      var markerLocation = {lat: <?=$real_estate->lat?> , lng: <?=$real_estate->lng?> };
      // The map, centered at Uluru
      map = new google.maps.Map(document.getElementById('map'), {zoom: 8, center: markerLocation});
      // The marker, positioned at Uluru
      marker = new google.maps.Marker({
          position: markerLocation,
          map: map,
          draggable: true,
       });

       map.setZoom(12);

       // marker.addListener('dragend', function() {
       //   // map.setZoom(8);
       //   // map.setCenter(marker.getPosition());
       //
       //   var x = marker.getPosition().lat();
       //   var y = marker.getPosition().lng();
       //
       //   document.getElementById("location_x").value = x;
       //   document.getElementById("location_y").value = y;
       // });

    }
</script>
