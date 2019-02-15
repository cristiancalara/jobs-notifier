<?php

namespace App\Http\Controllers\API\v1;

use App\Job;
use Illuminate\Http\Request;

class JobController extends APIController
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    function index(Request $request)
    {
        $status = $request->get('status');
        $query  = (new Job)->newQuery();

        if ( ! $status) {
            $query->whereNull('status_id');
        } else {
            $query->where('status_id', $status);
        }

        return $this->response()->array($query->get()->toArray());
    }

    /**
     * @param Request $request
     * @param Job $job
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    function update(Request $request, Job $job)
    {
        $this->validate($request, [
            'status_id' => 'required|exists:statuses,id'
        ]);

        $job->status_id = $request->input('status_id');
        $job->save();

        return $this->response()->array($job->toArray());
    }
}