<?php
session_start();
include(realpath( dirname( __FILE__ ) ).'\..\config\config.php');
/**
 * Class Name  : Api
 */
class ApiClient
{	
	protected $endpoint 	= "";	
	protected $org_id 		= "";
	protected $username 	= "";
	protected $password 	= "";
	protected $tokenType 	= "";
	protected $Token 		= "";
	protected $refresh_token = "";
	protected $client_id 	= "";
	protected $client_secret= "";
	function __construct($org_id, $username, $password, $client_id, $client_secret)
	{	
		$this->org_id 	= $org_id;
		$this->username = $username;
		$this->password = $password;
		$this->client_id= $client_id;
		$this->client_secret = $client_secret;
		$this->endpoint =  "https://" . SERVICEURL . "/api/1.0";	
	}

	/*
	 * @Name 		getClient
	 * @params 		string 	$url
	 * @return 		mixed
	 */	
	function getClient($url){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		/* set headers*/
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/x-www-form-urlencoded',
			'Accept :application/json',
		));
		return $ch;
	}

	function _exec($ch){
		$res = curl_exec($ch);
		curl_close($ch);
		return $res;
	}

	function _error($resdt){
		if (isset($resdt->error)){
			// echo $resdt->error . "\r\n";
			return true;
		}
		return false;
	}

	/*
	 * @Name 		_POST
	 * @params 		string 	$url, array   body
	 * @return 		mixed
	 */
	public function _POST($url, $body, $is_login = false){
				
		$ch = $this->getClient($url);
		if (!$is_login){
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			    'Content-Type: application/json',
				'Accept :application/json',
			));			
		}
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		return $this->_exec($ch);
	}

	/*
	 * @Name 	: _GET
	 * @params 	: url , body
	 * @return 	: mixed
	 */
	public function _GET($url){
		$ch  = $this->getClient($url);
		return $this->_exec($ch);
	}

	/*
	 * @Name 		_PUT
	 * @params 		string $url , array body
	 * @return 		mixed
	 */
	public function _PUT($url, $body){
		$ch = $this->getClient($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($body));
		return $this->_exec($ch);
	}

	/*
	 * @Name 		_DELETE
	 * @params 		url
	 * @return 		mixed
	 */
	public function _DELETE($url){
		$ch = $this->getClient($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		return $this->_exec($ch);
	}


	/*
	 * @Name 		Login
	 * @params 		none
	 * @return 		mixed
	 */
	public function Login(){		
		$fields = array(
			'org_id'	=> $this->org_id,
			'username'	=> $this->username,
			'password'	=> $this->password,
		);

		$loginUrl = $this->endpoint . "/login.php";
		$res = $this->_POST($loginUrl, http_build_query($fields), true);

		$resdt = json_decode($res);
		if ($this->_error($resdt)){			
			return false;
		}else{
			$this->Token 		= $resdt->access_token;
			$this->refresh_token= $resdt->refresh_token;
			$this->tokenType 	= $resdt->token_type;
			$_SESSION['user'] = $this->username;
			// echo "Successfully login!\r\n";
			return true;
		}
	}

	/*
	 * @Name 		ReLogin
	 * @params 		none
	 * @return 		mixed
	 */
	public function ReLogin(){		
		$fields = array(			
			'grant_type' 	=> 'refresh_token',
			'client_id' 	=> $this->client_id,
			'client_secret' => $this->client_secret,
			'refresh_token' => $this->refresh_token
		);
		$Url = $this->endpoint . "/token.php";
		$res = $this->_POST($Url, $fields);
		$resdt = json_decode($res);
		if ($this->_error($resdt)){
			exit;
		}else{
			$this->Token 		= $resdt->access_token;
			$this->refresh_token= $resdt->refresh_token;
			$this->tokenType 	= $resdt->token_type;
			echo "Successfully token refreshed!\r\n";
		}
	}

	/*
	 * @Name 		getMetadata
	 * @params 		string 		$nameOfobj  	Name of Objects
	 * @return 		mixed
	 */
	public function _Metadata($nameOfobj){
		$url = $this->endpoint . "/metadata.php/" . $nameOfobj;
		$res = $this->_GET($url);
		$resdt = json_decode($res);
		if ($this->_error($resdt)){
			return null;
		}
		return $resdt;
	}

	/*
	 * @Name   getAll 
	 * @param  string 		$nameOfobj  	Name of Object
	 * @return mixed
	 */
	public function _AllObjects($nameOfobj){
		$url = $this->endpoint . "/index.php/" . $nameOfobj . "/all?access_token=" . $this->Token;
		$res = $this->_GET($url);
		$resdt = json_decode($res);
		if ($this->_error($resdt)){
			return null;
		}else{
			return $resdt;
		}
	}

	/*
	 * @Name  	getAllLead
	 * @params  None
	 * @return  mixed
	 */
	public function getAllLeads(){
		$res = $this->_AllObjects("lead");
		return $res;
	}

	/*
	 * @Name  	getDeviceRegistry
	 * @params  None
	 * @return  mixed
	 */
	public function getAllDeviceRegistry(){
		$res = $this->_AllObjects("device-registry");
		// var_dump($res);
		return $res;
	}

	/*
	 * @Name  	insertDeviceRegistry
	 * @params  $fields
	 * @return  mixed
	 */
	public function insertDeviceRegistry($fields){		
		$url = $this->endpoint . "/index.php/device-registry?access_token=" . $this->Token;
		$res = $this->_POST($url, json_encode($fields));
		return json_decode($res);
	}


	/*
	 * @Name  	getAllFacilities
	 * @params  None
	 * @return  mixed
	 */
	public function getAllFacilities(){		
		$res = $this->_AllObjects("facility");
		return $res;
	}

	/*
	 * @Name  	getAllContacts
	 * @params  None
	 * @return  mixed
	 */
	public function getAllContacts(){		
		$res = $this->_AllObjects("contact");
		return $res;
	}

}