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

	<h2>المستخدمين المسجلين بالموقع</h2>
	
  <div class="row-fluid">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">الاسم</th>
          <th scope="col">رقم الهاتف</th>
          <th scope="col">الايميل</th>
					<th scope="col">حركة</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach ($members as $key => $value) {
            // code...
            echo "
              <tr>
                <th scope='row'>$value->id</th>
                <td>$value->name</td>
                <td>$value->phone</td>
								<td>$value->email</td>
                <td> <a style='color:red;' href='javascript:archive($value->id)'>حذف</a> </td>
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
	  let answer = confirm("هل أنت متأكد من حذف المستخدم؟");

		if(answer){
			//window.open("https://www.w3schools.com" , '_self');
			add_to_archive(id);
		}
	}

	function unarchive(id){
		let answer = confirm("هل أنت متأكد من رفع الحذف؟");

		if(answer){
			remove_from_archive(id);
		}
	}

	function add_to_archive(id){
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {};
			xhr.open('GET', '<?=base_url()?>admin/delete_user/'+id);
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
