<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
            // dd($request->header());
            $event_dd = [
                'api_key_id' => 0,
                'api_address' => $request->header('host'),
                'url' => $request->url(),
                'user_agent' =>json_encode($request->header('user_agent')),
            ];
            $event_id = DB::table('api_event_histories')->insertGetId($event_dd);

            $keys = DB::table('api_keys')->select('id','key')->get();
            $result = false;
            foreach ($keys as $k){
            if ($k->key == $request->header('api_key')) {
                // update api_key_id if authorized
                DB::table('api_event_histories')->where('id', $event_id)->update(['api_key_id' => $k->id]);
                $result = true;
                break;
            }
        }

            if($result){
                return $next($request);
            }else{
                // dd($keys);
                $data = [
                    'status' => 200,
                    'message' => 'Project Unauhorized!',
                    'user_agent' =>json_encode($request->header('user_agent')),
                ];
                return response()->json($data);
            }
        
    }
}