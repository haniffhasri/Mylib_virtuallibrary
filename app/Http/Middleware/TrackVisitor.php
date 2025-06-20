<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;
use Illuminate\Support\Facades\Auth;
class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response{
        $guestTrack = ['', '/']; // Handle both empty path and root
        $authTrack = ['book', 'forum', 'dashboard', 'contact-us/1', 'support', 'borrow', 'notifications'];

        $path = trim($request->path(), '/'); // Normalize path by trimming slashes

        // For guest-accessible paths
        if (in_array($path, array_map(fn($p) => trim($p, '/'), $guestTrack))) {
            Visitor::create([
                'url' => $request->fullUrl(),
                'user_id' => Auth::id(), // null if not authenticated
            ]);
        }
        // For auth-only paths
        elseif (in_array($path, $authTrack) && Auth::check()) {
            Visitor::create([
                'url' => $request->fullUrl(),
                'user_id' => Auth::id(),
            ]);
        }

        return $next($request);
    }
}
