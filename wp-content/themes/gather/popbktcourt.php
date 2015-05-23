<?php //get_header(); ?>
<?php //query_bktcourt(); 

if ( isset($_GET['randomNum'])) {
	$numGet = $_GET['randomNum'];
	$numRan = rand(10,100);
	
	$tmp = $numGet - $numRan;//40-??
	
	$cnt = 0;
	while($tmp>0){
		$tmp--;
		$cnt++;
	}
	die( json_encode( array( 'status' => 'results', 'lastId' => $cnt, 'timestamp' => time() ) ) );

}

?>
	