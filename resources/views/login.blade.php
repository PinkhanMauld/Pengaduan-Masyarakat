@extends('template.app')
@section('content-dinamis')
    <form action="{{ route('loginAuth')}}" method="POST" class="card d-block mx-auto my-3 p-5 w-75">
        @csrf
        <div class="form-group">
            <label for="email" class="form-label">Email :</label>
            <input type="email" name="email" id="email" class="form-control">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Password : </label>
            <input type="password" name="password" id="password" class="form-control">
            @error('password')
                <small class="text-danger">{{ $message}}</small>
            @enderror
        </div>
        <button type="submit" name="action" value="loginAuth" class="btn btn-primary mt-3">LOGIN</button>
        <button type="submit" name="action" value="register" class="btn btn-secondary mt-3">Buat Akun</button>
        {{-- <a href="{{ route('registration') }}" class="btn btn-secondary mt-3">Buat Akun</a> --}}
    </form>
@endsection

