<?php

namespace App\Http\Controllers;

use App\Models\StaffProvinces;
use App\Models\User;
use App\Models\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class KelolaAkunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $users = User::all();
        // return view('headstaff.kelola_akun', compact('users'));
        $province = Auth::user()->StaffProvinces->province ??null;
        if (!$province) {
            return redirect()->route('login')->with('failed', 'Provinsi tidak ditemukan pada akun anda');
        }

        $users = User::where('role', 'STAFF')->whereHas('StaffProvinces', function ($query) use ($province) {$query->where('province', $province);})->get();
        return view('headstaff.kelola_akun', compact('users', 'province'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('headstaff.tambah_akun');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'email' => 'required',
        //     'password' => 'nullable'
        // ]);

        // $province = StaffProvince::where('user_id', auth()->user);

        // $role = 'STAFF';
        // $users = User::create([
        //     'email' => $request->email,
        //     'role' => $role,
        //     'password' => Hash::make($request->password),
        // ]);

        // StaffProvinces::create([
        //     'user_id'=>$users,
        //     'province'=> 
        // ]);
        
        // if ($users) {      
        //     return redirect()->route('data')->with('success', 'User berhasil ditambahkan!');
        // } else {
        //     return redirect()->route('data')->with('failed', 'User gagal ditambahkan!');
        // } 
        $province = StaffProvinces::with('user')->where('user_id', auth()->user()->id)->first();
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'province' => 'nullable',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' =>Hash::make($request->password),
            'role' => 'STAFF'
        ]);

        $staffProvince = new StaffProvinces();
        $staffProvince->user_id = $user->id;
        $staffProvince->province = $province->province;
        $staffProvince->save();

        return redirect()->route('data')->with('success', 'User berhasil ditambahkan!');
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
    public function destroy($id)
    {
        // $user = User::findOrFail($id);
        // $user->delete();
        // return redirect()->back()->with('success', 'Berhasil Menghapus Data Akun!');
        $hasResponse = Response::where('staff_id', $id)->exists();

        if($hasResponse) {
            return redirect()->back()->with('error', 'Akun ini masih memiliki tanggapan');

            $staffProvince = StaffProvinces::where('user_id', $id)->first();
            if($staffProvince) {
                $staffProvince->user->delete();
                $staffProvince->delete();
                return redirect()->back()->with('success', 'Berhasil Menghapus Akun');
            }
        }
    }

    public function resetPassword($id) {
        $user = User::findOrFail($id);
        $temporaryPassword = $this->generatePasswordReset($user->email);
        $user->password = Hash::make($temporaryPassword);
        $user->save();
  
        return redirect()->back()->with('success', 'Berhasil mereset password');
      }
  
      public function generatePasswordReset($email) {
          return substr($email, 0, 4) . rand(1000, 9999);
      }
}
