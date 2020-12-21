<?php

require_once('config.php');

$listing_reference = "23011";


$data = json_encode(array("listing_reference" => $listing_reference,), true);

$url = "https://realtime-listings-api.webservices.zpg.co.uk/sandbox/v1/listing/delete";
 
$data_json =  $data;
 
$tuCurl = curl_init();
curl_setopt($tuCurl, CURLOPT_URL, "https://realtime-listings-api.webservices.zpg.co.uk/sandbox/v1/listing/delete");
curl_setopt($tuCurl, CURLOPT_PORT , 443);
curl_setopt($tuCurl, CURLOPT_VERBOSE, 0);
curl_setopt($tuCurl, CURLOPT_HEADER, 0);
curl_setopt($tuCurl, CURLOPT_SSLVERSION, 6);
curl_setopt($tuCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($tuCurl, CURLOPT_SSLKEY, SSLKEY);
curl_setopt($tuCurl, CURLOPT_CAINFO, CAINFO);
curl_setopt($tuCurl, CURLOPT_SSLCERTTYPE, SSLCERTTYPE);
curl_setopt($tuCurl, CURLOPT_SSLCERT, SSLCERT);
curl_setopt($tuCurl, CURLOPT_POST, 1);
curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($tuCurl, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($tuCurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json;profile=http://realtime-listings.webservices.zpg.co.uk/docs/v1.1/schemas/listing/delete.json', 'Content-Length: ' . strlen($data_json)));
$tuData = curl_exec($tuCurl);
if(!curl_errno($tuCurl)){
 $info = curl_getinfo($tuCurl);
 $dec = json_decode($tuData);
 ?>
<!DOCTYPE html>
<html>
<head>
<title>Delete listing</title>
</head>
<body>
<h1><?php if($dec->status == "OK"){ echo "Deletion Successfull!"; }else{ echo "ID does not exits please check"; } ?></h1>
<?php if($dec->listing_reference != ""){ ?>
<p><span>listing_reference: </span><?php echo $dec->listing_reference; ?></p>
<?php } ?>
<?php if($dec->status != ""){ ?>
<p><span>status: </span><?php echo $dec->status; ?></p>
<?php } ?>
</body>
</html> 
 <?php 
 //echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'] . "\n";
 //echo "response body is::\n" . $tuData;
} else {
 //echo 'Curl error: ' . curl_error($tuCurl);
}
curl_close($tuCurl);
//echo $tuData;
?>