 <?php 
use GuzzleHttp\Client;

 $clientKey = "04a6ceda-4cdf-4aa3-ba0e-c3ae32c64a9a";
 $clientSecret = "ad450547-ae15-4d64-9e8c-c73218ddca2d";
 $base64encode = "MDRhNmNlZGEtNGNkZi00YWEzLWJhMGUtYzNhZTMyYzY0YTlhOmFkNDUwNTQ3LWFlMTUtNGQ2NC05ZThjLWM3MzIxOGRkY2EyZA==";

  require 'vendor/autoload.php';
$client = new Client(['base_uri'=>"https://api.sandbox.lulu.com/"]);
$response = $client->request('POST', 
	'auth/realms/glasstree/protocol/openid-connect/token',
	 ['headers' =>[ 
	 "Content-Type"=>"application/x-www-form-urlencoded",
	 "Authorization"=>"Basic MDRhNmNlZGEtNGNkZi00YWEzLWJhMGUtYzNhZTMyYzY0YTlhOmFkNDUwNTQ3LWFlMTUtNGQ2NC05ZThjLWM3MzIxOGRkY2EyZA==" 
	],
	 'body' => 'grant_type=client_credentials',
]);
 

echo $response->getStatusCode(); # 200
echo $response->getHeaderLine('content-type'); # 'application/json; charset=utf8'
$var =  $response->getBody();

$var = json_decode($var);
// echo  $var->access_token;
// echo  $var->refresh_token;


$array = array("line_items"=>array( array(
"page_count"=>32,
"pod_package_id"=> "0600X0900BWSTDPB060UW444MXX", 
"quantity" => 20
) ),
"shipping_address"=>array("city"=>"Washington" ,
"country_code" => "US" , 
"postcode" => "20540" , 
"state_code" => "DC" , 
"street1" => "101 Independence Ave SE" 
) ,
"shipping_level" => "EXPRESS"
);
$array = json_encode($array);
// $v = '{
//     "line_items": [
//         {
//             "page_count": 32,
//             "pod_package_id": "0600X0900BWSTDPB060UW444MXX",
//             "quantity": 20
//         },
//         {
//             "page_count": 324,
//             "pod_package_id": "0425X0687BWSTDLW060UC444GRB",
//             "quantity": 200
//         }
//     ],
//     "shipping_address": {
//         "city": "Washington",
//         "country_code": "US",
//         "postcode": "20540",
//         "state_code": "DC",
//         "street1": "101 Independence Ave SE"
//     },
//     "shipping_level": "EXPRESS"
// }'; 
$response = $client->request('POST', 
	'print-job-cost-calculations/',
	 ['headers' =>[ 
	 "Content-Type"=>"application/json",
	 "Cache-Control" => "no-cache",
	 "Authorization"=>"Bearer ". $var->access_token
	],
	 'body' => $array,
]);
echo $response->getStatusCode();
echo $response->getBody();

  ?>