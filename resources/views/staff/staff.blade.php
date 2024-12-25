@extends('template.app')
@push('style')
    <style>
        body {
    background-color: #f8f9fa;
    font-family: Arial, sans-serif;
    color: #333;
}

.card {
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card h5 {
    color: #495E57;
    font-weight: bold;
}

.btn-success {
    background-color: #495E57;
    border-color: #495E57;
}

.btn-success:hover {
    background-color: #3a4b48;
    border-color: #3a4b48;
}

.table {
    margin-bottom: 0;
    background-color: #fff;
}

.table thead th {
    background-color: #495E57;
    color: #fff;
}

.table tbody tr:hover {
    background-color: #f1f1f1;
}

.dropdown-menu {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 8px;
}

.dropdown-menu li:hover {
    background-color: #e9ecef;
}

.modal-header {
    background-color: #495E57;
    color: #fff;
}

.modal-footer .btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.modal-footer .btn-primary {
    background-color: #495E57;
    border-color: #495E57;
}

.modal-footer .btn-primary:hover {
    background-color: #3a4b48;
    border-color: #3a4b48;
}

.form-control {
    border: 1px solid #ccc;
    border-radius: 4px;
}

.form-control:focus {
    border-color: #495E57;
    box-shadow: 0 0 5px rgba(73, 94, 87, 0.5);
}

    </style>
@endpush
@section('content-dinamis')
@foreach ($reports as $report)
    

<div class="card mt-4">
    <div class="d-flex justify-content-end mb-2">
        {{-- <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('orders.export.excel') }}" class="btn btn-success">Export Excel</a>
        </div> --}}
    </div>
    <h5>Pengaduan</h5>
    <a class="btn btn-success ms-auto"href="{{ route('download')}}">Export</a>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                {{-- <th scope="col" class="text-center">#</th> --}}
                <th scope="col">Gambar & Pengirim</th>
                <th scope="col">Lokasi & Tanggal</th>
                <th scope="col">Deskripsi</th>
                <th scope="col">Jumlah Vote</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td> <img class="w-25" src="{{ asset('storage/' .$report->image)}}" alt=""> {{ $report->user->email}}</td>
                <td> <small>{{ $report->created_at->format('d M Y H:i')}}, {{json_decode($report->province)->name}}, {{ json_decode($report->subdistrict)->name}}, {{ json_decode($report->village)->name}}</small></td>
                <td>{{$report->description}}</td>
                <td>{{($report->voting)}}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          Aksi
                        </button>
                        <ul class="dropdown-menu">
                            <li onclick="addModal('{{ $report->id}}', '{{ $report->response_status}}')">
                                Tindak Lanjut
                            </li>
                        </ul>
                      </div>
                </td>
            </tr>
        </tbody>
        
    </table>
    
    {{-- <div class="d-flex justify-content-end mb-5">
        {{ $orders->links() }}
    </div>
</div> --}}

@endforeach
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addResponseTable" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form-add-response" method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addResponseTable">Tambah Response</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="response-id">
                    <div class="form-group">
                        <label for="response_status" class="form-label">Nama Response</label>
                        <select name="response_status" id="response_status" class="form-control">
                            <option value="" selected hidden disabled>Pilih</option>
                            <option value="ON_PROCESS">On Process</option>
                            <option value="DONE">Done</option>
                            <option value="REJECT">Reject</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addResponseTable" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form-add-response" method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addResponseTable">Tambah Response</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="response-id">
                    <div class="form-group">
                        <label for="response_status" class="form-label">Nama Pengguna</label>
                        <select name="response_status" id="response_status" class="form-controll">
                            <option value="" selected hidden disabled>Pilih</option>
                            <option value="ON_PROCESS">On Process</option>
                            <option value="DONE">Done</option>
                            <option value="REJECT">Reject</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dissmis>Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>

    </div>

</div>
  @endsection

  @push('script')
    <script>
        
        function addModal(id, response) {
            $('#response-id').val(id);
            $('#response_status').val(response);
            $('#addModal').modal('show');
        }

        $('#form-add-response').on('submit', function(e) {
            e.preventDefault();

            let id = $('#response-id').val();
            let responseStatus = $('#response_status').val();
            let actionUrl = "{{ url('/pengaduan/store') }}/" + id;

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', 
                    response_status: responseStatus, 
                },
                success: function(response) {
                    $('#addModal').modal('hide');
                    window.location.href = "{{ url('/pengaduan/show') }}/" +
                    id;
                    alert('Response berhasil ditambahkan!');
                },
                error: function(err) {
                    alert('Gagal menambahkan response');
                }
            });
        });
    
    </script>
@endpush