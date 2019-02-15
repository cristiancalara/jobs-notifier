<?php

namespace App\Http\Middleware;

use App\Status;
use Closure;
use JavaScript;

class SetGlobalJSValues
{
    /**
     * @param $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data = [];
        if (auth()->check()) {
            $data['user'] = auth()->user();
        }

        $data['statuses'] = Status::all();

        JavaScript::put($data);

        return $next($request);
    }
}
