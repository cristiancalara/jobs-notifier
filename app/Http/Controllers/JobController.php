<?php

namespace App\Http\Controllers;


use App\Status;
use App\Upwork\Client;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $statuses = Status::all();

        $key = $request->route('key');
        if ($key) {
            $status = $statuses->first(function ($value) use ($key) {
                return $value->key === $key;
            });
        }

        return view('jobs', [
            'statuses' => $statuses,
            'status'   => $status ?? null
        ]);
    }
}
