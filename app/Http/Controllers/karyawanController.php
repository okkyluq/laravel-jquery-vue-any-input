<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;
use Response;

class karyawanController extends Controller
{
    public function getKaryawan(Request $request)
    {
    	if ($request->cari != null) {
    		return $data =  DB::table('hrs_karyawan')->select('nik','nm_karyawan','tgl_lahir')->where('nm_karyawan', 'LIKE', '%'.$request->cari.'%')->paginate(10);
    	} else {
    		return $data =  DB::table('hrs_karyawan')->select('nik','nm_karyawan','tgl_lahir')->paginate(10);
    	}
    	
    }

    public function autocomplete()
    {
    	$term = Input::get('term');


    	$results =  DB::table('hrs_karyawan')->select('nik','nm_karyawan','tpt_lahir')->where('nm_karyawan', 'LIKE', '%'.$term.'%')->get();

  //   	foreach ($queries as $query){
	 //    	$results[] = ['nm_karyawan' => $query->nm_karyawan];
		// }
		// return Response::json($queries);
        return response()->json($results);
        // echo json_encode($queries);
    }
}
