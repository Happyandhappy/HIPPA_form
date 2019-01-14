<?php
	require_once('Client.php');	
	echo ORGID;
	function login($cred){
		session_unset();
		if (isset($cred['email']) && isset($cred['password'])){
			$_SESSION['USERNAME'] = $cred['email'];
			$_SESSION['PASSWORD'] = $cred['password'];
			$api = new ApiClient(ORGID, $_SESSION['USERNAME'], $_SESSION['PASSWORD'], CLIENTID, CLIENTSECURITY);
			if ($api->Login()) {			
				$_SESSION['api'] = $api;
				return array('status' => 'success','message' => 'Successfully logged in!');
			}
			else array('status' => 'faild', 'message'=> 'Invalid Credentials!');;
		}else{
			return array('status' => 'faild', 'message' => 'Email and Password required!');
		}
	}

	function DeviceRegistry($fields){
		unset($fields['req_name']);
		$api = $_SESSION['api'];
        if (!isset($fields['Active'])){
            $fields['Active'] = "false";
        }else{
            $fields['Active'] = "true";
        }

        $data = array(
                "id" => "",
                "data" => $fields
        );        
        $res = $api->insertDeviceRegistry(array($data));
        if ($res[0]->status == "error"){
        	$res = array("status" => "faild", "message" => $res[0]->message);
        }
        return $res[0];
	}

	function getAllFacilities(){
		if (!isset($_SESSION['api'])) return array("status" => 'faild', 'message' => 'You need to login');		
		$api = $_SESSION['api'];
		var_dump($api);
		$res = $api->getAllFacilities();		
		var_dump($res);exit;
		$data = array();
		foreach ($res->data as $key => $value) {
			array_push($data, array("id" => $key, "value" => $value->Name));
		}
		return array("status" => "success", "message" => $data);
	}

	function getAllContacts(){
		$api = $_SESSION['api'];
		$res = $api->getAllContacts();
		var_dump($res);exit;
		$data = array();
		foreach ($res->data as $key => $value) {
			array_push($data, array("id" => $key, "value" => $value->Full_Name));
		}
		return array("status" => "success", "message" => $data);
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){		
		$name = $_POST['req_name'];

		switch ($name) {
			case 'device-registry':
				$res = DeviceRegistry($_POST);
				break;
			case 'allfacilities':
				$res = getAllFacilities();
				break;
			case 'allcontacts':
				$res = getAllContacts();
				break;
			case 'login':
				$res = login($_POST);
			default:
				# code...
				break;
		}
	}
	echo json_encode($res);
?>