<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Comment;
use App\Models\Response;
use App\Models\ResponseProgress;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function views($id) 
     {
        try {
            $report = Report::findOrFail($id);
            $report->increment('viewers');
            return response()->json([
                'success' => true,
                'views' => $report->viewers,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
     }

    //  public function headstaffDashboard()
    //  {
    //     $data = [
    //         'pengaduan' => 2,
    //         'tanggapan' => 2,
    //     ];

    //     return view('headstaff.dashboard', compact('data'));
    //  }

    //  public function vote($id)
    //  {
    //     $userId = auth()->id();
    //     $report = Report::findOrFail($id);
       
    //     if (in_array($userId, $report->voting)) {
    //         return response()->json(['error' => 'You have already voted for this report.'], 403);
    //     }
    //     $report->voting = array_merge($report->voting, [$userId]);
    //     $voteCount = count($report->voting);

    //     $report->save();

    //     return response()->json([
    //         'message' => 'Vote berhasil!',
    //         'count' => $voteCount,
    //     ]);
            
    //  }
    public function vote($id)
{
    $report = Report::findOrFail($id);

    // Tambahkan 1 ke jumlah suara
    $report->voting += 1;
    $report->save();

    return response()->json([
        'message' => 'Vote berhasil!',
        'count' => $report->voting,
    ]);
}

    public function index()
    {
        $reports = Report::all();
        return view('guest.index', compact('reports'));
    }

    public function dashboard()
    {
        $reports= Report::with('response.response_progress')->where('user_id', Auth::id())->latest()->get();
        $responses= Response::all();
        $response_progress= ResponseProgress::all();
        // dd($respomse_progress);
        return view('guest.monitor', compact('reports', 'responses', 'response_progress'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('guest.create');
        // return redirect()->route('')
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'type' => 'required',
            'province' => 'required',
            'regency' => 'required',
            'subdistrict' => 'required',
            'village' => 'required',
            'image' => 'required',
        ]);

        $file = $request->file('image');
        $filePath = $file->storeAs('uploads', time() . '_' . $file->getClientOriginalName(), 'public');

        $process = Report::create([
            'user_id' => Auth::user()->id,
            'description' => $request->description,
            'type' => $request->type,
            'province' => $request->province,
            'regency' => $request->regency,
            'subdistrict' => $request->subdistrict,
            'village' => $request->village,
            'image' => $filePath,
            'statement' => 1,
        ]);

        if ($process) {
            return redirect()->route('monitoring')->with('success', 'Artikel Berhasil ditambahkan!');
        } else {
            return redirect()->back()->with('failed', 'Artikel gagal ditambahkan! silahkan coba kembali');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $report = Report::find($id);

            $comments = Comment::where('report_id', $report->id)->get();

            $reports = Report::where('id', $report->id)->get();
            // $reports->viewers->();

        return view('guest.show', compact('reports', 'comments'));
        // $report = Report::find($id);

        //     $comments = Comment::where('report_id', $report->id)->get();

        //     $reports = Report::find($id)->get();
        //     $reports->increment('viewers');

        // return view('guest.show', compact('reports', 'comments'));
    }
    

    public function showDashboard()
    {
        $reports = Report::all();
        $responses = Response::all();
        $response_progresses = ResponseProgress::all();
        return view('guest.monitor', compact('reports', 'responses', 'response_progresses'));
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
        $proses = Report::where('id', $id)->delete();

        if ($proses) {
            return redirect()->back()->with('success', 'Data Berhasil Dihapus!');
        } else {
            return redirect()->back()->with('failed', 'Data Gagal Dihapus!');
        }
    }

    public function artikel()
    {
        return view('guest.index');
    }

    public function searchByProvince(Request $request)
    {
        $provinceId = $request->input('search');

        if (!$provinceId) {
            return response()->json(['error' => 'Provinsi tidak dipilih'], 400);
        }

        $reports = Report::whereRaw('JSON_UNQUOTE(JSON_EXTRACT(province, "$.id")) = ?', [$provinceId])->get();

        if ($reports->isEmpty()) {
            return response()->json(['error' => 'Tidak ada laporan ditemukan untuk provinsi ini'], 404);
        }

        return response()->json($reports);
    }

    public function exportExcel(Request $request)
    {
        $dateFilter = $request->get('date_filter');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $file_name = 'data_pengaduan' . '.xlsx';

        if ($dateFilter === 'custom' && $startDate && $endDate) {
            return Excel::download(new ReportExport($startDate, $endDate), $file_name);
        }

        return Excel::download(new ReportExport(), $file_name); 
    }


    // public function showDashboard($id)
    // {
    //     // $reports = Report::all();
    //     // $comments = Comment::all();
    //     // return view('guest.monitor', compact('reports', 'comments'));
    //     $reports = Report::find($id);
    //     return view('guest.monitor', compact('reports'));
    // }


}
