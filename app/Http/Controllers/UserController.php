<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loginAuth(Request $request)
    {
        $action = $request->input('action');
        if ($action == 'loginAuth') {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        $user = $request->only(['email', 'password']);
        
        if (Auth::attempt($user)) {
            return redirect()->route('create');
        } else {
            return redirect()->back()->with('failed', 'Gagal Login! silahkan coba lagi.');
        } 
    } else if ($action == 'register') {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        // Cek apakah email sudah terdaftar
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            // Jika user tidak ditemukan, buat akun baru
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password), // Enkripsi password
                'role' => 'guest' // Default role 'GUEST' untuk user baru
            
        ]);
        return redirect()->route('create');
    }
}
    }

    // public function registration(Request $request)
    // {
    //     // Validasi data login
    //     // dd($request->all());
       

        
    //     } else {
    //         // Jika user ditemukan, periksa apakah password benar
    //         if (!Hash::check($request->password, $user->password)) {
    //             return redirect()->route('login')->with('error', 'Email atau password salah.');
    //         }
    //     }
    // }
    public function index()
    {
        //
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




    // public function showRegister() {
    //     return view('login'); // Pastikan file Blade 'register.blade.php' ada di folder resources/views/auth
    // }
    
}