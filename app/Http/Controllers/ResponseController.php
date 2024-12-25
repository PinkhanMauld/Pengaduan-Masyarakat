<?php

namespace App\Http\Controllers;
use App\Models\Report;
use App\Models\Response;
use App\Models\ResponseProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports=Report::all();
        $responses=Response::all();
        return view('staff.staff', compact('reports', 'responses'));
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
    public function store(Request $request, $id)
    {
        $request->validate([
            'response_status'=> 'required',
        ]);

        $reportFormat = Report::findOrFail($id);
        $existingRespnse = Response::where('report_id', $reportFormat->id)->first();

        if ($existingRespnse) {
            $existingRespnse->update([
                'response_status'=>$request->response_status,
                'staff_id' => Auth::user()->id,
            ]);
            $message = 'Response berhasil diperbarui';
            $success = 'true';
        } else {
            $proses = Response::create([
                'report_id' => $reportFormat->id,
                'response_status' => $request->response_status,
                'staff_id' => Auth::user()->id,
            ]);
            $message = $proses ? 'Response berhasil ditambahkan!' : 'Gagal menambahkan response';
            $success = $proses ? true : false; 
        }

        if ($success) {
            return redirect()->back()->with('success', $message);
        } else {
            return redirect()->back()-with('failed', $message);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $report = Report::with('user')->find($id);

        if ($report) {
            $responses = Response::where('report_id', $report->id)->get();
            $response = $responses->first();

            if ($response) {
                $response_progresses = ResponseProgress::where('response_id', $response->id)->get();
                $reports = Report::where('id', $report->id)->get();
            } else {
                $response_progresses = [];
            }
        } else {
            $reports= [];
            $responses= [];
            $response_progresses= [];
        }

        return view('staff.show', compact('reports', 'responses', 'response_progresses'));

    }

    public function storeProgress(Request $request, $id)
    {
        $request->validate([
            'histories' => 'required|string',
        ]);

        $responseFormat = Response::findOrFail($id);

        $proses = ResponseProgress::create([
            'response_id' => $responseFormat->id,
            'histories' => json_encode(['note' => $request->histories]),
        ]);

        if ($proses) {
            return response()->json([
                'success' => true,
                'message' => 'Tanggapan terkirim',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tanggapan gagal terkirim, Silahkan coba lagi.',
            ]);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $response = Response::findOrFail($id);
            $response->response_status = $request->input('response_status');
            $response->save();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diubah menjadi DONE'
            ]);
        } catch (\Execption $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status'
            ], 500);
        }
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
