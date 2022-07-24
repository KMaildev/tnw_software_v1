<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFollowUp;
use App\Models\Appointment;
use App\Models\FollowUp;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class FollowUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('marketing.follow_up.index');
    }

    public function follow_up_ajax(Request $request)
    {
        $data = FollowUp::all();
        return Datatables::of($data)
            ->addIndexColumn()

            ->editColumn('code', function ($each) {
                return $each->marketing_teams_table ? $each->marketing_teams_table->code : '';
            })

            ->editColumn('offer_status', function ($each) {
                $offer_status = $each->marketing_teams_table ? $each->marketing_teams_table->offer_status : '';
                $str = str_replace('_', ' ', $offer_status);
                return ucwords($str);
            })

            ->editColumn('house_no', function ($each) {
                return $each->marketing_teams_table ? $each->marketing_teams_table->no : '';
            })

            ->editColumn('road', function ($each) {
                return $each->marketing_teams_table ? $each->marketing_teams_table->road : '';
            })

            ->editColumn('ward', function ($each) {
                return $each->marketing_teams_table ? $each->marketing_teams_table->ward : '';
            })

            ->editColumn('township_name', function ($each) {
                return $each->marketing_teams_table->township_table ? $each->marketing_teams_table->township_table->township : '-';
            })

            ->editColumn('property_type', function ($each) {
                return $each->marketing_teams_table->property_type_table ? $each->marketing_teams_table->property_type_table->property_type : '-';
            })

            ->editColumn('follow_up_user', function ($each) {
                return $each->follow_up_user ? $each->follow_up_user->name : '';
            })

            ->editColumn('follow_up_date', function ($each) {
                $date =  $each->follow_up_date;
                $date = explode(" ", $date);
                $remove_time =  $date[0];
                $today = date('Y-m-d');

                $html = '';
                if ($remove_time == $today) {
                    $html .= '
                        <span class="badge bg-danger" style="font-size: 12px;">
                            <i class="fa fa-calendar"></i>
                            Today: ' . $each->follow_up_date . '
                        </span>
                    ';
                } else {
                    $html .= '
                        <span class="badge bg-info" style="font-size: 12px;">
                            <i class="fa fa-calendar"></i>
                            ' . $each->follow_up_date . '
                        </span>
                    ';
                }
                return $html;
            })

            ->addColumn('phone', function ($each) {
                $id = $each->marketing_teams_table ? $each->marketing_teams_table->id : 0;
                $html = '';
                $html .= '
                    <button type="button" class="btn btn-primary btn-xs" id="showPhoneModel" data-id="' . $id . '">
                        <i class="fa fa-phone"></i>
                        Call Now
                    </button>
                ';
                return $html;
            })

            ->addColumn('action', function ($each) {
                $id = $each->marketing_teams_table ? $each->marketing_teams_table->id : 0;
                $actions =
                    '<div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle btn-xs"
                        id="exampleSizingDropdown3" data-toggle="dropdown"
                        aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="exampleSizingDropdown3"
                        role="menu">

                        <a class="dropdown-item"
                            href="' . route('marketing_team.show', $id) . '"
                            role="menuitem">
                            <i class="icon md-eye" aria-hidden="true"></i>
                            View Detail
                        </a>
                    </div>
                </div>';
                return $actions;
            })

            ->rawColumns(['action', 'code', 'offer_status', 'house_no', 'road', 'township_name', 'property_type', 'follow_up_user', 'follow_up_date', 'phone'])
            ->make(true);
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
            $follow_up->date_time = date("Y-m-d h:i a");
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
            $follow_up->appointment_date = date("Y-m-d h:i a");
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
