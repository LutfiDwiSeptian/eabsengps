<?php use Illuminate\Support\Facades\Storage; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Download</title>
  <!-- font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>@page { size: A4 }

  .datakaryawan {
    margin-top: 30px;
  }

  .datakaryawan td {
    padding: 5px;
  }
  .tablepresensi {
    width: 100%;
    margin-top: 10px;
    border-collapse: collapse;
  }
  .tablepresensi>tr,th{
    border: 2px solid #000;
    padding: 5px;
  }

  .tablepresensi td{
    border: 2px solid #000;
    padding: 5px;
  }
  .foto{
    width: 50px;
    margin-left: 30px;
  }
 </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <!-- Write HTML just like a web page -->
    <table style="width: 100%;" >
      <tr>
        <td style="width: 30px;">
          <img src="{{ asset('assets/img/logo_presensi2.png') }}" alt="" width="100px">
        </td>
        <td style="text-align: center; font-family:'Times New Roman', Times, serif">
          <h3>
            PT.MULYA SEJAHTERA TECHNOLOGY<br>
            LAPORAN ABSEN KARYAWAN<br>
            BULAN {{$namabulan[$bulan]}} {{$tahun}}
          </h3>
        </td>
        <hr>
      </tr>
    </table>
    <hr>
    <table class="datakaryawan">
      <tr>
        <td rowspan="6">
            <?php $path = Storage::url('upload/karyawan/' . $karyawan->foto); ?>
            <img src="{{$path}}" alt="" width="150px">
        </td>
      </tr>
      <tr>
        <td>NIK</td>
        <td>:</td>
        <td>{{$karyawan->nik}}</td>
      </tr>
      <tr>
        <td>Nama</td>
        <td>:</td>
        <td>{{$karyawan->nama_lengkap}}</td>
      </tr>
      <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td>{{$karyawan->jabatan}}</td>
      </tr>
      <tr>
        <td>Department</td>
        <td>:</td>
        <td>{{$karyawan->kode_dpt}}</td>
      </tr>
      <tr>
        <td>No.HP</td>
        <td>:</td>
        <td>{{$karyawan->no_hp}}</td>
      </tr>
    </table>
    <table class="tablepresensi">
      <tr>
        <th>No.</th>
        <th>Tanggal</th>
        <th>Jam Masuk</th>
        <th>Foto Masuk</th>
        <th>Jam Pulang</th>
        <th>Foto Pulang</th>
        <th>Keterangan</th>
      </tr>
      @foreach($presensi as $d)
      <?php $pathmasuk = Storage::url('upload/absensi/' . $d->foto_in); ?>
      <?php $pathpulang = Storage::url('upload/absensi/' . $d->foto_out); ?>
      <tr>
        <td>{{ $loop->iteration }}</td>
       <td>{{ date("d-m-Y",strtotime($d->tgl_presensi))}}</td>
       <td>{{ $d->jam_in }}</td>
       <td><img src="{{$pathmasuk}}" alt="" class="foto"></td>
       <td>{{ $d->jam_out }}</td>
       <td><img src="{{$pathpulang}}" alt="" class="foto"></td>
       <td>
         @if ($d->jam_in > '08:30')
         Terlambat
         @else
         Tepat Waktu
         @endif
       </td>
      </tr>
      @endforeach
    </table>
  </section>

</body>

</html>