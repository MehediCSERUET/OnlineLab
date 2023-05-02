<?php
// This class has all the necessary code for making API calls thru curl library

class CurlHelper {

// This method will perform an action/method thru HTTP/API calls
// Parameter description:
// Method= POST, PUT, GET etc
// Data= array("param" => "value") ==> index.php?param=value
public static function perform_http_request($language, $version, $script, $input)
{
    $ClientID1 = "your client ID1";
    $ClientSecret1 = "your client secret1";
    
    $ClientID2 = "your client ID1";
    $ClientSecret2 = "your client secret2";

    $credit = json_encode(array("clientId"=>$ClientID1,"clientSecret"=>$ClientSecret1)); 
    $number_of_used = -1;
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.jdoodle.com/v1/credit-spent",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $credit,
        CURLOPT_HTTPHEADER => array("cache-control: no-cache","content-type: application/json"),
        CURLOPT_SSL_VERIFYPEER => false
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } 
    else {
        $number_of_use = json_decode($response, true)["used"];
    }

    if($number_of_use == 200){
        $clientId = $ClientID2;
        $clientSecret = $ClientSecret2;
    } else {
        $clientId = $ClientID1;
        $clientSecret = $ClientSecret1;
    }


    $data = json_encode(array("clientId"=>$clientId,"clientSecret"=>$clientSecret,"script"=> $script,"stdin"=>$input,"language"=>$language,"versionIndex"=>$version));

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.jdoodle.com/v1/execute",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array("cache-control: no-cache","content-type: application/json"),
        CURLOPT_SSL_VERIFYPEER => false
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } 
    else {
        return $response;
    }
}

}

//https://stackoverflow.com/questions/53063191/curl-is-not-returning-correct-response-when-json-data-is-passed-through-variable

?>
