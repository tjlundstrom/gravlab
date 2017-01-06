<?php

namespace App\Http\Controllers;

use Request;
use App\Beakers;
use App\Job;
use App\JobUnit;
use App\JobBeakers;

class JobBeakersController extends Controller
{
    public function create()
    {
    	$job_id = Request::session()->get('job');

    	$beakers = Beakers::all();

    	$units = JobUnit::all()->where('job_id', $job_id);

    	return view('jobBeakers.create', compact('beakers', 'units', 'job_id'));
    }

    public function store()
    {
    	$beakers = Request::input('beakers');
        $job = Request::input('job_id');
        $unit = Request::input('unit');

        $allBeakers = [];

        foreach($beakers as $beaker){
            $jobBeaker = new JobBeakers;

            $jobBeaker->job_id = $job;
            $jobBeaker->jobUnit_id = $unit;
            $jobBeaker->pre_weight_1 = 0;
            $jobBeaker->pre_weight_2 = 0;
            $jobBeaker->post_weight_1 = 0;
            $jobBeaker->post_weight_2 = 0;
            $jobBeaker->runNumber = "";
            $jobBeaker->description = "";
            if(substr($beaker, 0, 2) == 'CS'){
                $jobBeaker->prefix = substr($beaker, 0, 2);

                $jobBeaker->number = substr_replace($beaker, "", 0, 2);
            }
            else {
                $jobBeaker->number = $beaker;
            }

            $jobBeaker->save();
        }


        return redirect()->action('JobController@show', ['job' => $job]);
    }

    public function edit($id)
    {
        $job_id = Request::session()->get('job');
        $jobBeakers = JobBeakers::where('jobUnit_id', $id);

        $client = Client::findOrFail(Request::session()->get('client'));

        return view('jobBeakers.edit', compact('jobBeakers'));
    }

    public function update()
    {
        $input = Request::all();

        return $input;
    }
}
