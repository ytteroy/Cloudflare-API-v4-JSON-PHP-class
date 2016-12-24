<?php
/**
 * Code by: Edgars Pocs (www.baltgro.lv edgars@baltgroup.eu)
 
 *	010011000110000101110011011101000010000001
 *	110101011100000110010001100001011101000110
 *	010100111010001000000011001000110011001011
 *	100011000100110010001011100011001000110000
 *	0011000100110110

**/

class cloudflareapi {
	const CFURL = 'https://api.cloudflare.com/client/v4'; // API URL
	
	
	public function __construct($email, $key, $domain){
		$parameters = func_get_args();
		
		$this->email     = $email;
		$this->token_key = $key;
		$this->zone = $this->identifier($domain);
	}
	
	public function getzone($domain){
		$result = $this->curlGET('/zones?name=' . $domain);
		$result = json_decode(json_encode($result), true);
		return $result;
	}
	
	public function identifier($domain){
		$zone = $this->getzone($domain);
		$zone = json_decode($zone, true);
		
		return $zone['result'][0]['id'];
	}
	
	
    public function getUserDetail($email, $api) {
		$result = $this->curlGET('/user');
        return $result;
    }
	
    public function dns_records() {
		$result = $this->curlGET('/zones/'.$this->zone.'/dns_records');
        return $result;
    }
	
	public function dns_records_create($domain, $type, $name, $content, $ttl, $proxied) {
		$proxied = ($proxied == 1 ? true : false);
		
		$data = json_encode([
			'type' => $type,
			'name' => $name,
			'content' => $content,
			'ttl' => $ttl,
			'proxied' => $proxied
		]);
		
		$result = $this->curlPOST('/zones/'.$this->zone.'/dns_records/', $data);
        return $result;
    }
	
	public function dns_records_update($domain, $type, $identifier, $name, $content, $ttl, $proxied) {
		$proxied = ($proxied == 1 ? true : false);
		
		$data = json_encode([
			'type' => $type,
			'name' => $name,
			'content' => $content,
			'ttl' => $ttl,
			'proxied' => $proxied
		]);
		
		$result = $this->curlPUT('/zones/'.$this->zone.'/dns_records/' . $identifier, $data);
        return $result;
    }
	
	public function dns_records_delete($identifier) {
		$result = $this->curlDELETE('/zones/'.$this->zone.'/dns_records/' . $identifier);
        return $result;
    }
	
	
    public function curlGET($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::CFURL . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        $headers = array(
            'X-Auth-Email: ' . $this->email,
            'X-Auth-Key: ' . $this->token_key,
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode(json_encode($result), true);
    }
	
	public function curlPOST($url, $json = []) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::CFURL . $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = array(
			'X-Auth-Email: ' . $this->email,
			'X-Auth-Key: ' . $this->token_key,
			'Content-Type: application/json'
		);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		curl_close($ch);
		
		return json_decode(json_encode($result), true);
    }
	
	public function curlPUT($url, $json = []) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::CFURL . $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = array(
			'X-Auth-Email: ' . $this->email,
			'X-Auth-Key: ' . $this->token_key,
			'Content-Type: application/json'
		);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		curl_close($ch);
		
		return json_decode(json_encode($result), true);
    }
	
	public function curlPATCH($url, $json = []) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::CFURL . $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = array(
			'X-Auth-Email: ' . $this->email,
			'X-Auth-Key: ' . $this->token_key,
			'Content-Type: application/json'
		);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		curl_close($ch);
		
		return json_decode(json_encode($result), true);
    }
	
	public function curlDELETE($url, $json = []) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::CFURL . $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = array(
			'X-Auth-Email: ' . $this->email,
			'X-Auth-Key: ' . $this->token_key,
			'Content-Type: application/json'
		);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		curl_close($ch);
		
		return json_decode(json_encode($result), true);
    }
}