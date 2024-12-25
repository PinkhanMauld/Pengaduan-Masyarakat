@extends('template.app')

@section('content-dinamis')

    <div class="container mt-4">
        <div class="d-flex justify-content-center align-items-center">
            <form action=" {{ route('store') }} " class="form w-75" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Unggah Foto</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="province" class="form-label">Provinsi</label>
                    <select name="province" id="province" class="form-select">
                        <option value="">Pilih Provinsi</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="regency" class="form-label">Kabupaten / Kota</label>
                    <select name="regency" id="regency" class="form-select">
                        <option value="">Pilih Kabupaten</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="subdistrict" class="form-label">Kecamatan</label>
                    <select name="subdistrict" id="subdistrict" class="form-select">
                        <option value="">Pilih Kecamatan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="village" class="form-label">Desa</label>
                    <select name="village" id="village" class="form-select">
                        <option value="">Pilih Desa</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Jenis Artikel</label>
                    <select name="type" id="type" class="form-select">
                        <option value="">Pilih Jenis</option>
                        <option value="KEJAHATAN">Kejahatan</option>
                        <option value="PEMBANGUNAN">Pembangunan</option>
                        <option value="SOSIAL">Sosial</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-warning w-100">Kirim</button>
            </form>
        </div>
    </div>

@endsection

@push('script')
    <script>
        // Script tetap sama
    </script>
@endpush



@push('script')
    <script>
        $(document).ready(function() {
            if ($("#toast").length) {
                var toast = new bootstrap.Toast(document.getElementById('toast'));
                toast.show();
            }

            $.ajax({
        method: "GET",
        url: "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json",
        dataType: "json",
        success: function(response) {
            response.forEach(function(province) {
                $('#province').append('<option value="' + province.id + '" data-name="' + province.name + '">' + province.name + '</option>');
            });
        },
        error: function() {
            alert("Gagal memuat data provinsi!");
        }
    });

    // Enable regency when province is selected
    $('#province').on('change', function() {
        let provinceId = $(this).val();
        let provinceName = $('#province option:selected').data('name');
        if (provinceId) {
            $('#regency').prop('disabled', false).html('<option value="" disabled selected hidden>Loading...</option>');
            $('#subdistrict, #village').prop('disabled', true).html('<option value="" disabled selected hidden>Pilih Kecamatan/Desa</option>');
            $.ajax({
                method: "GET",
                url: `https:www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`,
                dataType: "json",
                success: function(response) {
                    $('#regency').html('<option value="" disabled selected hidden>Pilih Kabupaten</option>');
                    response.forEach(function(regency) {
                        $('#regency').append('<option value="' + regency.id + '" data-name="' + regency.name + '">' + regency.name + '</option>');
                    });
                },
                error: function() {
                    alert("Gagal memuat data kabupaten!");
                }
            });
        }
    });

    // Enable subdistrict when regency is selected
    $('#regency').on('change', function() {
        let regencyId = $(this).val();
        let regencyName = $('#regency option:selected').data('name');
        if (regencyId) {
            $('#subdistrict').prop('disabled', false).html('<option value="" disabled selected hidden>Loading...</option>');
            $('#village').prop('disabled', true).html('<option value="" disabled selected hidden>Pilih Desa</option>');
            $.ajax({
                method: "GET",
                url: `https:www.emsifa.com/api-wilayah-indonesia/api/districts/${regencyId}.json`,
                dataType: "json",
                success: function(response) {
                    $('#subdistrict').html('<option value="" disabled selected hidden>Pilih Kecamatan</option>');
                    response.forEach(function(subdistrict) {
                        $('#subdistrict').append('<option value="' + subdistrict.id + '" data-name="' + subdistrict.name + '">' + subdistrict.name + '</option>');
                    });
                },
                error: function() {
                    alert("Gagal memuat data kecamatan!");
                }
            });
        }
    });

    // Enable village when subdistrict is selected
    $('#subdistrict').on('change', function() {
        let subdistrictId = $(this).val();
        let subdistrictName = $('#subdistrict option:selected').data('name');
        if (subdistrictId) {
            $('#village').prop('disabled', false).html('<option value="" disabled selected hidden>Loading...</option>');
            $.ajax({
                method: "GET",
                url: `https:www.emsifa.com/api-wilayah-indonesia/api/villages/${subdistrictId}.json`,
                dataType: "json",
                success: function(response) {
                    $('#village').html('<option value="" disabled selected hidden>Pilih Desa</option>');
                    response.forEach(function(village) {
                        $('#village').append('<option value="' + village.id + '" data-name="' + village.name + '">' + village.name + '</option>');
                    });
                },
                error: function() {
                    alert("Gagal memuat data desa!");
                }
            });
        }
    });

    // When form is submitted, collect ID and Name of selected items
    $('form').on('submit', function(e) {
        e.preventDefault();  // Prevent form from submitting immediately

        let province = JSON.stringify({
            id: $('#province').val(),
            name: $('#province option:selected').data('name')
        });
        let regency = JSON.stringify({
            id: $('#regency').val(),
            name: $('#regency option:selected').data('name')
        });
        let subdistrict = JSON.stringify({
            id: $('#subdistrict').val(),
            name: $('#subdistrict option:selected').data('name')
        });
        let village = JSON.stringify({
            id: $('#village').val(),
            name: $('#village option:selected').data('name')
        });

        // Add the values to hidden inputs in the form (you can create hidden inputs for these fields)
        $('<input>').attr({
            type: 'hidden',
            name: 'province',
            value: province
        }).appendTo('form');
        $('<input>').attr({
            type: 'hidden',
            name: 'regency',
            value: regency
        }).appendTo('form');
        $('<input>').attr({
            type: 'hidden',
            name: 'subdistrict',
            value: subdistrict
        }).appendTo('form');
        $('<input>').attr({
            type: 'hidden',
            name: 'village',
            value: village
        }).appendTo('form');

        // Submit the form
        this.submit();
    });
        });
    </script>
@endpush
