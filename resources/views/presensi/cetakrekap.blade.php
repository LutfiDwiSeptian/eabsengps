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
  <style>@page { size: A4 landscape}

  #title{
    font-family: 'Times New Roman', Times, serif;
    font-size: 18px;
    font-weight: bold;
  }

  .tabledatakaryawan {
    margin-top: 40px;
  }
  .tabledatakaryawan tr td {
    padding: 5px;
  }

  .tablepresensi {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse; 
  }

  .tablepresensi tr th {
    border: 1px solid black;
    padding: 8px;
    background-color: rgb(169, 163, 163);
    font-size: 10px;
  }

  .tablepresensi tr td {
    border: 1px solid black;
    padding: 5px;
  }
  .tgl {
    font-size: 10px;
  }
  *{
    font-size: 10px;
  }
  .title{
    font-size: 15px;
  }
 </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <!-- Write HTML just like a web page -->
    <table style="width: 100%;" >
      <tr>
        <td style="width: 30px;">
          <img src="{{ asset('assets/img/logo_presensi2.png') }}" alt="" width="80px">
        </td>
        <td>
          <h3 class="title">
            PT.MULYA SEJAHTERA TECHNOLOGY<br>
            REKAP ABSEN KARYAWAN<br>
            BULAN {{$namabulan[$bulan]}} {{$tahun}}
          </h3>
        </td>
        <hr>
      </tr>
    </table>
    <table class="tablepresensi">
      <tr>
        <th rowspan="2">NIK</th>
        <th rowspan="2">Nama Lengkap</th>
        <th colspan="{{ $jmlhari }}">Bulan : {{$namabulan[$bulan]}} {{$tahun}} </th>
        <th rowspan="2">H</th>
        <th rowspan="2">I</th>
        <th rowspan="2">S</th>
        <th rowspan="2">C</th>
        <th rowspan="2">D</th>
        <th rowspan="2">A</th>
      </tr>
      <tr>
        @foreach($rangetanggal as $d)
        @if ($d != NULL)
        <th>{{ date("d",strtotime($d))}}</th>
        @endif
        @endforeach
      </tr>
      @foreach ($rekap as $r)
      <tr>
        <td>{{ $r->nik }}</td>
        <td>{{ $r->nama_lengkap }}</td>
          <?php
          $jml_hadir = 0;
          $jml_sakit = 0;
          $jml_izin = 0;
          $jml_cuti = 0;
          $jml_dinas = 0;
          $jml_alfa = 0;
          $color = "";
           for($i=1; $i<=$jmlhari; $i++){
              $tgl = "tgl_".$i;
              $datapresensi = explode("|",$r->$tgl);
              if($r->$tgl != NULL){
                $status = $datapresensi[2];
              }else {
                $status = "";
              }
              if($status == "hadir"){
                $jml_hadir += 1;
                $color = "white";
              }
              if($status == "izin"){
                $jml_izin += 1;
                $color = "#fc9d03";
              }
              if($status == "sakit"){
                $jml_sakit += 1;
                $color = "#d203fc";
              }
              if($status == "cuti"){
                $jml_cuti += 1;
                $color = "#706e70";
              }
              if($status == "dinas"){
                $jml_dinas += 1;
                $color = "#05f2ee";

              }
              if(empty($status)){
                $jml_alfa += 1;
                $color = "red";
              }
              ?>
              <td style="background-color:{{ $color }}">
                {{$status}}
              </td>
              <?php
               }
              ?>
              <td>{{ !empty($jml_hadir) ? $jml_hadir : "" }}</td>
              <td>{{ !empty($jml_izin) ? $jml_izin : "" }}</td>
              <td>{{ !empty($jml_sakit) ? $jml_sakit : "" }}</td>
              <td>{{ !empty($jml_cuti) ? $jml_cuti : "" }}</td>
              <td>{{ !empty($jml_dinas) ? $jml_dinas : "" }}</td>
              <td>{{ !empty($jml_alfa) ? $jml_alfa : "" }}</td>
        </td>
      </tr>
      @endforeach
    </table>
  </section>
</body>
</html>