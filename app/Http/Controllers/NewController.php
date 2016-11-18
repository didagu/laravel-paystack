<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NewController extends Controller
{
    public function index(){
    	//load environment variables
    	$upThree = realpath(__DIR__ . '/../../..');
		$dotEnvConfig = new \Dotenv\Dotenv($upThree);
		$dotEnvConfig->load();

	    //create paystack lib object
		$paystack_lib_object = \MAbiola\Paystack\Paystack::make();

		//get customer email
		$customer_email = $_POST['email'];

		//create transaction
		try {
		    $authorization = $paystack_lib_object->startOneTimeTransaction('20000', $customer_email);
		    //we should probably save the reference and email here so we can match/update records
		    //redirect to payment authorization URL
		    return redirect($authorization['authorization_url']);
		} catch (Exception $e) {
			// if this does not work use redirect
		    header("Location: error.php?error={$e->getMessage()}");
		}
	}

	public function access($id=null){
		//load environment variables
    	$upThree = realpath(__DIR__ . '/../../..');
		$dotEnvConfig = new \Dotenv\Dotenv($upThree);
		$dotEnvConfig->load();

	    //create paystack lib object
		$paystack_lib_object = \MAbiola\Paystack\Paystack::make();

		try {
			$verification = $paystack_lib_object->verifyTransaction(Input::get('trxref'));
			//if verification successful
	    if ($verification) {
	        //update customer records in db, probably add authorization for next time
	 
	        //redirect to a thank you page
	        return redirect('thank_you');
	    } else {
	        return redirect('error');
	    	}
 
		} catch (Exception $e) {
			// if this does not work use redirect
    		header("Location: error.php?error={$e->getMessage()}");

			}      
	}
}
