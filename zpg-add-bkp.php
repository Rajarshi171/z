<?php

require_once('config.php');

require_once('get_data.php');

$arr = get_data('23070');

//print_r($arr);

//echo $arr->property->details->housing_benefit_considered;

//print_r($arr->property->media);

$listing_reference = $arr->property->agent_ref;
$property_type = "block_of_flats";
$life_cycle_status = ($arr->property->status == 1) ? "available" : "let";
$new_home = ($arr->property->new_home == "") ? false : true;
$category = "commercial";
$dt = $arr->property->update_date;
$dtar = explode(" ",$arr->property->update_date);
$nwdt = date("Y-m-d", strtotime($dtar[0]) );
$available_from_date = $nwdt."T".$dtar[1];
$tenant_eligibility = array( "dss" => ($arr->property->details->housing_benefit_considered == "") ? "excluded" : "accepted", "students" => ($arr->property->student_property == 1) ? "accepted" : "excluded" );
$location = array( "property_number_or_name" => $arr->property->address->house_name_number, "street_name" => $arr->property->address->address_2, "town_or_city" => $arr->property->address->town, "postal_code" => $arr->property->address->postcode_1." ".$arr->property->address->postcode_2, "country_code" => ($arr->branch->overseas == "") ? "GB-BIR" : "US", "coordinates" => array("latitude" => (float)$arr->property->address->latitude, "longitude" => (float)$arr->property->address->longitude));
$pricing = array( "transaction_type" => ($arr->property->details->business_for_sale == "") ? "rent" : "sale" , "currency_code" => ($arr->branch->overseas == "") ? "GBP" : "USD", "price" => (float)$arr->property->price_information->price, "price_qualifier" => "fixed_price", "rent_frequency" => ($arr->property->price_information->rent_frequency == "12") ? "per_year" : "per_month" );
$display_address = $arr->property->address->town." ".$arr->property->address->postcode_2;
$detailed_description = array(array( "text" => $arr->property->details->summary));
$summary_description = $arr->property->details->description;
$available_bedrooms = (int)$arr->property->details->bedrooms;
$feature_list = $arr->property->details->features;
$furnished_state = ($arr->property->details->furnished_type == 0) ? "unfurnished" : "furnished";
$pets_allowed = ($arr->property->details->pets_allowed == "") ? false : true;
$shared_accommodation = ($arr->property->details->sharers_considered == "") ? false : true;
$burglar_alarm = ($arr->property->details->burglar_alarm == "") ? false : true;
$bills_included = array();
if($arr->property->details->water_bill_inc == 1){
array_push($bills_included,"water");	
}
if($arr->property->details->gas_bill_inc == 1){
array_push($bills_included,"gas");	
}
if($arr->property->details->electricity_bill_inc == 1){
array_push($bills_included,"electricity");	
}
if($arr->property->details->sat_cable_tv_bill_inc == 1){
array_push($bills_included,"satellite_cable_tv");	
}
if($arr->property->details->tv_licence_inc == 1){
array_push($bills_included,"tv_licence");	
}
if($arr->property->details->internet_bill_inc == 1){
array_push($bills_included,"internet");	
}
$business_for_sale = ($arr->property->details->business_for_sale == "") ? false : true;
$content = array();

foreach ($arr->property->media as $a){
	$marr = array("url" => $a->media_url , "type" => "image");
	array_push($content,$marr);	
}

$msg = array("branch_reference" => branch_reference);

if(!empty($category)){
	$msg["category"] = $category;	
}
if(!empty($listing_reference)){
	$msg["listing_reference"] = $listing_reference;	
}
if(!empty($property_type)){
	$msg["property_type"] = $property_type;	
}
if(!empty($life_cycle_status)){
	$msg["life_cycle_status"] = $life_cycle_status;	
}
if(!empty($new_home)){
	$msg["new_home"] = $new_home;	
}
if(!empty($available_from_date)){
	$msg["available_from_date"] = $available_from_date;	
}
if(!empty($tenant_eligibility)){
	$msg["tenant_eligibility"] = $tenant_eligibility;	
}
if(!empty($location)){
	$msg["location"] = $location;	
}
if(!empty($pricing)){
	$msg["pricing"] = $pricing;	
}
if(!empty($display_address)){
	$msg["display_address"] = $display_address;	
}
if(!empty($detailed_description)){
	$msg["detailed_description"] = $detailed_description;	
}
if(!empty($summary_description)){
	$msg["summary_description"] = $summary_description;	
}
if(!empty($available_bedrooms)){
	$msg["available_bedrooms"] = $available_bedrooms;	
}
if(!empty($feature_list)){
	$msg["feature_list"] = $feature_list;	
}
if(!empty($furnished_state)){
	$msg["furnished_state"] = $furnished_state;	
}
if(!empty($pets_allowed)){
	$msg["pets_allowed"] = $pets_allowed;	
}
if(!empty($shared_accommodation)){
	$msg["shared_accommodation"] = $shared_accommodation;	
}
if(!empty($burglar_alarm)){
	$msg["burglar_alarm"] = $burglar_alarm;	
}
if(!empty($bills_included)){
	$msg["bills_included"] = $bills_included;	
}
if(!empty($business_for_sale)){
	$msg["business_for_sale"] = $business_for_sale;	
}
if(!empty($content)){
	$msg["content"] = $content;	
}


$data = json_encode($msg, true);

$url = "https://realtime-listings-api.webservices.zpg.co.uk/sandbox/v1/listing/update";
 
$data_json =  $data;
 
$tuCurl = curl_init();
curl_setopt($tuCurl, CURLOPT_URL, "https://realtime-listings-api.webservices.zpg.co.uk/sandbox/v1/listing/update");
curl_setopt($tuCurl, CURLOPT_PORT , 443);
curl_setopt($tuCurl, CURLOPT_VERBOSE, 0);
curl_setopt($tuCurl, CURLOPT_HEADER, 0);
curl_setopt($tuCurl, CURLOPT_SSLVERSION, 6);
curl_setopt($tuCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($tuCurl, CURLOPT_SSLKEY,  SSLKEY);
curl_setopt($tuCurl, CURLOPT_CAINFO, CAINFO);
curl_setopt($tuCurl, CURLOPT_SSLCERTTYPE, SSLCERTTYPE);
curl_setopt($tuCurl, CURLOPT_SSLCERT,  SSLCERT);
curl_setopt($tuCurl, CURLOPT_POST, 1);
curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($tuCurl, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($tuCurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json;profile=http://realtime-listings.webservices.zpg.co.uk/docs/v1.1/schemas/listing/update.json', 'Content-Length: ' . strlen($data_json), 'ZPG-Listing-ETag: '. md5($data_json)));
$tuData = curl_exec($tuCurl);
if(!curl_errno($tuCurl)){
 $info = curl_getinfo($tuCurl);
 $dec = json_decode($tuData);
 print_r($dec); 
 ?>

 <?php 
 //echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'] . "\n";
 //echo "response body is::\n" . $tuData;
} else {
 echo 'Curl error: ' . curl_error($tuCurl);
}
curl_close($tuCurl);
//echo $tuData;
?>