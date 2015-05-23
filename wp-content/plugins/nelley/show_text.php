<?php
/*
Plugin Name: Show Text
Plugin URI: http://www.example.com/plugin
Description: NELLEY's plugin practice
Author: my name
Version: 0.1
*/
class helpBuyPlugin {
	private $DIR_PATH = "uploadedImg/";
	/**
	 * plugin ON or OFF flag
	 * */
	private $plugin_flg = FALSE;
	
	function __construct() {
		//add new option bar into admin's panel
		add_action('admin_menu', array($this, 'add_pages'));
		add_action('admin_enqueue_scripts', array($this, 'load_custom_wp_admin_style'));
		
		$this->setPlugin_Flg();
	}
	
	function add_pages() {
		add_menu_page('NELLEY \'s plugin','NELLEY \'s plugin',  'level_8', 'topHandle', array($this,'packaged_item'), '');
		//overwrite sub-menu's name,不寫的話會跑出NELLEY's plugin當副標題的名字
		add_submenu_page('topHandle', '代買商品管理', '代買商品管理', 'manage_options', 'topHandle');
		//第一個變數必須與add_menu_page的第四個變數一樣,不然無法顯示
		add_submenu_page('topHandle', '待追加頁面', '待追加頁面', 'manage_options', 'new-handle', array($this,'waitForAdding'));
	}
	function waitForAdding(){
		include 'sample.php';
	}
	/**
	 * style sheet for admin page
	 * */
	function load_custom_wp_admin_style(){
		wp_enqueue_style( 'wp_style_nelley_admin', plugins_url('/css/nelley.css', __FILE__) );
	}
	/**
	* 代買出貨登記顯示畫面 2015.03.01
	* */
	function packaged_item(){?>
	<?php 
		// get all products
		date_default_timezone_set('Asia/Tokyo');
		global $wpdb;
		$results = $wpdb->get_results("SELECT * FROM product_list");
		
		$encode = array();
	
		if ($wpdb->num_rows > 0) {
			// output data of each row to jason object
			foreach ($results as $result){
				$encode[] = array( 'price' => $result->price,
									'img' => $result->img,
									'upload_date' => $result->upload_date,
									'receipt_img' => $result->receipt_img,
									'receipt_date' => $result->receipt_date,
									'arrived_date' => $result->arrived_date,
									'paid_date' => $result->paid_date,
									'status' => $result->status);
			}
		}
		$wpdb->flush();
	
		// if shipped button is clicked
		if(isset($_POST["shippedSubmit"])) {
			check_admin_referer('shoptions');
			
			$target_dir = plugin_dir_path(__FILE__) . $this->DIR_PATH;
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			$uploadOk = 1;
			// get file type
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			
			// check whether the file is a image
			$check = getimagesize($_FILES["image"]["tmp_name"]);
			
			if($check !== false) {
				$uploadOk = 1;
			} else {
				$uploadOk = 2; // format error
			}
			// Check if file already exists
			if (file_exists($target_file)) {
				$uploadOk = 3; // already exist error
			}
			// Check file size under 5MB?
			if ($_FILES["image"]["size"] > 1024*1024*5) {
				$uploadOk = 4; // size error
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
				$uploadOk = 5; //file extension error
			}
			
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 1) {
				if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
					global $wpdb;
					
					// path of receipt
					$filePath = plugin_dir_url( __FILE__ ) . $this->DIR_PATH . basename($_FILES["image"]["name"]);
					// datetime of updating
					$date = date('Y-m-d H:i:s a');
					
					foreach($_POST as $key => $value){
						if($value != null){
							if(strrpos($value, $this->DIR_PATH)){
								$updateRe = $wpdb->update(
												'product_list', 
												array('receipt_img' => $filePath, 'receipt_date' => $date, 'status' => '1'),
												array('img' => $value, 'status' => '0'),
												array('%s', '%s', '%d'),
												array('%s', '%d')
											);
								if ($updateRe === false) {
									exit( var_dump( $wpdb->last_query ) );
								}
							}
						}
					}
					$wpdb->flush();
					echo "update success!";
					
				}else{
					echo "Sorry, there was an error uploading your file.";?>
					<br><?php  
					echo "errorcode:".$uploadOk;
				}
			}else{
				echo "Sorry, there was an error uploading your file.";?>
				<br><?php  
				echo "errorcode:".$uploadOk;
			}
		}
		// if add new product submit button is clicked
		if(isset($_POST["addNewSubmit"])) {
			check_admin_referer('shoptions'); // admin check
			
			$price = $_POST['price']; // get product's price
			// convert array to string
			$productList = $_POST['selItem'];
			// the path for restore uploaded img
			$target_dir = plugin_dir_path(__FILE__ ) . $this->DIR_PATH;
			$target_file = $target_dir . basename($_FILES["image"]["name"]); 
			$uploadOk = 1;
			// get file type
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			
			// check whether the file is a image
			$check = getimagesize($_FILES["image"]["tmp_name"]);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				$uploadOk = 2; // format error
			}
		
			// Check if file already exists
			if (file_exists($target_file)) {
				$uploadOk = 3; // already exist error
			}
			// Check file size under 5MB?
			if ($_FILES["image"]["size"] > 1024*1024*5) {
				$uploadOk = 4; // size error
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
				$uploadOk = 5; //file extension error
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 1) {
				if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
					// param check completed!! initial DB and insert the data
					global $wpdb;
					
					$status = 0;
					$date = date('Y-m-d H:i:s a');
					// need to use http address img
					
					$filePath = plugin_dir_url( __FILE__ ) . $this->DIR_PATH . basename($_FILES["image"]["name"]);
					
					$wpdb->insert('product_list',
									array('product' => $productList,
											'price' => $price,
											'img' => $filePath, 
											'upload_date' => $date, 
											'status' => $status), 
									array('%s', '%d', '%s', '%s', '%d'));
					
					$wpdb->flush();
					echo "uploading successed";
				}
			}else{
				echo "Sorry, there was an error uploading your file.";?>
				<br><?php  
				echo "errorcode:".$uploadOk;
			}
		}
		if(isset($_POST["deleteSubmit"])){
			check_admin_referer('shoptions');
			foreach($_POST as $key => $value){
				if($value != null){
					if(strrpos($value, $this->DIR_PATH)){
						$delRe = $wpdb->query($wpdb->prepare("DELETE FROM product_list WHERE img = %s", $value));
						if ($delRe === false) {
							exit( var_dump( $wpdb->last_query ) );
						}
						// delete the img file
						//$delItem = array();
						$delItem = explode("/", $value);
						//$leng = sizeof($delItem);
						$base_directory = plugin_dir_path(__FILE__) . $this->DIR_PATH . end($delItem);
						if(!unlink($base_directory)){
							echo "error";
						}
					}
				}
			}
		}
		?>
		<!-- datepicker -->
		<script src="http://code.jquery.com/jquery-1.11.0.js"></script>
		
		<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div><h2>代買打包登記</h2>

		<button type="submit" id="submitNew" class="button-primary" onclick="modified(0)">新增商品</button>
		<button type="submit" id="submitShipped" class="button-primary" onclick="modified(1)">商品出貨</button>
		<button type="submit" id="submitDelete" class="button-primary" onclick="modified(2)">刪除商品</button>
		<button type="submit" id="test" class="button-primary" onclick="test()">test</button>
		<div id="responSiveDiv"></div>
		<div id="floatDialog"></div>

		</div>
		
		<script>
			function test(partial,hidden,direction){
				var x = $('#proImage0').expandJQueryTest(2,3);
				var y = $().expandJQueryTest(1,2);
				alert(x);
				alert(y);
				alert($('#proImage0').visible());
				alert($('#proImage2:visible').visible());
			}
			
			// add new product
			function modified(x){
				if(x == 0){
					// add new product
					var addNewForm = $('<div id="floatCenter" class="overlayImage">');	// style for backgroud
					
					$('#floatDialog').html(addNewForm).show();
					var myForm = '<form class="alignCenterSub" id="modiForm" action="" method="POST" enctype="multipart/form-data">';
					myForm += '<?php wp_nonce_field('shoptions');?>';
					myForm += '<?php get_option('showtext_options');?>';
					// wait further modify
					myForm += '<div class="addNewTitle"><div class="title">新增商品</div><div class="img_close"><img src ="<?php echo plugin_dir_url(__FILE__);?>img/close.png" width="100%" height="100%" id="closeDialog"></div></div>';
					myForm += '<div class="addNewRow"><label class="la" for="product">商品:</label>';
					myForm += '<select name="selItem">';
					myForm += '<option value="MS">男球鞋</option>';
					myForm += '<option value="WMS">女球鞋</option>';
					myForm += '</select>';
					myForm += '</div>';
					myForm += '<div class="addNewRow"><label class="la" for="price">商品價格:</label><input type="text" name="price"></div>';
					myForm += '<div class="addNewRow"><label class="la" for="photo">商品照片:</label><input type="file" name="image" id="upload-image" multiple="true" class="la"></div>';
					myForm += '<div class="submitRow"><button name="addNewSubmit" type="submit" class="button-primary"  onclick="mySubmit()">確認新增</button></div>';
					myForm += '<div class="addNewRowPre"><img id="blah" src=""/></div>';
					myForm += '</form>';
					document.getElementById("floatCenter").innerHTML = myForm;
				}else if(x == 1){
					// add new receipt
					var addNewForm = $('<div id="floatCenter" class="overlayImage">');	// style for backgroud
					
					$('#floatDialog').html(addNewForm).show();
					var myForm = '<form class="alignCenterSub" id="modiForm" action="" method="POST" enctype="multipart/form-data">';
					myForm += '<?php wp_nonce_field('shoptions');?>';
					myForm += '<?php get_option('showtext_options');?>';
					// wait further modify
					myForm += '<div class="addNewTitle"><div class="title">商品出貨</div><div class="img_close"><img src ="<?php echo plugin_dir_url(__FILE__);?>img/close.png" width="100%" height="100%" id="closeDialog"></div></div>';
					myForm += '<div class="addNewRow"><label class="la" for="photo">出貨單據:</label><input type="file" name="image" id="upload-image" multiple="true" class="la"></div>';
					myForm += '<div class="submitRow"><button name="shippedSubmit" type="submit" class="button-primary"  onclick="myShip()">確認出貨</button></div>';
					myForm += '<div class="addNewRowPre"><img id="blah" src=""/></div>';
					myForm += '</form>';
					document.getElementById("floatCenter").innerHTML = myForm;
					
				}else if(x == 2){
					// delete product
					var addNewForm = $('<div id="floatCenter" class="overlayImage">');	// style for backgroud
					$('#floatDialog').html(addNewForm).show();
					var myForm = '<form class="alignCenterSub" id="modiForm" action="" method="POST" enctype="multipart/form-data">';
					myForm += '<?php wp_nonce_field('shoptions');?>';
					myForm += '<?php get_option('showtext_options');?>';
					// wait further modify
					myForm += '<div class="addNewTitle"><div class="title">刪除商品</div><div class="img_close"><img src ="<?php echo plugin_dir_url(__FILE__);?>img/close.png" width="100%" height="100%" id="closeDialog"></div></div>';
					myForm += '<div class="addNewRowCenter"><label for="description">你確定要刪除嗎</label></div>';
					myForm += '<div class="submitRow"><button name="deleteSubmit" type="submit" class="button-primary"  onclick="myDelete()">確認刪除</button></div>';
					myForm += '</form>';
					document.getElementById("floatCenter").innerHTML = myForm;
				}
			}
			
			function mySubmit(){
				$("#modiForm").submit();
			}

			function myShip(){
				var prgs = document.getElementsByTagName("img");
				var tmpForm = document.getElementById("modiForm");
				for(i=0; i<prgs.length; i++){
					var tmp = document.getElementsByTagName("img")[i].getAttribute("id");
					if((tmp != null) && (tmp.indexOf("proImage") != -1)){
						if(document.getElementsByTagName("img")[i].style.backgroundColor == "rgb(56, 43, 174)"){
							addHidden(tmpForm, 'key'+i, document.getElementsByTagName("img")[i].getAttribute("src"));
						}
					}
				}
				$("#modiForm").submit();
			}

			function myDelete(){
				var prgs = document.getElementsByTagName("img");
				var tmpForm = document.getElementById("modiForm");
				for(i=0; i<prgs.length; i++){
					var tmp = document.getElementsByTagName("img")[i].getAttribute("id");
					if((tmp != null) && (tmp.indexOf("proImage") != -1)){
						if(document.getElementsByTagName("img")[i].style.backgroundColor == "rgb(56, 43, 174)"){
							addHidden(tmpForm, 'key'+i, document.getElementsByTagName("img")[i].getAttribute("src"));
						}
					}
				}
				$("#modiForm").submit();
			}

			function addHidden(theForm, key, value){
				// Create a hidden input element, and append it to the form:
				var input = document.createElement('input');
				input.type = 'hidden';
				input.name = key;
				input.value = value;
				theForm.appendChild(input);
			}
			
			function doPagination(start){
				var obj = <?php echo json_encode($encode); ?>;
				var rows = 6;
				// paging
				var columns = 1;
				var totalContent = obj.length;//total number of content
				
				var noPerPage = rows*columns;//Number of content in one page
				var noOfPage = 0;//Holds number of pages
				
				if(totalContent%noPerPage == 0) {
					noOfPage = Math.floor(totalContent/noPerPage);
				}
				else {
					noOfPage = Math.floor((totalContent/noPerPage)+1);
				}

				//if total content is less than number of content in one page
				if(totalContent < noPerPage) {
					if(totalContent%columns == 0) {
						rows = Math.floor(totalContent/columns);
					}
					else {
						rows = Math.floor((totalContent/columns)+1);
					}
					noOfPage = 1;
				}
				var whichPage = (start/noPerPage)+1;//Current page number
				var pagination = 5;//To show page numbers, better to keep odd number like 3,5,7 etc
				var midPagination = Math.floor(pagination / 2);
				// paging
				var divTable = '';
				
				for(var i = 0; i < rows; i++){
					var tmpObj = obj[start];
					if(tmpObj){
					
						divTable += '<div class="newDesign" id=allBOX-' + i + '>';
						divTable += '<div class="box11"><img src=' + tmpObj['img'] +' class="images" id=proImage' + i +'></div>';
						divTable += '<div class="BOXAA">';
						divTable += '<div class="BOXBB">';
						divTable += '<div class="box12">收貨日<div class="date">' + tmpObj['upload_date'] + '</div></div>';
						divTable += '<div class="box13">出貨日<div class="date">'+ tmpObj['receipt_date'] +'</div></div>';
						divTable += '</div>';	// close boxB
						divTable += '<div class="box14">價錢<div class="price">' + tmpObj['price'] + '</div></div>';
						divTable += '<div class="box15"><img src=' + tmpObj['receipt_img'] +' class="images" id=receiptImage' + i +'></div>';
						divTable += '</div>';	// close boxA
						
						if(tmpObj['status'] == 1){
							// shipped
							divTable += '<div class="box16"><button class="memeberpage"  onclick="update(this, 1)">確認收件</button></div>';
							
						}else if(tmpObj['status'] == 2){
							// arrived, not paid yet
							divTable += '<div class="box16"><button class="memeberpage"  onclick="update(this, 2)">已到未付</button></div>';
							
						}else if(tmpObj['status'] == 3){
							// paid already
							divTable += '<div class="box16"><button class="memeberpage"  disabled>貨款已清</button></div>';
								
						}else if(tmpObj['status'] == 0){
							// unshipped
							divTable += '<div class="box16"><button class="memeberpage"  disabled>尚未出貨</button></div>';
						}else{
							// else
							divTable += '<div class="box16"><div>unchecked</div></div>';
						}
			
						divTable += '</div>';	// close allBox
					}
					start++;
				}
				// paging start
				divTable += '<div id="paging" class="noBorder">';
				divTable += '<div colspan="5" ></button>';

				if(whichPage > pagination) {
					divTable += "<a onclick='doPagination("+noPerPage*(whichPage-1-pagination)+")' class='paging'><<</a> ";
				}
				if(whichPage > 1) {
					divTable += "<a onclick='doPagination("+noPerPage*(whichPage-1-1)+")' class='paging'><</a> ";
				}

				//generate page numbers
				var fno = whichPage - midPagination;
				var lno = whichPage + midPagination;

				if(fno < 1 &&  noOfPage > pagination) {
					fno = 1;
					lno = pagination;
				}
				else if(fno < 1 && noOfPage <= pagination) {
					fno = 1;
					lno = noOfPage;
				}
				else if(lno > noOfPage && noOfPage <= pagination) {
					fno = 1;
					lno = noOfPage;
				}
				else if(lno > noOfPage && noOfPage > pagination) {
					lno = noOfPage;
					fno = (lno - pagination) + 1;
				}
				//loop pages numbers
				for(var k=fno;k<=lno;k++) {
					if(whichPage == k) {
						divTable += "<b class='pagingChosen'>"+k+"</b> ";
					}else {
						divTable += "<a onclick='doPagination("+noPerPage*(k-1)+")' class='paging'>"+k+"</a> ";
					}
				}

				if(whichPage < noOfPage) {
					divTable += "<a onclick='doPagination("+noPerPage*(whichPage-1+1)+")' class='paging'>></a> ";
				}
				if(whichPage <= (noOfPage - pagination)) {
					divTable += "<a onclick='doPagination("+noPerPage*(whichPage-1+pagination)+")' class='paging'>>></a>";
				}
				divTable += '</div>';
				divTable += '</div>';
				//Add generated html content
				document.getElementById("responSiveDiv").innerHTML = divTable;
			}

			function readURL(input) {
				if (input.files && input.files[0]) {
				var file = input.files[0];
					//size check( less than 1MB)
					if(file.size < 1024*1024*1024){
						var reader = new FileReader();
						reader.onload = function (e) {
							$('#blah').attr('src', e.target.result);
							$('#blah').attr('class', 'prevImg');
						}
						reader.readAsDataURL(input.files[0]);
					}else{
						alert("bigger than 10MB");
					}
				}
			}
			// select when id starts with proImage
			$(document).click(function(event) {
				var tmpId = event.target.id;
				// click the product's image
				if(tmpId.indexOf("proImage") != -1){
					var color = $( "#" + tmpId ).css( "background-color" );
					// background color changing
					if(color == "rgb(56, 43, 174)"){
						$("#" + tmpId).css({
							"background-color":"rgb(0, 0, 0, 0)",
						});
					}else{
						$("#" + tmpId).css({
							"background-color":"rgb(56, 43, 174)",
						});
					}
				}
				// close the Dialog
				if(tmpId.indexOf("closeDialog") != -1){
					$('#floatDialog').hide();
				}

				// upload image selection
				if(tmpId.indexOf("upload-image") != -1){
					$('#upload-image').change(function(){
						readURL(this);
					});
				}

				
				
			});

			$(document).keydown(ivnt_keydown);
			
			function ivnt_keydown(e) {
				// ESCAPE key pressed
				if (e.keyCode == 27) {
					$('#floatDialog').hide();
				}
			}
			$(document).ready(function() {
				doPagination(0);
			});

			(function($){
				var $w = $(window);
				
				$.fn.expandJQueryTest = function(x, y){
					return x+y;
				}

				$.fn.visible = function(partial,hidden,direction){
			        if (this.length < 1)
			            return;

			        var $t        = this.length > 1 ? this.eq(0) : this,
			            t         = $t.get(0),
			            vpWidth   = $w.width(),
			            vpHeight  = $w.height(),
			            direction = (direction) ? direction : 'both',
			            clientSize = hidden === true ? t.offsetWidth * t.offsetHeight : true;

			        if (typeof t.getBoundingClientRect === 'function'){

			            // Use this native browser method, if available.
			            var rec = t.getBoundingClientRect(),
			                tViz = rec.top    >= 0 && rec.top    <  vpHeight,
			                bViz = rec.bottom >  0 && rec.bottom <= vpHeight,
			                lViz = rec.left   >= 0 && rec.left   <  vpWidth,
			                rViz = rec.right  >  0 && rec.right  <= vpWidth,
			                vVisible   = partial ? tViz || bViz : tViz && bViz,
			                hVisible   = partial ? lViz || rViz : lViz && rViz;

			            if(direction === 'both')
			                return clientSize && vVisible && hVisible;
			            else if(direction === 'vertical')
			                return clientSize && vVisible;
			            else if(direction === 'horizontal')
			                return clientSize && hVisible;
			        } else {

			            var viewTop         = $w.scrollTop(),
			                viewBottom      = viewTop + vpHeight,
			                viewLeft        = $w.scrollLeft(),
			                viewRight       = viewLeft + vpWidth,
			                offset          = $t.offset(),
			                _top            = offset.top,
			                _bottom         = _top + $t.height(),
			                _left           = offset.left,
			                _right          = _left + $t.width(),
			                compareTop      = partial === true ? _bottom : _top,
			                compareBottom   = partial === true ? _top : _bottom,
			                compareLeft     = partial === true ? _right : _left,
			                compareRight    = partial === true ? _left : _right;

			            if(direction === 'both')
			                return !!clientSize && ((compareBottom <= viewBottom) && (compareTop >= viewTop)) && ((compareRight <= viewRight) && (compareLeft >= viewLeft));
			            else if(direction === 'vertical')
			                return !!clientSize && ((compareBottom <= viewBottom) && (compareTop >= viewTop));
			            else if(direction === 'horizontal')
			                return !!clientSize && ((compareRight <= viewRight) && (compareLeft >= viewLeft));
			        }
			    };
			})(jQuery);
		</script>
		<?php 
	}
	
	/**
	 * setter fot plugin_flg
	 * */
	function setPlugin_Flg(){
		$this->plugin_flg = TRUE;
	}
	
	/**
	 * getter for plugin_flg
	 * */
	function getPluginFlg(){
		return $this->plugin_flg;
	}

}
$helpBuyPlugin = new helpBuyPlugin;
?>
