<?php
/**
 * Code by: Edgars Pocs (www.baltgro.lv edgars@baltgroup.eu)
 
 *	010011000110000101110011011101000010000001
 *	110101011100000110010001100001011101000110
 *	010100111010001000000011001000110011001011
 *	100011000100110010001011100011001000110000
 *	0011000100110110

**/

include 'cloudflareapi.php';


$cf = new cloudflareapi('cloudflare@email.com', 'apikey', 'domain');

$send = $cf2->dns_records();

/*
	ieraksta tips, 
	ieraksta saturs (IP), 
	TTL, 
*/
$send = $cf->dns_records_create('email.com', 'A', 'subdomain', '123.123.123.123', 1, 0);

/*
	ieraksta saturs (IP)
	TTL
*/
$send = $cf->dns_records_update('email.com', 'A', 'id', 'subdomain', '123.123.123.123', 1, 0);

/*
*/
$send = $cf2->dns_records_delete('id');


/*
*/
$send = json_decode($send, true);
if($send['success']){
}elseif($send['errors']){
	$errors = '';
	foreach($send['errors'] as $key => $value){
		$errors.= $value['message'] . '<br/>';
	}
	
}

