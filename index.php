<?php
ini_set('max_execution_time', 3600);
/*
LICENSE GNU/GPL BUT DON'T REMOVE THIS AUTHOR
CREATED BY : tomo.logos@gmail.com
*/
//CHANGE BELOW ONLY, ubah 
$result = curl_this(
					'http://stikes-bu.hotspot/login', //login_url
					'http://stikes-bu.hotspot/status', //status_url
					'//table/tr', //extract specific part
					'//table/tbody/tr' //extract specific part
			);

			
			
//DON'T CHANGE BELOW!! 
echo "<html><head><title>STATUS KONEKSI</title><meta charset='UTF-8'>";
echo '<meta http-equiv="refresh" content="0.39"></head><body>'; //change the interval like what you need!
function curl_this($login_url='',$status_url='',$table1='',$table2=''){
	$ch = curl_init ($status_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
	$page = curl_exec($ch);
	if(empty($page)) {$ch = curl_init ($login_url);}
	$dom = new DOMDocument();
	libxml_use_internal_errors(true);
	$dom->loadHTML($page);
	libxml_clear_errors();
	$xpath = new DOMXpath($dom);
	
	$data = array();
	
	$table_rows = $xpath->query($table1);
	foreach($table_rows as $row => $tr) {
		foreach($tr->childNodes as $td) {
			$data[$row][] = preg_replace('~[\r\n]+~', '', trim($td->nodeValue));
		}
		$data[$row] = array_values(array_filter($data[0])); // ada sedikit perubahan disini
	}
	$table_rows = $xpath->query($table2);
	foreach($table_rows as $row => $tr) {
		foreach($tr->childNodes as $td) {
			$data[$row][] = preg_replace('~[\r\n]+~', '', trim($td->nodeValue));
		}
		$data[$row] = array_values(array_filter($data[0])); // ada sedikit perubahan disini
	}
	
	return $data;
}
//mulai program mencari sekolah
//mengekstrak nama kecamatan

echo '<table style="margin:auto;margin-top:15%;border-collapse:collapse;border-spacing:0;border-color:#bbb;border-width:1px;border-style:solid"><tr><th style="font-family:Arial, sans-serif;font-size:20px;font-weight:bold;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#bbb;color:#493F3F;background-color:#38fff8;text-align:center;vertical-align:top" colspan="3">STATUS KONEKSI<br></th></tr><tr><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#bbb;color:#594F4F;background-color:#34cdf9;text-align:center;vertical-align:top" colspan="3">'.$result[0][0].'</td></tr><tr><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#bbb;color:#594F4F;background-color:#34cdf9;text-align:center;vertical-align:top">Upload/Download</td><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#bbb;color:#594F4F;background-color:#34cdf9;text-align:center;vertical-align:top">'.$result[0][2].'</td><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#bbb;color:#594F4F;background-color:#34cdf9;text-align:center;vertical-align:top">'.$result[0][3].'</td></tr><tr><td style="font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#bbb;color:#594F4F;background-color:#67fd9a;font-weight:bold;text-align:center;vertical-align:top" colspan="3">DIBUAT OLEH : TOMO<br></td></tr></table>';

echo '</body></html>';
?>