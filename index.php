 <?php 

/*
authour : amit sharma 
Description : sample code for lulu.com Api  sanbox mode for cost calculations this can work with or without framework of php
kindly install Guzzlehttp\client using composer and start work  
everthing according to https://api.sandbox.lulu.com/docs.
*/
use GuzzleHttp\Client;

require 'vendor/autoload.php';


abstract  class luluApi {
	public $response;
	public $client;
	function 	__construct(){

				//O- Auth 2 Calculations 
				$this->client = new Client(['base_uri'=>"https://api.sandbox.lulu.com/"]);

				// authentication for O auth 2 
				$response = $this->client->request('POST', 
					'auth/realms/glasstree/protocol/openid-connect/token',
					 ['headers' =>[ 
					 "Content-Type"=>"application/x-www-form-urlencoded",
					 "Authorization"=>"Basic MDRhNmNlZGEtNGNkZi00YWEzLWJhMGUtYzNhZTMyYzY0YTlhOmFkNDUwNTQ3LWFlMTUtNGQ2NC05ZThjLWM3MzIxOGRkY2EyZA==" 
					],
					 'body' => 'grant_type=client_credentials',
				]);
				//echo $response->getBody();
				$this->response = json_decode($response->getBody()); 
		}

		public function getAccessCode(){ 
			return $this->response->access_token;
		}



}

//PrintJobCostCalculation  get calculations for product 
class PrintJobCostCalculation extends luluApi
{ 
	function __construct(){
		parent::__construct();
	}
    public function get($array) {  
				$response = $this->client->request('POST', 
					'print-job-cost-calculations/',
					 ['headers' =>[ 
					 "Content-Type"=>"application/json",
					 "Cache-Control" => "no-cache",
					 "Authorization"=>"Bearer ". $this->getAccessCode()
					],
					 'body' => $array,
				]);
				return $response->getBody();
    }
}
/*
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
  $var = new PrintJobCostCalculation();
   echo $var->get($array); */

// ,Create a new Print-Job
class CreatePrintJob extends luluApi
{ 
	function __construct(){
		parent::__construct();
	}
    public function get($array) { 
				$response = $this->client->request('POST', 
					'print-jobs/',
					 ['headers' =>[ 
					 "Content-Type"=>"application/json",
					 "Cache-Control" => "no-cache",
					 "Authorization"=>"Bearer ". $this->getAccessCode()
					],
					 'body' => $array,
				]);
				return $response->getBody();
    }
}
/*

      $array = '{
    "contact_email": "test@test.com",
    "external_id": "demo-time",
    "line_items": [
        {
            "external_id": "item-reference-1",
            "printable_normalization": {
                "cover": {
                    "source_url": "https://www.dropbox.com/s/7bv6mg2tj0h3l0r/lulu_trade_perfect_template.pdf?dl=1&raw=1"
                },
                "interior": {
                    "source_url": "https://www.dropbox.com/s/r20orb8umqjzav9/lulu_trade_interior_template-32.pdf?dl=1&raw=1"
                },
                "pod_package_id": "0600X0900BWSTDPB060UW444MXX"
            },
            "quantity": 30,
            "title": "My Book"
        }
    ],
    "production_delay": 120,
    "shipping_address": {
        "city": "L\u00fcbeck",
        "country_code": "GB",
        "name": "Hans Dampf",
        "phone_number": "844-212-0689",
        "postcode": "PO1 3AX",
        "state_code": "",
        "street1": "Holstenstr. 48"
    },
    "shipping_level": "MAIL"
}'; 

// $array = json_encode($array); 
  $var = new CreatePrintJob();
   echo $var->get($array);
 */



//Retrieve a list of Print-Jobs
class ListPrintJob extends luluApi
{ 
	function __construct(){
		parent::__construct();
	}
 	public function get() {
				 
				$response = $this->client->request('GET', 
					'print-jobs/',
					 ['headers' =>[ 
					 "Content-Type"=>"application/json",
					 "Cache-Control" => "no-cache",
					 "Authorization"=>"Bearer ". $this->getAccessCode()
					],
					 'body' => $array,
				]);
				return $response->getBody();
    }
}

 // $var = new ListPrintJob();
//  echo $var->get();

//Retrieve the number of Print-Jobs in each status
class StatsPrintJobs extends luluApi
{ 
	function __construct(){
		parent::__construct();
	}
 	public function get() {
				 
				$response = $this->client->request('GET', 
					'print-jobs/statistics/',
					 ['headers' =>[ 
					 "Content-Type"=>"application/json",
					 "Cache-Control" => "no-cache",
					 "Authorization"=>"Bearer ". $this->getAccessCode()
					],
					 'body' => $array,
				]);
				return $response->getBody();
    }
}
 // $var = new StatsPrintJobs();
//  echo $var->get();


//Retrieve a single Print-Job
class SinglePrintJobs extends luluApi
{ 
	function __construct(){
		parent::__construct();
	}
 	public function get($id) {
				 
				$response = $this->client->request('GET', 
					"print-jobs/$id/",
					 ['headers' =>[ 
					 "Content-Type"=>"application/json",
					 "Cache-Control" => "no-cache",
					 "Authorization"=>"Bearer ". $this->getAccessCode()
					],
					 'body' => $array,
				]);
				return $response->getBody();
    }
}
// $var = new SinglePrintJobs();
//  echo $var->get(5294);


//Retrieve Print-Job Costs
class SinglePrintJobCost extends luluApi
{ 
	function __construct(){
		parent::__construct();
	}
 	public function get($id) {
				 
				$response = $this->client->request('GET', 
					"print-jobs/$id/costs/",
					 ['headers' =>[ 
					 "Content-Type"=>"application/json",
					 "Cache-Control" => "no-cache",
					 "Authorization"=>"Bearer ". $this->getAccessCode()
					],
					 'body' => $array,
				]);
				return $response->getBody();
    }
}

// $var = new SinglePrintJobStatus();
//  echo $var->get(5294);

//Retrieve List of Shipping Options
class PrintShippingOptions extends luluApi
{ 
	function __construct(){
		parent::__construct();
	}
 	public function get() {
				 
				$response = $this->client->request('GET', 
					"print-shipping-options/",
					 ['headers' =>[ 
					 "Content-Type"=>"application/json",
					 "Cache-Control" => "no-cache",
					 "Authorization"=>"Bearer ". $this->getAccessCode()
					],
					 'body' => $array,
				]);
				return $response->getBody();
    }
}


// $var = new PrintShippingOptions();
//  echo $var->get();
 

 

  ?>
