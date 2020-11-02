<?php 

namespace App\Services;

/**
 * flyhub service class
 */
class Flyhub
{

	protected $token;
	
	function __construct()
	{
		$this->token = env("flyhub_token");
	}

	protected function query(string $endpoint, array $data = array())
	{                                                               
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $endpoint,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode($data),
		  CURLOPT_HTTPHEADER => array(
		    "authorization: Bearer " . $this->token,
		    "cache-control: no-cache",
		    "content-type: application/json",
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			throw new Exception("Error Processing flyhub Request", 1);
		}

		return json_decode($response);
	}

	public function search($data)
	{
		return $this->query("http://api.sandbox.flyhub.com/api/v1/AirSearch", $data);
	}
}