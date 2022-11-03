<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;
use Illuminate\Http\Request;

class FormatResponseSignIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof Response) {
            $content = json_decode($response->getContent(), true);
            $statusCode = $response->getStatusCode();
            $response
                ->setStatusCode(ResponseStatus::HTTP_OK)
                ->setContent(
                    responder()
                        ->setStatus($statusCode)
                        ->setData($content)
                        ->getResponse()
                );
        }

        return $response;
    }
}
