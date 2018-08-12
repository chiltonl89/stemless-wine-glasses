<?php
require_once('../../../../wp-load.php');
global $wpdb;
// extract query
$q = stripslashes($_POST['q']);
$rows=$wpdb->get_results( $q);
$date=date("F j, Y, g:i a s");
$fname=md5($date);
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=$fname.csv");
header("Pragma: no-cache");
header("Expires: 0");

echo "DATE,ACTION,DATA,KEYWORD \n";
foreach($rows as $row){
	
	$action=$row->action;
	if (stristr($action , 'New Comment Posted on :')){
			$action = 'Posted Comment';
		}elseif(stristr($action , 'approved')){
			$action = 'Approved Comment';
	}
	
	//format date
	$date=date('Y-n-j H:i:s',strtotime ($row->date));

	$data=$row->data;
	$keyword='';
	//filter the data strip keyword
	if(stristr($data,';')){
		$datas=explode(';',$row->data);
		$data=$datas[0];
		$keyword=$datas[1];
	}
	echo "$date,$action,$data,$keyword \n";

}

//echo "record1,$q,record3\n";

?>
