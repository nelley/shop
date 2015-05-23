<?php 
if ( isset($_POST['submitUpdate'])) {
	global $wpdb;
	
	$new_status = $_POST['submitUpdate'];
	$imgPath = $_POST['imgPath'];

	// 取得更新時間	
	$date = date('Y-m-d H:i:s a');
	
	if($new_status == 1){
		// 收件確認SQL
		$updateRe = $wpdb->update(
			'product_list', 
			array('status' => '2', 'arrived_date' => $date),
			array('img' => $imgPath, 'status' => $new_status),
			array('%d', '%s'),
			array('%s', '%d')
		);
	}else if($new_status == 2){
		// 付款確認SQL
		$updateRe = $wpdb->update(
			'product_list', 
			array('status' => '3', 'paid_date' => $date),
			array('img' => $imgPath, 'status' => $new_status),
			array('%d', '%s'),
			array('%s', '%d')
		);
	}
	
	if ($updateRe ===false) {
		exit( var_dump( $wpdb->last_query ) );
	}
	
	$wpdb->flush();
}
	// 在庫を取得する
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
	} else {
		echo "RESULT_SQL_NO_RECORD";
		return;
	}
	$wpdb->flush();

?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">

	function update(x, number){
		var msg;
		if(number == 1){
			msg = "你確認已經收到貨了?";
		}else if(number == 2){
			msg = "你確認已經匯錢了?";
		}
		
		if (confirm(msg) == true) {
			var self = x.parentNode.parentNode;
			var selectedRow = self.children;
			// get img path from selected row 
			
			//alert(selectedRow[k].childNodes[0].src);
			var imgInfo = selectedRow[0].childNodes[0].src;
			
			// post the selected data
			var method = "post"; // Set method to post by default if not specified.
			// The rest of this code assumes you are not using a library.
			// It can be made less wordy if you use one.
			var form = document.createElement("form");
			form.setAttribute("method", method);
			form.setAttribute("action", "");

			var hiddenField = document.createElement("input");
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", "submitUpdate");
			hiddenField.setAttribute("value", number);
			form.appendChild(hiddenField);

			// add elements to form add img path info
			hiddenField = document.createElement("input");
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", "imgPath");
			hiddenField.setAttribute("value", imgInfo);
			form.appendChild(hiddenField);
			
			// add form to body
			document.body.appendChild(form);
			
			form.submit();
		}
	}

	function doPagination(start){
		var obj = <?php echo json_encode($encode); ?>;
		var rows = 4;
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
	
	$(document).ready(function() {
		// get all unshipped showes
		doPagination(0);
		
		// listen mouse click 
		$(document).click(function(event) {
			var tmpId = event.target.id;
			//var clickedImg = $('#' + tmpId).offset();
			if(tmpId.indexOf("Image") != -1){
				var img = $('<div id="floatCenter" class="overlayImage">');	// style for backgroud

				$('#showimagediv').html(img).show();
				
				var elem = document.createElement("img");
				elem.setAttribute("src", event.target.src);
				elem.setAttribute("class", "alignCenter");
				elem.setAttribute("align", "top");
				document.getElementById("floatCenter").appendChild(elem);
			}
			
		});

		$('#showimagediv').on('click', function(){
			$('#showimagediv').hide();
		});
	});

</script>
<?php get_header(); ?>
		<!-- memberpage.php NL004 -->
		<div id="middle" class="clearfix">
				<?php if(!is_front_page()):?>
				<div id="pageHead">
					<h1><?php the_title(); ?></h1>
					<?php $page_description = get_post_meta($post->ID, "_ttrust_page_description_value", true); ?>
					<?php if ($page_description) : ?>
						<p><?php echo $page_description; ?></p>
					<?php endif; ?>				
				</div>
				<?php endif; ?>		 
		<!-- memberpage.php NL005 -->
		<div id="content" class="nelleyTwo clearfix">
		<!-- 追加東西 START-->
			<div id="responSiveDiv"></div>
			<div id="showimagediv"></div>
			
			<!--<div class="newDesign">
				<div class="box11">box11</div>
				<div class="BOXAA">
					<div class="BOXBB">
						<div class="box12">box12</div>
						<div class="box13">box13</div>
					</div>
					<div class="box14">box14</div>
					<div class="box15">box15</div>
				</div>
				<div class="box16">box16</div>
			</div>-->
			
		<!-- 追加東西END -->
		</div>
		</div>
	<!-- memberpage.php NL006 -->
<?php get_footer(); ?>