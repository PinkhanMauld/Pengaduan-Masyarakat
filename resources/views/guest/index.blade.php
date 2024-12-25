@extends('template.app')
@push('style')
    <style>
       /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #fff; /* Warna latar belakang */
    color: #f8f9fa; /* Teks terang agar kontras dengan latar belakang */
    margin: 0;
    padding: 0;
}

.container {
    background-color: #495E57;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

/* Header Links */
h5.card-title a {
    color: #007bff;
    font-weight: bold;
    transition: color 0.3s ease-in-out;
}

h5.card-title a:hover {
    color: #0056b3;
    text-decoration: underline;
}

/* Card Design */
.card {
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    transition: box-shadow 0.3s ease-in-out;
    background-color: #f8f9fa; /* Kontras dengan latar belakang utama */
}

.card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card-text small {
    color: #6c757d;
}

/* Buttons */
.btn-outline-primary {
    border-radius: 20px;
    border-color: #007bff;
    color: #007bff;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background-color: #007bff;
    color: #ffffff;
}

/* Dropdown Select */
#search {
    border: 2px solid #007bff;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 16px;
    transition: all 0.3s ease;
    width: 100%; /* Responsif */
}

#search:focus {
    outline: none;
    border-color: #0056b3;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* Info Box */
.info-box {
    padding: 15px;
    background: #e9ecef;
    border-radius: 8px;
    border-left: 5px solid #007bff;
    margin-top: 20px;
}

.info-box h5 {
    color: #007bff;
    margin-bottom: 10px;
}

.info-box ol {
    padding-left: 20px;
    margin: 0;
    list-style: decimal;
}

.info-box ol li {
    margin-bottom: 5px;
}

/* Utility Classes */
.py-4 {
    padding-top: 2rem !important;
    padding-bottom: 2rem !important;
}

.me-3 {
    margin-right: 1rem !important;
}

.me-2 {
    margin-right: 0.5rem !important;
}

.text-decoration-none {
    text-decoration: none;
}

/* Add Contrast to Reports Section */
#reports-list {
    padding-top: 20px;
}

#reports-list .card {
    background-color: #ffffff;
    color: #333; /* Teks gelap di dalam kartu */
}

    </style>
