<section class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="page_title">
        <div class="title">
          <h3>عقاراتك</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="container">

    <div class="row">

      <div class="col-md-3">
        <ul class="right_list">
          <a href="<?=base_url();?>client" class="list_link"><li class="list_item">عقاراتك</li></a>
          <a href="#" class="list_link"><li class="list_item">معلوماتك الشخصية</li></a>
          <a href="#" class="list_link"><li class="list_item">تغير كلمة السر</li></a>
        </ul>
      </div>

      <div class="col-md-9">
        <div class="container22">

          <div class="row">
            <div class="table-responsive">
              <table class="table table-sm table-striped ">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">العنوان</th>
                    <th scope="col">الإعلان</th>
                    <th scope="col">العقار</th>
                    <th scope="col">السعر</th>
                    <th scope="col">المساحة</th>
                    <th scope="col">الدولة</th>
                    <th scope="col">المنطقة</th>
                    <th scope="col">المدينة</th>
                    <th scope="col">الحي</th>
                    <th scope="col">مضاف بواسطة</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                    foreach ($entities as $key => $value) {

                      $url = base_url().'home/entity/'.$value->id;

                      echo "
                      <tr class='clickable-row' data-href='$url'>
                        <th scope='row'>$value->id</th>
                        <td>$value->title</td>
                        <td>$value->ad_type</td>
                        <td>$value->type</td>
                        <td>$value->price</td>
                        <td>$value->space</td>
                        <td>$value->country</td>
                        <td>$value->province</td>
                        <td>$value->city</td>
                        <td>$value->neighborhood</td>
                        <td>$value->add_by</td>
                      </tr>
                      ";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>

    </div>

  </div>
</section>

<script type="text/javascript">
  jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
  });
</script>
