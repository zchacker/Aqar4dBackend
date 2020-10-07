<section class="page_content">
  <div class="row">

    <div class="col-md-3">
      <div class="right_side_filters">
        <form class="" action="" method="post">

          <!-- <div class="form-group">
            <button type="submit" name="button" class="btn btn-primary btn-block">تطبيق</button>
          </div> -->

          <h3>المدن</h3>
          <div class="form-group">
            <input type="text" class="form-control" name="city" value="" placeholder="ابحث عن طريق المدينة">
            <!-- <label class="form-check-label" for="defaultCheck1"> Default checkbox </label> -->
            <!-- <select class="form-control" name="">
              <option value=""></option>
            </select> -->
          </div>

          <h3>نوع العرض</h3>
          <div class="form-group">
            <!-- <label class="form-check-label" for="defaultCheck1"> Default checkbox </label> -->
            <select class="form-control" name="type">
              <option value="0">الكل</option>
              <option value="1">بيع</option>
              <option value="2">شراء</option>
              <option value="3">ايجار</option>
            </select>
          </div>

          <h3>سعر العقار</h3>
          <div class="form-group">
            <div class="row">
              <div class="col">
                <!-- <label class="form-check-label" for="defaultCheck1"> Default checkbox </label> -->
                <input type="text" name="min-price" class="form-control" value="" placeholder="أدني">
              </div>
              -
              <div class="col">
                <!-- <label class="form-check-label" for="defaultCheck1"> Default checkbox </label> -->
                <input type="text" class="form-control" name="max-price" value="" placeholder="أعلى">
              </div>
            </div>
          </div>

        <div class="form-group">
          <button type="submit" name="search_btn" value="filter" class="btn btn-primary btn-block">بحث</button>
        </div>

        </form>
      </div>
    </div>

    <div class="col-md-9">
      <div class="real_estate_feed">
          <div class="col-md-12">
            <form class="form-inline" method="post" action="">
              <!-- <div class="form-row"> -->
                <input name="query" type="text" class="form-control mb-2 mr-sm-2 search_box" style="display:table-cell; width:85%" id="inlineFormInputName2" placeholder="ابحث عن عقارك">
                <button type="submit" name="search_btn" value="query" class="btn btn-primary mb-2"><i class="fa fa-search"></i></button>
              <!-- </div> -->
            </form>
          </div>
        <?php
          foreach ($results as $key => $value) {
            $img =  base_url().'uploads/house.png';
            $img_query = $this->client_model->get_photo($value->id);
            $rows = $img_query->num_rows();

            if($rows >= 1){
              $img = base_url().'uploads/'.$img_query->result()[0]->media_path;
            }

            $type = 'للبيع';
            if($value->type == 1){
              $type = 'للبيع';
            }elseif ($value->type == 2) {
              $type = 'شراء';
            }elseif ($value->type == 3) {
              $type = 'إيجار';
            }

            $url = base_url().'home/entity/'.$value->id;
            $description = substr($value->description ,0 , 350);

            echo"
            <div class='real_estate_wrapper'>
              <a href='$url' class='real_estate_feed_link'>
                <div class='container-fluid'>
                  <div class='row'>
                    <div class='title'>
                      <h2>$value->title</h2>
                    </div>
                  </div>
                  <div class='rows'>
                    <div class='real_estate_summry row'>

                      <div class='price col-md-4 col-lg-4 col-xl-4 col-sm-12 col-12'>
                        <p>
                          <span class='real_estate_type'> <i class='fas fa-quote-right'></i> $value->ad_type </span>
                          <span class='real_estate_price_value'> <i class='fas fa-money-bill-alt'></i> $value->price </span>
                          <span class='real_estate_price_curruncy'>ريال</span>
                        </p>
                      </div>

                      <div class='address col-md-4 col-lg-4 col-xl-4 col-sm-12 col-12'>
                        <p> <i class='fas fa-map-marker-alt'></i> $value->country - $value->city</p>
                      </div>

                      <div class='time col-md-4 col-lg-4 col-xl-4 col-sm-12 col-12'>
                        <p> <i class='far fa-clock'></i> $value->add_time </p>
                      </div>

                    </div>
                  </div>

                  <div class='row'>
                    <div class='time col-md-4 col-lg-4 col-xl-4 col-sm-12 col-12'>
                      <p> <i class='far fa-clock'></i> $value->add_time </p>
                    </div>
                  </div>

                  <div class='row'>
                    <div class='real_estate_content'>
                      <div class='real_estate_img' style=' background-image: url($img);'>
                        <img src='$img' alt=''>
                      </div>
                      <div class='real_estate_details'>
                        <p> $description </p>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>";
          }
        ?>

          <!-- <div class="real_estate_wrapper">
            <a href="#" class="real_estate_feed_link">
              <div class="container-fluid">
                <div class="row">
                  <div class="title">
                    <h2>فيلا للبيع في شارع انطاكية ، حي اشبيلية22222</h2>
                  </div>
                </div>
                <div class="rows">
                  <div class="real_estate_summry row">

                    <div class="price col-md-4 col-lg-4 col-xl-4 col-sm-12 col-12">
                      <p> <span class="real_estate_type"> <i class="fas fa-quote-right"></i> للبيع </span>  <span class="real_estate_price_value"> <i class="fas fa-money-bill-alt"></i> 1200000 </span> <span class="real_estate_price_curruncy">ريال</span></p>
                    </div>

                    <div class="address col-md-4 col-lg-4 col-xl-4 col-sm-12 col-12">
                      <p> <i class="fas fa-map-marker-alt"></i> المدينة المنورة</p>
                    </div>

                    <div class="time col-md-4 col-lg-4 col-xl-4 col-sm-12 col-12">
                      <p> <i class="far fa-clock"></i> أمس</p>
                    </div>

                  </div>
                </div>
                <div class="row">
                  <div class="real_estate_content">
                    <div class="real_estate_img">
                      <img src="http://localhost/aqar_app/uploads/1570097656_314765d95c9f8b0324.jpg" alt="">
                    </div>
                    <div class="real_estate_details">
                      <p>فيلا بحى الغروب
                            فيلا درج صاله دوبلك مساحه ٣٠٠م بمبلغ ٩٤٠الف بحى العوالى
                            وجهة غربيه شارع ١٥متر
                            الفيلا تتكون من طابقين الطابق الأرضي مدخل سيارة بالإضافه إلى مجلس رجال ومقلط بالإضافه صاله نساء ومجلس نساء ومطبخ ومستودع بالإضافه إلى الطابق الثاني يتكون من غرفه نوم رئيسية وغرفتتين بدوره مياه مشتركة وغرفه خادمه مع دوره مياه مع السطح
                            والشقه بها غرفتين نوم وصاله ومطبخ ومجلس رجال.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div> -->

      </div>
    </div>

  </div>
</section>
