@extends('template.app')


@section('content-dinamis')
{{-- <div class="container">
    <h1>Create</h1>
</div> --}}

<form action="{{ route('tambah.akun')}}" class="card p-5" method="POST">
    @csrf
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="mb-3 row">
        <label for="email" class="col-sm-2 col-form-label">Email: </label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="price" name="email" value="{{ old('name')}}">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="password" class="col-sm-2 col-form-label">Password: </label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="password" name="password" value="{{ old('name')}}">
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Kirim</button>
</form>
@endsection
