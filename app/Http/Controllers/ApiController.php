<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Capsule;
use App\Mission;

class ApiController extends Controller
{
    public function saveData()
    {
    	$URL='https://api.spacexdata.com/v3/capsules';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$URL);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		$result=curl_exec ($ch);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
		curl_close ($ch);
		
		// return $result;
		$spacexdata = json_decode($result);

		for ($i=0; $i < count($spacexdata); $i++) {	
			
			$capsule = new Capsule();
			$capsule->capsule_id = $spacexdata[$i]->capsule_id;
			$capsule->capsule_serial = $spacexdata[$i]->capsule_serial;
			$capsule->capsule_id = $spacexdata[$i]->capsule_id;
			$capsule->status = $spacexdata[$i]->status;
			$capsule->original_launch = $spacexdata[$i]->original_launch;
			$capsule->original_launch_unix = $spacexdata[$i]->original_launch_unix;
			$capsule->landings = $spacexdata[$i]->landings;
			$capsule->type = $spacexdata[$i]->type;
			$capsule->details = $spacexdata[$i]->details;
			$capsule->reuse_count = $spacexdata[$i]->reuse_count;
			$capsule->save();
			
			$missions = $spacexdata[$i]->missions;
			if(!empty($missions)){
				for ($j=0; $j < count($missions); $j++) {
					$mission = new Mission();
					$mission->capsule_id = $capsule->id;
					$mission->name = $missions[$j]->name;
					$mission->flight = $missions[$j]->flight;
					$mission->save();
				}
			}
		}

		return response()->json(['message' => 'Successfully created Capsule!'], 201);
    }

    public function capsules(Request $request)
    {
    	if($request->status){
    		$getAllCapsules = Capsule::with(['getMissions' => function($query){
	    		$query->select('capsule_id','name','flight');
	    	}])->where('status', $request->status)->get();
    	}else{
    		$getAllCapsules = Capsule::with(['getMissions' => function($query){
	    		$query->select('capsule_id','name','flight');
	    	}])->get();
    	}    	
    	return response()->json(['message' => 'Successfully', 'data' => $getAllCapsules]);
    }


    public function capsuleDetail($capsule_serial)
    {
    	$getcapsuleDetail = Capsule::with(['getMissions' => function($query){
    		$query->select('capsule_id','name','flight');
    	}])->where('capsule_serial', $capsule_serial)->first();
    	return response()->json(['message' => 'Successfully', 'data' => $getcapsuleDetail]);
    }
}
