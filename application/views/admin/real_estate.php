<!-- start: Content -->
<div id="content" class="span10">

	<ul class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="">الرئيسية</a>
			<i class="icon-angle-right"></i>
		</li>
		<li><a href="#">لوحة التحكم</a></li>
	</ul>

	<h2>العقارات التي لديك بالموقع </h2>

  <div class="row-fluid">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">العنوان</th>
          <th scope="col">الاعلان</th>
          <th scope="col">العقار</th>
          <th scope="col">السعر</th>
          <th scope="col">المدينة</th>
          <th scope="col">المساحة</th>
          <th scope="col">مضاف بواسطة</th>
          <th scope="col">التاريخ</th>
					<th>حركة</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach ($entities as $key => $value) {

						if( $this->uri->segment(2) == 'real_estate'){
							$archive = "<a style='color:red;' href='javascript:archive($value->id)'>أرشفة</a>";
						}else{
							$archive = "<a style='color:red;' href='javascript:unarchive($value->id)'>إلغاء الأرشفة</a>";
						}

            // code...
            echo "
              <tr>
                <th scope='row'>$value->id</th>
                <td>$value->title</td>
                <td>$value->ad_type</td>
                <td>$value->type</td>
                <td>$value->price</td>
                <td>$value->city</td>
                <td>$value->space</td>
                <td>$value->add_by</td>
                <td>$value->add_time</td>
								<td>$archive</td>
              </tr>
            ";
          }
        ?>
      </tbody>
    </table>
  </div>

</div>

<script>

	function archive(id) {
	  let answer = confirm("هل أنت متأكد من أرشفة العقار؟");

		if(answer){
			//window.open("https://www.w3schools.com" , '_self');
			add_to_archive(id);
		}
	}

	function unarchive(id){
		let answer = confirm("هل أنت متأكد من إلغاء الأرشفة؟");

		if(answer){
			remove_from_archive(id);
		}
	}

	function add_to_archive(id){
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {};
			xhr.open('GET', '<?=base_url()?>admin/archive_enetity/'+id);
			xhr.send()
			location.reload();
	}

	function remove_from_archive(id){
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {};
		xhr.open('GET', '<?=base_url()?>admin/unarchive_enetity/'+id);
		xhr.send()
		location.reload();
	}

</script>
