<?php

require_once('config.php');

$data = json_encode(array("branch_reference" => branch_reference), true);
$url = "https://realtime-listings-api.webservices.zpg.co.uk/sandbox/v1/listing/list";
 
$data_json =  $data;
 
$tuCurl = curl_init();
curl_setopt($tuCurl, CURLOPT_URL, "https://realtime-listings-api.webservices.zpg.co.uk/sandbox/v1/listing/list");
curl_setopt($tuCurl, CURLOPT_PORT , 443);
curl_setopt($tuCurl, CURLOPT_VERBOSE, 0);
curl_setopt($tuCurl, CURLOPT_HEADER, 0);
curl_setopt($tuCurl, CURLOPT_SSLVERSION, 6);
curl_setopt($tuCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($tuCurl, CURLOPT_SSLKEY, SSLKEY);
curl_setopt($tuCurl, CURLOPT_CAINFO, CAINFO);
curl_setopt($tuCurl, CURLOPT_SSLCERTTYPE, SSLCERTTYPE);
curl_setopt($tuCurl, CURLOPT_SSLCERT,  SSLCERT);
curl_setopt($tuCurl, CURLOPT_POST, 1);
curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($tuCurl, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($tuCurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json;profile=http://realtime-listings.webservices.zpg.co.uk/docs/v1.1/schemas/listing/list.json', 'Content-Length: ' . strlen($data_json)));
$tuData = curl_exec($tuCurl);
if(!curl_errno($tuCurl)){
 $info = curl_getinfo($tuCurl);
 //echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'] . "\n";
 $ar = json_decode($tuData);
//print_r($ar);
?>
<!DOCTYPE html>
<html>
<head>
<title>View listings</title>
</head>
<body>
<h1>Branch <?php echo $ar->branch_reference; ?></h1>

<?php
foreach ($ar->listings as $a){
	echo "<p><span><strong>Etag: </strong>".$a->listing_etag."</span> &nbsp;<strong>Listing: </strong><a href=".$a->url." target='_blank'>".$a->listing_reference."</a></p>";
}
?>
</body>
</html> 
<?php
 //echo "response body is::\n" . $tuData;
} else {
 //echo 'Curl error: ' . curl_error($tuCurl);
}
curl_close($tuCurl);


?>