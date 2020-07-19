<?php
  /*-----------------------------------------------------------------------------------------------*/  //UPLINK
  $jsdata = json_decode(file_get_contents('php://input'), true);
  //extract array $jsdata from CAT portal 
  $Time = $jsdata["DevEUI_uplink"]["Time"];
  $DevEUI = $jsdata["DevEUI_uplink"]["DevEUI"];
  $DevAddr = $jsdata["DevEUI_uplink"]["DevAddr"];
  $FPort = $jsdata["DevEUI_uplink"]["FPort"];
  $payload_hex = $jsdata["DevEUI_uplink"]["payload_hex"];

  $arr = str_split($payload_hex, 2);

  $temp = $arr[1] . "." . $arr[2];
  $humi = $arr[3] . "." . $arr[4];
  $bri  = $arr[6];
  
  if($arr[5]=="00"){
    $Zsta = "ON";
    $sta = 1;
    $pic = 1;
  }
  
  if($arr[5]=="11"){
    $Zsta = "OFF";
    $sta = 0;
    $pic = 2;
  }
  
  try 
  {
    $conn = new PDO("sqlsrv:server = tcp:testlora.database.windows.net,1433; Database = TESTLoRa", "jibjib", "S.warawut");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "successfully"."<br>";
    
    /*$sql= "UPDATE [dbo].[FinalProj]
      SET Time = '$Time', Temperature = '$temp', Humidity = '$humi', LightStatus = '$sta', Brightness = '$bri'
      WHERE DevEUI = 'FF1721AC76217370' ";*/
      
    $sql= "UPDATE [dbo].[FinalProj]
      SET Time = '$Time', Temperature = '$temp', Humidity = '$humi', LightStatus = '$sta', Brightness = '$bri'
      WHERE DevEUI = 'FF1721AC76217370' ";
      
    $conn->exec($sql);
  }
  catch (PDOException $e) 
  {
    print("Error connecting to SQL Server.");
    die(print_r($e));
    $conn = null;
  }

  $conn = new PDO("sqlsrv:server = tcp:testlora.database.windows.net,1433; Database = TESTLoRa", "jibjib", "S.warawut");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT Temperature FROM [dbo].[FinalProj] WHERE DevEUI = 'FF1721AC76217370'";
  $result = $conn->query($sql);
	foreach ($conn->query($sql) as $row) 
	{
        $tempt = $row['Temperature'];
	}
  $conn = null;

  $conn = new PDO("sqlsrv:server = tcp:testlora.database.windows.net,1433; Database = TESTLoRa", "jibjib", "S.warawut");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT Humidity FROM [dbo].[FinalProj] WHERE DevEUI = 'FF1721AC76217370'";
  $result = $conn->query($sql);
	foreach ($conn->query($sql) as $row) 
	{
        $humit = $row['Humidity'];
	}
  $conn = null;

  $conn = new PDO("sqlsrv:server = tcp:testlora.database.windows.net,1433; Database = TESTLoRa", "jibjib", "S.warawut");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT Time FROM [dbo].[FinalProj] WHERE DevEUI = 'FF1721AC76217370'";
  $result = $conn->query($sql);
	foreach ($conn->query($sql) as $row) 
	{
        $Timet = $row['Time'];
	}
  $conn = null;

  $conn = new PDO("sqlsrv:server = tcp:testlora.database.windows.net,1433; Database = TESTLoRa", "jibjib", "S.warawut");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT Brightness FROM [dbo].[FinalProj] WHERE DevEUI = 'FF1721AC76217370'";
  $result = $conn->query($sql);
	foreach ($conn->query($sql) as $row) 
	{
        $brit = $row['Brightness'];
	}
  $conn = null;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.blynk.honey.co.th/MQypVBejnpsLNIzOmyVwOl4zR8v9PkoO/update/v1?value=$tempt");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  $response = curl_exec($ch);
  curl_setopt($ch, CURLOPT_URL, "https://api.blynk.honey.co.th/MQypVBejnpsLNIzOmyVwOl4zR8v9PkoO/update/v2?value=$humit");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  $response = curl_exec($ch);
  curl_setopt($ch, CURLOPT_URL, "https://api.blynk.honey.co.th/MQypVBejnpsLNIzOmyVwOl4zR8v9PkoO/update/v5?value=$Timet");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  $response = curl_exec($ch);
  curl_setopt($ch, CURLOPT_URL, "https://api.blynk.honey.co.th/MQypVBejnpsLNIzOmyVwOl4zR8v9PkoO/update/v0?value=$Zsta");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  $response = curl_exec($ch);
  curl_setopt($ch, CURLOPT_URL, "https://api.blynk.honey.co.th/MQypVBejnpsLNIzOmyVwOl4zR8v9PkoO/update/v3?value=$sta");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  $response = curl_exec($ch);
  curl_setopt($ch, CURLOPT_URL, "https://api.blynk.honey.co.th/MQypVBejnpsLNIzOmyVwOl4zR8v9PkoO/update/v6?value=$brit");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  $response = curl_exec($ch);
  curl_setopt($ch, CURLOPT_URL, "https://api.blynk.honey.co.th/MQypVBejnpsLNIzOmyVwOl4zR8v9PkoO/update/v7?value=$pic");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  $response = curl_exec($ch);
  curl_close($ch);



  /*----------------------------------------------------------------------------------------------------*/ //DOWNLINK

  function getToken($downlink) 
  {
    $data = array("username" => "warawut", "password" => "warawut0609");
    $data_string = json_encode($data);
    $url = "https://loraiot.cattelecom.com/portal/iotapi/auth/token";

    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL,$url);
    curl_setopt($ch2, CURLOPT_POST, true); // tell curl you want to post something
    curl_setopt($ch2, CURLOPT_POSTFIELDS, $data_string); // define what you want to post
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true); // return the output in string format

    curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json')
    ); 
    $response = curl_exec($ch2);
    curl_close($ch2);

    $jsdata = json_decode($response);
    //extract array $jsdata from CAT portal 
    $AC_Token = $jsdata->access_token;
    $Type = $jsdata->token_type;
    $RE_Token = $jsdata->refresh_token;
    $Expires = $jsdata->expires_in;
    $Scope = $jsdata->scope;

    downlink_msg($downlink,$AC_Token);
  }


  function downlink_msg($downlink_msg,$token) 
  {
    if($Sli != $v4[0]){
        $data = array("payloadHex" => $downlink_msg, "targetPorts" => "2");
        $data_string = json_encode($data);
        $url = "https://loraiot.cattelecom.com/portal/iotapi/core/devices/FF1721AC76217370/downlinkMessages";
    }

    if($Sta != $v3[0]){
        $data = array("payloadHex" => $downlink_msg, "targetPorts" => "1");
        $data_string = json_encode($data);
        $url = "https://loraiot.cattelecom.com/portal/iotapi/core/devices/FF1721AC76217370/downlinkMessages";
    }

    $ch3 = curl_init();
    curl_setopt($ch3, CURLOPT_URL,$url);
    curl_setopt($ch3, CURLOPT_POST, true); // tell curl you want to post something
    curl_setopt($ch3, CURLOPT_POSTFIELDS, $data_string); // define what you want to post
    curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true); // return the output in string format

    curl_setopt($ch3, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer'.$token)
    ); 
    $response = curl_exec($ch3);
    curl_close($ch3);

    $jsdata = json_decode($response);
    //extract array $jsdata from CAT portal 
    $Payload = $jsdata->payloadHex;
    $Port = $jsdata->targetPorts;
    $Stauts = $jsdata->status;
  }

	$ch4 = curl_init();
  	curl_setopt($ch4, CURLOPT_URL, "https://api.blynk.honey.co.th/MQypVBejnpsLNIzOmyVwOl4zR8v9PkoO/get/v3");
  	curl_setopt($ch4, CURLOPT_RETURNTRANSFER, TRUE);
  	curl_setopt($ch4, CURLOPT_HEADER, FALSE);
  	$response = curl_exec($ch4);

  	$v3 = json_decode($response);
    
    $ch5 = curl_init();
  	curl_setopt($ch5, CURLOPT_URL, "https://api.blynk.honey.co.th/MQypVBejnpsLNIzOmyVwOl4zR8v9PkoO/get/v4");
  	curl_setopt($ch5, CURLOPT_RETURNTRANSFER, TRUE);
  	curl_setopt($ch5, CURLOPT_HEADER, FALSE);
  	$response = curl_exec($ch5);

  	$v4 = json_decode($response);

  	$conn = new PDO("sqlsrv:server = tcp:testlora.database.windows.net,1433; Database = TESTLoRa", "jibjib", "S.warawut");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT LightStatus FROM [dbo].[FinalProj] WHERE DevEUI = 'FF1721AC76217370'";
	$result = $conn->query($sql);
	foreach ($conn->query($sql) as $row) 
	{
        $Sta = $row['LightStatus'];
	}
	if($Sta != $v3[0])
	{
		$sql2= " UPDATE [dbo].[FinalProj]
				SET  LightStatus = '$v3[0]'
				WHERE DevEUI = 'FF1721AC76217370' ";
		$conn->exec($sql2);
		$msg = "0".$v3[0]."00";;
		getToken($msg);
    }
    $conn = null;

    $conn = new PDO("sqlsrv:server = tcp:testlora.database.windows.net,1433; Database = TESTLoRa", "jibjib", "S.warawut");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT Brightness FROM [dbo].[FinalProj] WHERE DevEUI = 'FF1721AC76217370'";
    $result = $conn->query($sql);
	foreach ($conn->query($sql) as $row) 
	{
        $Sli = $row['Brightness'];
	}
    if($Sli != $v4[0])
	{
		$sql3= " UPDATE [dbo].[FinalProj]
				SET  Brightness = '$v4[0]'
				WHERE DevEUI = 'FF1721AC76217370' ";
		$conn->exec($sql3);
        //$msg = "0"."0".$v4[0]."00";;
        $msg = $v4[0];;
		getToken($msg);
	}
    $conn = null;
    

   
?>










