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


// norādām cloudflare profila e-pastu, api key (atrodams profila iestatījumos) un domēnu, 
// lai iegūtu -identifier- kodu. 
$cf = new cloudflareapi('cloudflare@email.com', 'apikey', 'domain');

// Iegūstam visus domēna DNS ierakstus
$send = $cf2->dns_records();

// DNS ieraksta pievienošana domēnam. 
/*
	domēns, 
	ieraksta tips, 
	DNS ieraksts (subdomēns), 
	ieraksta saturs (IP), 
	TTL, 
	proxied (1 - Cloudflare CDN; 0 - pa tiešo)
*/
$send = $cf->dns_records_create('email.com', 'A', 'subdomain', '123.123.123.123', 1, 0);

// DNS ieraksta labošana
/*
	domēns
	ieraksta tips (nav iespējams labot, atgriezīs kļūdu)
	ieraksta unikālais ID (ir iespēja iegūt, izmantojot -dns_records()- funkciju (['result']['id'])
	DNS ieraksts (subdomēns)
	ieraksta saturs (IP)
	TTL
	proxied (1 - Cloudflare CDN; 0 - pa tiešo)
*/
$send = $cf->dns_records_update('email.com', 'A', 'id', 'subdomain', '123.123.123.123', 1, 0);

// Dzēšam DNS ierakstu no domēna
/*
	ieraksta unikālais ID (ir iespēja iegūt, izmantojot -dns_records()- funkciju (['result']['id'])
*/
$send = $cf2->dns_records_delete('id');


/*
	Paraugs vienkāršai pieprasījuma apstrādei
*/
$send = json_decode($send, true);
if($send['success']){
	echo 'Domēna ieraksti veiksmīgi saglabāti!'
}elseif($send['errors']){
	$errors = '';
	foreach($send['errors'] as $key => $value){
		$errors.= $value['message'] . '<br/>';
	}
	
	echo 'Kaut kas nogāja greizi!<br/><b>'.$errors.'</b>';
}

// Paraugi nav pārbaudīti. Ja kaut kas nedarbojas kā vajadzētu, dod ziņu vai izlabo pats. :)