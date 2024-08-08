@extends('layout.presensi')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.css">
<style>
    .datepicker-modal {
        max-height: 475px !important;
    }
    .datepicker-date-display{
        background-color: #151515 !important;
    }
</style>
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="/" class="btn btn-block bg-transparent" style="margin-top: 12px">
        <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">FORM IZIN/Sakit</div>
    <div class="right"></div>
</div>
@endsection
@section('content')
<div class="row" style="margin-top: 80px;">
    <div class="col">
        <form method="POST" action="/presensi/storeizin" id="formizin" enctype="multipart/form-data">
            @csrf
        <div class="form-group">
            <input type="text" id="tanggal" name="tanggal" class="form-control datepicker" placeholder="Tanggal Izin/Sakit">
        </div>
        <div class="form-group">
                    <select name="status" id="status" class="form-control">
                        <option value="pilihan">PILIH STATUS</option>
                        <option value="izin">IZIN</option>
                        <option value="sakit">SAKIT</option>
                    </select>
                </div>
                <div class="form-group">
                      <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Keterangan IZIN/SAKIT"></textarea>  
                    </div>
                    <div class="custom-file-upload" id="fileUpload2">
            <input type="file" name="foto_srt" id="fileuploadInput" accept=".png, .jpg, .jpeg, .pdf">
            <label for="fileuploadInput">
                <span>
                    <strong>
                        <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                        <i>Tap to Upload</i>
                    </strong>
                </span>
            </label>
        </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-25">SUBMIT</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('myscript')
<script>
var currYear = (new Date()).getFullYear();
$(document).ready(function() {
  $(".datepicker").datepicker({
    format: "yyyy-mm-dd"    
  });

  $("#tanggal").change(function(e){
    var tanggal = $(this).val();
    $.ajax({
      type : 'POST',
      url :  '/presensi/pengecekanizin',
      data : {
        _token:"{{ csrf_token() }}",
        tanggal : tanggal
      },
      cache:false,
      success:function(respond){
        if(respond == 1){
            Swal.fire({
            title: 'OH',
            text: 'SEPERTIHYA KAMU SUDAH MENGIRIM IZIN/SAKIT DI TANGGAL INI',
            icon: 'warning',
            confirmButtonText: 'Oke'
        }).then((result) => {
            $("#tanggal").val("");
        });
      }
    },
    error: function(xhr, status, error) {
        Swal.fire({
            title: 'Error',
            text: 'Terjadi kesalahan saat pengecekan izin',
            icon: 'error',
            confirmButtonText: 'Oke'
        });
    }
    });
  });

  $('#formizin').submit(function(e) {
    e.preventDefault();
    console.log("Form is attempting to submit");
    var tanggal = $("#tanggal").val();
    var status = $("#status").val();
    var keterangan = $("#keterangan").val();
    console.log(tanggal, status, keterangan);  // Cek nilai yang diambil

    if (tanggal == "") {
        Swal.fire({
            title: 'Tanggal tidak boleh kosong',
            icon: 'warning',
            confirmButtonText: 'Oke'
        })
        console.log("Tanggal kosong");  // Cek kondisi ini
        return false;
    } else if (status == "pilihan") {
        Swal.fire({
            title: 'Tolong pilih status',
            icon: 'warning',
            confirmButtonText: 'Oke'
        })
        console.log("Status tidak dipilih");  // Cek kondisi ini
        return false;
    } else if (keterangan == "") {
        Swal.fire({
            title: 'Harus ada keterangan',
            icon: 'warning',
            confirmButtonText: 'Oke'
        })
        console.log("Keterangan kosong");  // Cek kondisi ini
        return false;
    } else {
        this.submit();  // Submit form jika semua kondisi terpenuhi
    }
  });
});

</script>
@endpush