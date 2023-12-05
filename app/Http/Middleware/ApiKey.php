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
        // $keys = DB::talbe('api_keys')->select('key')->get();
        // $result = false;
        // foreach ($keys as $k){
        //     if ($k->key == $request->header('api_key')) {
        //         $result = true;
        //         break;
        //     }
        // }

        if($request->header('api_key') == "123"){
            return $next($request);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Project Unauhorized!'
            ], 404);
        }
    }
}