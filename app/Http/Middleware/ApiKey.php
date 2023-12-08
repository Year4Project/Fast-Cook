<?php

namespace App\Http\Middleware;

use App\Models\ApiKey as ModelsApiKey;
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
            // $event_dd = [
            //     'api_key_id' => 0,
            //     'api_address' => $request->header('host'),
            //     'url' => $request->url(),
            //     'user_agent' =>json_encode($request->header('user_agent')),
            // ];
            // $event_id = DB::table('api_event_histories')->insertGetId($event_dd);

            $apiKey = $request->header('X-API-Key');

            if (!$apiKey || !ModelsApiKey::where('key', $apiKey)->exists()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
    
            return $next($request);
        
        
    }
}