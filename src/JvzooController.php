<?php namespace Kjellberg\Jvzoo;

use App\Http\Controllers\Controller;
use App\User;

use Illuminate\Http\Request;

use App\Http\Requests;

class JvzooController extends Controller {

	public function index(Request $request) {
		
		$data = $request->all();

		if ($this->jvzipnVerification() != 1)
			die("Not a valid session");

		$transaction_type		= (isset($data['ctransaction'])?$data['ctransaction']:'SALE');

		$customer_email 		= null;
		$customer_receipt 		= null;		
		
		if ( isset($data['ccustname']) ) {
			$customer_name = $data['ccustname'];
		}

		if ( isset($data['ccustemail']) ) {
			$customer_email = $data['ccustemail'];
		}
		if ( isset($data['cemail']) ) {
			$customer_email = $data['cemail'];
		}
		if ( isset($data['ctransreceipt']) ) {
			$customer_receipt = $data['ctransreceipt'];
		}
		if ( isset($data['cbreceipt']) ) {
			$customer_receipt = $data['cbreceipt'];
		}

		if (!$customer_receipt || !$customer_email) {
			return ["error" => "Wrong request"];
		}

	    \Event::fire('jvzoo', array($data));

	    switch ($transaction_type) {

	    	case 'SALE':
	    		\Event::fire('jvzoo.sale', array($data));
	    		break;

	    	case 'BILL':
	    		\Event::fire('jvzoo.bill', array($data));
	    		break;

    		case 'RFND':
	    		\Event::fire('jvzoo.rfnd', array($data));
	    		break;

    		case 'CGBK':
	    		\Event::fire('jvzoo.cgbk', array($data));
	    		break;

    		case 'INSF':
	    		\Event::fire('jvzoo.insf', array($data));
	    		break;

    		case 'CANCEL-REBILL':
	    		\Event::fire('jvzoo.cancel.rebill', array($data));
	    		break;

    		case 'UNCANCEL-REBILL':
	    		\Event::fire('jvzoo.uncancel.rebill', array($data));
	    		break;
	    }
	    
	}

	public function jvzipnVerification() {
		
		$secretKey = env('JVZOO_KEY');

	    $pop = "";
	    $ipnFields = array();

	    foreach ($_POST AS $key => $value) {
	        if ($key == "cverify") {
	            continue;
	        }
	        $ipnFields[] = $key;
	    }

	    sort($ipnFields);

	    foreach ($ipnFields as $field) {
	        // if Magic Quotes are enabled $_POST[$field] will need to be
	        // un-escaped before being appended to $pop
	        $pop = $pop . $_POST[$field] . "|";
	    }

	    $pop = $pop . $secretKey;

	    $calcedVerify = sha1(mb_convert_encoding($pop, "UTF-8"));
	    $calcedVerify = strtoupper(substr($calcedVerify,0,8));

	    return $calcedVerify == $_POST["cverify"];
		
	}
}