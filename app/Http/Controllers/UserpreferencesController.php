<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserpreferencesController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Get user preferences.
     *
     * @return Response
     */
    public function index($userid) {
        $value = Cache::has($userid)?json_decode(Cache::get($userid),1):[];
        return response()->json($value);
    }

    /**
     * Add a user's preference.
     *
     * @return Response
     */
    public function store(Request $request,$userid) {
        $this->validate($request, [
            'user_preference' => 'required'
        ]);
        $user_preference = $request->input('user_preference');
        $value = json_decode(Cache::get($userid), 1);
        $id=1;
        if(!empty($value)) {
            $id=max(array_column($value, 'id'))+1;
        }
        $value[] = ['id'=>$id,'name'=>$user_preference];
        Cache::forever($userid, json_encode($value));     
        return response()->json($value,201);
    }
    
    /**
     * Delete a user's preference.
     *
     * @return Response
     */
    public function destroy($userid,$id) {
        if(!Cache::has($userid)) {
            return response()->json([],404);
        }
        $value = json_decode(Cache::get($userid), 1);
        $id_array=array_column($value, 'id');
        if(in_array($id,$id_array)) {
            $key = array_search($id, $id_array);
            unset($value[$key]);
            Cache::forever($userid, json_encode(array_values($value)));
        } else {
            return response()->json([],404);
        }        
        return response()->json([],204);
    }
    
    /**
     * Update a user's preference.
     *
     * @return Response
     */
    public function update(Request $request,$userid,$id) {
        $this->validate($request, [
            'user_preference' => 'required'
        ]);
        $user_preference = $request->input('user_preference');
        if(!Cache::has($userid)) {
            return response()->json([],404);
        }
        $value = json_decode(Cache::get($userid), 1);
        $id_array=array_column($value, 'id');
        if(in_array($id,$id_array)) {
            $key = array_search($id, $id_array);
            $value[$key]['name']=$user_preference;
            $updated=array_values($value);
            Cache::forever($userid, json_encode($updated));
        } else {
            return response()->json([],404);
        }        
        return response()->json($updated,200);
    }

}
