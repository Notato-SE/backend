<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // header("Access-Control-Allow-Origin: http://localhost:8080");
        // header("");   

        // ALLOW OPTIONS METHOD
        $headers = [
            'Access-Control-Allow-Credentials'=> 'true',
            'Access-Control-Allow-Origin' => 'http://localhost:8080',
            'Access-Control-Allow-Origin'=> '*',
            'Access-Control-Expose-Headers'=> '*',
            'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'=> '*'
        ];
        // if($request->getMethod() == "OPTIONS") {
        //     // The client-side application can set only headers allowed in Access-Control-Allow-Headers
        //     return Response::make('OK', 200, $headers);
        // }

        $response = $next($request);
        foreach($headers as $key => $value)
            $response->headers->set($key, $value);;
        return $response;
    }
}
