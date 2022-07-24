<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFollowUp;
use App\Models\Appointment;
use App\Models\FollowUp;
use Illuminate\Http\Request;

class FollowUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = date("Y-m-d");
        $today_followup_lists = FollowUp::where('follow_up_date', $today)->get();
        $all_followup_lists = FollowUp::all();
        return view('marketing.follow_up.index', compact('today_followup_lists', 'all_followup_lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function save_follow_up_appointment(StoreFollowUp $request)
    {

        $follow_up_or_appointment = $request->follow_up_or_appointment;
        if ($follow_up_or_appointment == 'follow_up') {
            $follow_up = new FollowUp();
            $follow_up->user_id = auth()->user()->id;
            $follow_up->follow_up_date = $request->date_time;
            $follow_up->follow_up_remark = $request->remark;
            $follow_up->marketing_team_id = $request->marketing_team_id;
            $follow_up->save();
            return json_encode(array(
                "statusCode" => 200
            ));
        } elseif ($follow_up_or_appointment == 'appointment') {
            $follow_up = new Appointment();
            $follow_up->user_id = auth()->user()->id;
            $follow_up->appointment_date_time = $request->date_time;
            $follow_up->appointment_remark = $request->remark;
            $follow_up->marketing_team_id = $request->marketing_team_id;
            $follow_up->appointment_person = $request->appointment_person;
            $follow_up->appointment_location = $request->appointment_location;
            $follow_up->save();
            return json_encode(array(
                "statusCode" => 200
            ));
        }
    }
}
