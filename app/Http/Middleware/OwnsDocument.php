<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnsDocument
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /* 
        If the user is authorized to change the document
        then they can enter the page
         */
        $document = Document::find($request->document);

        if (!$document || !Auth::user()->can('change-document', $document)) {
            abort(404, 'Not found');
        }
        return $next($request);
    }
    
}
