<?php

namespace App\Http\Controllers;
use App\Models\Report;
use Illuminate\Http\Request;

class HeadStaffController extends Controller
{

    public function getReportsByProvince()
    {
        $data =  Report::join('responses', 'reports.id', '=', 'responses.report_id')
            ->selectRaw('json_extract(reports.province, "$.name") as province_name,
                            COUNT(reports.id) as total_reports,
                            COUNT(CASE WHEN responses.response_status = "DONE" THEN 1 END) as done_count,
                            COUNT(CASE WHEN responses.response_status = "ON_PROCESS" THEN 1 END) as on_process_count,
                            COUNT(CASE WHEN responses.response_status = "REJECT" THEN 1 END) as reject_count')
            ->groupBy('province_name')
            ->get();
        return response()->json($data);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('headstaff.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