@endpush
 @section('content-dinamis')
     <div class="container py-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="d-flex mb-4">
                    <select name="search" id="search" class="form-select me-2" style="width: 700px">
                        <option value="" class="">-- Pilih Provinsi --</option>
                    </select>
                </div>

                {{-- <div class="card">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ asset('assets/img/images.jpeg')}}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div>
                                <h5 class="card-title"> <a href="#" class="text-decoration-none">Jalanan Rusak di Cipaku</a></h5>
                                <p class="card-text"><small>haie@gmail.com | 2 hours aho</small></p>
                                <p class="card-text">
                                    <span class="me-3"><i class="fa fa-eye" aria-hidden="true"></i> 5</span>
                                    <button class="btn btn-outline-primary btn-sm">Vote</button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="info-box">
                            <h5>
                                <div class="info-icon d-flex">
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                    <b>Informasi Pembuatan Pembangunan</b>
                                </div>
                            </h5>
                            <ol>
                                <li>Pengaduan bisa dibuat hanya jika anda telah membuat akun sebelumnya.</li>
                                <li>Keseluruhan data pada pengaduan bernilai BENAR dan DAPAT DIPERTANGGUNG JAWABKAN.</li>
                                <li>Seluruh bagian data perlu diisi.</li>
                                <li>Penagduan anda akan ditanggapi dalam 2x24 Jam.</li>
                                <li>Periksa tanggapan kami, pada dashboard setelah anda <strong>Login</strong>.</li>
                                <li>Pembuatan pengaduan dapat dilakukan pada halaman berikut: <a href="#">Ikuti Tautan</a>.</li>
                            </ol>
                        </div>
                    </div>
                </div> --}}

                <div id="reports-list">
                     
                </div>

            </div>
        </div>
     </div>

     @endsection
     @push('script')
         
     <script>
         $(document).ready(function() {
            //  $.ajax({
            //      method: "GET",
            //      url: 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json',
            //      dataType: "json",
            //      success: function(response) {
            //          response.forEach(function(province) {
            //              $('#search').append(
            //                  `<option value="${province.id}">${province.name}</option>`
            //                 );
            //             });
            //         },
            //         error: function(error) {
            //             alert("Gagal menampilkan provinsi");
            //         }
            //     });
            $.ajax({
                    method: "GET",
                    url: "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json",
                    dataType: "json",
                    success: function(response) {
                        response.forEach(function(province) {
                            $('#search').append('<option value="' + province.id + '" data-name="' +
                                province.name + '">' + province
                                .name + '</option>');
                        });
                    },
                    error: function() {
                        alert("Gagal memuat data, coba lagi nanti!");
                    }
                });

                $('#search').on('change', function() {
                    var provinceId = $(this).val(); 

                    $.ajax({
                        url: "{{ route('searchByProvince') }}", 
                        type: "GET",
                        data: {
                            search: provinceId
                        },
                        success: function(response) {
                            $('#reports-list').empty();

                            response.forEach(function(report) {
                                const provinceName = JSON.parse(report.province || '{}').name || 'Tidak diketahui';
                                const regencyName = JSON.parse(report.regency || '{}').name || 'Tidak diketahui';
                                const subdistrictName = JSON.parse(report.subdistrict || '{}').name || 'Tidak diketahui';
                                const villageName = JSON.parse(report.village || '{}').name || 'Tidak diketahui'
                                // Buat objek tanggal dari created_at
                                const createdAt = new Date(report.created_at);

                                // Format tanggal dengan toLocaleString
                                const formattedDate = createdAt.toLocaleString('id-ID', {
                                    day: '2-digit',
                                    month: 'long',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                });
                                $('#reports-list').append(`
                        <div class="card">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src= "{{asset('storage')}}/${report.image}"class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-7">
                            <div class="card-body">
                                <h5 class="card-title font-weight-bold report-title" data-id="${report.id}"> <a href="/show/${report.id}" class="text-decoration-none">${report.description}</a></h5>
                                <p class="card-text"><small>${report.user_id}<br> ${report.created_at}</small></p>
                                <p class="card-text">
                                    <button class="btn" name="viewers" id="viewers"><i class="fa fa-eye" aria-hidden="true"></i> ${report.viewers}</button>
                                    <button class="btn voting-btn"
                                        data-id="${report.id}"
                                        data-voted="${report.voting}"
                                        name="voting" id="voting">
                                        <i class="fa fa-heart ${report.voting}" aria-hidden="true"></i>
                                        
                                        <small id="vote-count" class="d-block text-muted">${report.voting}  votes</small>
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                    `);
                            });
                        },
                        error: function() {
                            alert("Gagal memuat data laporan, coba lagi nanti!");
                        }
                    });
                });
            

            $(document).on('click', '.voting-btn', function() {
                var reportId = $(this).data('id');
                var voted = $(this).data('voted');

                if (voted === 'true') {
                    alert('Anda sudah menambahkan vote.');
                    return;
                }

                // $.ajax({
                //     url: "{{ route('vote', ':id') }}".replace(':id', reportId),
                //     type: 'POST',
                //     data: {
                //         _token: '{{ csrf_token() }}',
                //     },
                //     success: function(response) {
                //         if (response.message) {
                //             $('.voting-btn[data-id="' + reportId + '"] i').addClass(
                //                 'text-danger');
                //             $('.voting-btn[data-id="' + reportId + '"] .text-muted').text(
                //                 response.count + 'votes');
                //              $('.voting-btn[data-id="' + reportId + '"]').data(
                //                'voted', true);
                //         } else {
                //             alert(response.error);
                //         }
                //     },
                //     error: function() {
                //         alert('Anda sudah melakukan voting.');
                //     }
                // });
                $.ajax({
    url: "{{ route('vote', ':id') }}".replace(':id', reportId),
    type: 'POST',
    data: {
        _token: '{{ csrf_token() }}',
    },
    success: function(response) {
        if (response.message) {
            $('.voting-btn[data-id="' + reportId + '"] i').addClass('text-danger');
            $('.voting-btn[data-id="' + reportId + '"] .text-muted').text(
                response.count + ' votes'
            );
            $('.voting-btn[data-id="' + reportId + '"]').data('voted', true);
        } else {
            alert(response.error);
        }
    },
    error: function() {
        alert('Terjadi kesalahan saat memberikan voting.');
    }
});

            });

            $(document).on('click', '.report-title', function() {
                var reportId = $(this).data('id');
                var viewersCount = $(this).siblings('.viewers-btn').find(
                '.viewers-count');

                $.ajax({
                    url: "{{ route('views', ':id') }}".replace(':id', reportId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            viewersCount.text(response.views + 'views');
                        }
                    },
                    error: function() {
                        alert('Gagal menambahkan jumlah views.');
                    }
                });
            });

        });

            
            </script>
            @endpush
            