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
    public function index(Request $request) {
        $this->validate($request, [
            'user_id' => 'required',
        ]);
        $user_id = $request->input('user_id');
        $value = Cache::has($user_id)?json_decode(Cache::get($user_id),1):[];
        return response()->json($value);
    }

    /**
     * Add a user's preference.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'user_id' => 'required',
            'user_preference' => 'required'
        ]);
        $user_id = $request->input('user_id');
        $user_preference = $request->input('user_preference');
        $value = json_decode(Cache::get($user_id), 1);
        if(empty($value) || !in_array($user_preference,$value)) {
            $value[] = $user_preference;
            Cache::forever($user_id, json_encode($value));
        }        
        return response()->json($value);
    }
    
    /**
     * Delete a user's preference.
     *
     * @return Response
     */
    public function destroy(Request $request) {
        $this->validate($request, [
            'user_id' => 'required',
            'user_preference' => 'required',
            '_method'=>'required|in:DELETE'
        ]);
        $user_id = $request->input('user_id');
        $user_preference = $request->input('user_preference');
        if(!Cache::has($user_id)) {
            return response()->json([]);
        }
        $value = json_decode(Cache::get($user_id), 1);
        $find_key=array_search($user_preference,$value);
        if($find_key!==false) {
            unset($value[$find_key]);
            Cache::forever($user_id, json_encode($value));
        }        
        return response()->json($value);
    }

}
