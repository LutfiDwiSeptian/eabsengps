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

    #keterangan {
        height: 8rem !important;
    }
</style>
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="/" class="btn btn-block bg-transparent" style="margin-top: 12px">
        <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">FORM SAKIT</div>
</div>
@endsection
@section('content')
<div class="row" style="margin-top: 80px;">
    <div class="col">
        <form method="POST" action="/izinsakit/store" id="formizin" enctype="multipart/form-data">
            @csrf
        <div class="form-group">
            <input type="text" id="tgl_izin_dari" name="tgl_izin_dari" class="form-control datepicker" placeholder="Dari">
                </div>
                <div class="form-group">
                    <input type="text" id="tgl_izin_sampai" name="tgl_izin_sampai" class="form-control datepicker" placeholder="Sampai">
                        </div>
                        <div class="form-group">
                             <input type="text" id="jml_hari" name="jml_hari" class="form-control" placeholder="Jumlah Hari" autocomplete="off" readonly>
                                </div>
                <div class="form-group">
                    <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" autocomplete="off"> 
                    </div>
            </div>
            <div class="custom-file-upload" id="fileUpload1" style="height: 100px !important">
                <input type="file" name="sid" id="fileuploadInput" accept=".png, .jpg, .jpeg, .pdf">
                <label for="fileuploadInput">
                    <span> 
                        <strong>
                            <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                            <i>Tap to Upload SID</i>
                        </strong>
                    </span>
                </label>
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

  
  function loadjumlahhari() {
    var dari = $("#tgl_izin_dari").val();
    var sampai = $("#tgl_izin_sampai").val();
    var date1 = new Date(dari);
    var date2 = new Date(sampai);

    //untuk menghitung hari 
    var Difference_In_Time = date2.getTime() - date1.getTime();
    // untuk menghitung no 2 hari
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

    if (dari == "" || sampai == "") {
      var jmlhari = 0;
    } else {
      var jmlhari = Difference_In_Days + 1;
    }
    //untuk menampilkan hasil 
    $("#jml_hari").val(jmlhari + " Hari ");
  }

  $("#tgl_izin_dari,#tgl_izin_sampai").change(function(e) {
    loadjumlahhari();
  });





  // $("#tanggal").change(function(e){
  //   var tanggal = $(this).val();
  //   $.ajax({
  //     type : 'POST',
  //     url :  '/presensi/pengecekanizin',
  //     data : {
  //       _token:"{{ csrf_token() }}",
  //       tanggal : tanggal
  //     },
  //     cache:false,
  //     success:function(respond){
  //       if(respond == 1){
  //           Swal.fire({
  //           title: 'OH',
  //           text: 'SEPERTIHYA KAMU SUDAH MENGIRIM IZIN/SAKIT DI TANGGAL INI',
  //           icon: 'warning',
  //           confirmButtonText: 'Oke'
  //       }).then((result) => {
  //           $("#tanggal").val("");
  //       });
  //     }
  //   },
  //   error: function(xhr, status, error) {
  //       Swal.fire({
  //           title: 'Error',
  //           text: 'Terjadi kesalahan saat pengecekan izin',
  //           icon: 'error',
  //           confirmButtonText: 'Oke'
  //       });
  //   }
  //   });
  // });

  $('#formizin').submit(function(e) {
    e.preventDefault();
    console.log("Form is attempting to submit");
    var tgl_izin_dari = $("#tgl_izin_dari").val();
    var tgl_izin_sampai = $("#tgl_izin_sampai").val();
    var keterangan = $("#keterangan").val();
    console.log(tgl_izin_dari, tgl_izin_sampai, jml_hari, keterangan);  // Cek nilai yang diambil

    if (tgl_izin_dari == "" || tgl_izin_sampai == "") {
        Swal.fire({
            title: 'Tanggal tidak boleh kosong',
            icon: 'warning',
            confirmButtonText: 'Oke'
        })
        console.log("Tanggal kosong");  // Cek kondisi ini
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