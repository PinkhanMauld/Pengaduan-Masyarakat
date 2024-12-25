@extends('template.app')


@section('content-dinamis')
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <a href="{{ route('tambah') }}" class="btn btn-success">+ Tambah</a>
        </div>
        @if (Session::get('success'))
            <div class="alert alert-success" id="alert-user">
            {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::get('error'))
        <div class="alert alert-danger+" id="alert-user">
        {{ Session::get('error') }}
        </div>
    @endif
            <table class="table table-stripped table-bordered mt-3 text-center">
                <thead>
                    <th>#</th>
                    <th>Email</th>
                   
                    <th>Aksi</th>
                </thead>
                <tbody>
                    {{-- jika data  kosong --}}
                    @php
                        $no = 1;
                    @endphp
                    @if (count($users) < 0)
                        <tr>
                            <td colspan="6">Data Kosong</td>
                        </tr>
                    @else
                        @foreach ($users as $index => $item)
                            <tr>
                                {{-- <td>{{ ($users->currentPage() - 1) * $users->perpage() + ($index + 1) }}</td> --}}
                                <td>{{$no++}}</td>
                                <td>{{ $item['email'] }}</td>
                                {{-- <td>{{ $item->staffProvinces->province }}</td> --}}
                    
                                <td class="d-flex justify-content-center">
                                    <form action="{{ route('reset.password', $item->id)}}" method="POST">
                                        @csrf
                                    <button type="submit"><a class="btn btn-primary me-2">Reset</a></button>
                                </form>
                                    <form method="POST" action="{{ route('hapus', $item->id)}}">
                                        @csrf
                                        @method('DELETE')
                                    <button type="submit" class="btn btn-danger ">Hapus</button>
                                </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                
            </table>
            {{-- modal --}}
            {{-- <div class="modal fade" id="exampleModalUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form class="modal-content" method="POST" action=""> --}}
                        {{-- action kosong, diisi melalui js karena id dikirim ke js nya --}}

                        {{-- @csrf untuk token yang menjadi kunci kita bisa mengirim formulir dengan tipe post--}}
                        {{-- @csrf --}}
                        {{-- menimpa method="POST" jadi DELETE sesuai web.php http-method --}}
                        {{-- @method('DELETE')
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">HAPUS DATA AKUN</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                           
                            Apakah Anda Yakin Ingin Menghapus Data Akun <b id="name_user"></b>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
    </div> --}}
@endsection

@push('script')
{{-- jquery untuk memunculkan modal --}}
{{-- jquery itu untuk mempersingkat penulisan javascript
 --}}
{{-- <script>
    function showModalDelete(id, name) {
 
        // memasukkan teks dari parameter ke html bagian id="nama_user"
        // $ untuk memanggil jquery
        // .text fungsi js yang fungsinya untuk menambahkan text ke tag html
        //untuk mengambil atau get elemen by id = name_user yang terdapat di modal
        $("#name_user").text(name);
        // untuk mengarah ke route hapus sesuai di web php dengan mengambil path dinamisnya
        let url = "{{ route('hapus', ':id') }}";
        // isi path dinamis :id dari data parameter id
        //url diganti dengan id yang ingin di delete
        url = url.replace(':id', id);
        // action="" di form diisi dengan url di atas
        //lalu get elemen by query form dengan atribut berupa action dan url (url dari route)
        $("form").attr("action", url);
        // memunculkan modal dengan id="exampleModalUser"
        $("#exampleModalUser").Modal('show');
        


    }
</script> --}}
@endpush