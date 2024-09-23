@extends('layout.presensi')
@section('header')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="{{ url('/dashboard')}}" class="btn btn-icon">
        <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">IZIN</div>
    <div class="right"></div>
</div>
<style>
    .dataizin {
        margin-left: 10px;
    }
    .historicontent {
        display: flex;
        gap: 1px;
    }
    .status {
        position: absolute;
        right: 10px;
    }
   .tengah {
    text-align: center;
   }
</style>
@endsection
@section('content')
<div class="row" style="margin-top: 80px;">
    <div class="col">
    @php
        $massagesuccess = Session::get('success');
        $massageerror = Session::get('error');
    @endphp
    @if(Session::get('success'))
        <div class="alert alert-success">
            {{ $massagesuccess }}
        </div>
    @endif
    @if(Session::get('error'))
        <div class="alert alert-danger">
            {{ $massageerror }}
        </div>
    @endif
    </div>
</div>
<div class="row">
    <div class="col-12">
        <form  method="GET" action="{{ url('/presensi/izin') }}">
            <div class="row">
                <div class="col-6"> <!-- mengganti col biar sejajar sama form -->
                    <div class="form-group">
                        <select name="bulan" id="bulan" class="fomr-control materelize">
                            <option value=""> Bulan</option>
                            @for($i = 1; $i <= 12; $i++ )
                            <option  {{ Request('bulan') == $i ? 'selected' : '' }} value="{{ $i }}"> {{ $namabulan[$i] }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-6"> <!-- menammbahakn kolum baru -->
                    <div class="form-group">
                        <select name="tahun" id="tahun" class="fomr-control materelize">
                            <option value=""> Tahun</option>
                            @php
                             $tahun_awal = 2023;
                             $tahun_sekarang = date("Y");
                             for($t = $tahun_awal ; $t <= $tahun_sekarang; $t++){
                                if (Request('tahun')==$t){
                                    $selected = 'selected';
                                }else {
                                    $selected = '' ;
                                }
                                echo "<option $selected value='$t'>$t</option>";
                             }
                            @endphp
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary w-100">Cari Data</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- untuk pengecekan status -->
<div class="row">
    <div class="col">
        @foreach($dataizin as $d)
        <!-- untuk mengambil dari data base dan memasukan icon yang benar -->
        <div class="card mt-1 card_izin" kode_izin={{ $d->kode_izin }} statues_approved=" {{ $d->statues_approved }}" data-toggle="modal" data-target="#actionSheetIconed">
            <div class="card-body">
                <div class="historicontent">
                    @if ($d->status == "izin")
                    <div class="icon" style="color: #1cbfff">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="48"  height="48"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-briefcase-off">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M11 7h8a2 2 0 0 1 2 2v8m-1.166 2.818a1.993 1.993 0 0 1 -.834 .182h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2" />
                            <path d="M8.185 4.158a2 2 0 0 1 1.815 -1.158h4a2 2 0 0 1 2 2v2" />
                            <path d="M12 12v.01" />
                            <path d="M3 13a20 20 0 0 0 11.905 1.928m3.263 -.763a20 20 0 0 0 2.832 -1.165" />
                            <path d="M3 3l18 18" />
                        </svg>
                        @elseif ($d->status == "sakit")
                        <div class="icon" style="color: red">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="48"  height="48"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-heartbeat">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M19.5 13.572l-7.5 7.428l-2.896 -2.868m-6.117 -8.104a5 5 0 0 1 9.013 -3.022a5 5 0 1 1 7.5 6.572" />
                                <path d="M3 13h2l2 3l2 -6l1 3h3" />
                            </svg>
                        @elseif ($d->status == "cuti")
                        <div class="icon" style="color: #17153B">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="48"  height="48"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-clock">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" />
                                <path d="M16 3v4" />
                                <path d="M8 3v4" />
                                <path d="M4 11h10" />
                                <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M18 16.5v1.5l.5 .5" />
                            </svg>
                            @elseif ($d->status == "dinas")
                        <div class="icon" style="color: #508C9B">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="48"  height="48"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-car">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M5 17h-2v-6l2 -5h9l4 5h1a2 2 0 0 1 2 2v4h-2m-4 0h-6m-6 -6h15m-6 0v-5" />
                            </svg>
                        @endif
                        </div>
                    @if ($d->status == "izin")
                    <div class="dataizin">
                        <h3 style="line-height: 3px; text-transform: uppercase">{{ $d->status }}</h3>
                        <small><span style="font-weight: bold">Keterangan:</span> {{ $d->keterangan }}</small></br>
                        <small><span style="font-weight: bold">Izin:</span> {{ hitunghari($d->tanggal,$d->tgl_izin_sampai) }} Hari</small><br>
                        @if (empty($d->alasan_tolak))
                        <small><span style="font-weight:bold">Alasan Penolakan:</span> -</small>
                        @else
                        <small><span style="font-weight:bold">Alasan Penolakan:</span> {{ $d->alasan_tolak }}</small>
                        @endif
                    </div>
                    @elseif ($d->status == "sakit")
                    <div class="dataizin">
                        <h3 style="line-height: 3px; text-transform: uppercase">{{ $d->status }}</h3>
                        <small><span style="font-weight: bold">Keterangan:</span> {{ $d->keterangan }}</small></br>
                        <small><span style="font-weight: bold">Izin Sakit:</span> {{ hitunghari($d->tanggal,$d->tgl_izin_sampai) }} Hari</small><br>
                        @if (empty($d->alasan_tolak))
                        <small><span style="font-weight:bold">Alasan Penolakan:</span> -</small></br>
                        @else
                        <small><span style="font-weight:bold">Alasan Penolakan:</span> {{ $d->alasan_tolak }}</small></br>
                        @endif
                    </div>
                        @elseif ($d->status == "cuti")
                        <div class="dataizin">
                            <h3 style="line-height: 3px; text-transform: uppercase">{{ $d->status }}</h3>
                            <small><span style="font-weight: bold">Nama Cuti:</span> {{$d->nama_cuti}}</small><br>
                            <small><span style="font-weight: bold">Alasan Cuti:</span> {{ $d->keterangan }}</small></br>
                            <small><span style="font-weight: bold">Izin Cuti:</span> {{ hitunghari($d->tanggal,$d->tgl_izin_sampai) }} Hari</small><br>
                            @if (empty($d->alasan_tolak))
                            <small><span style="font-weight:bold">Alasan Penolakan:</span> -</small></br>
                            @else
                            <small><span style="font-weight:bold">Alasan Penolakan:</span> {{ $d->alasan_tolak }}</small></br>
                            @endif
                        </div>
                        @elseif ($d->status == "dinas")
                        <div class="dataizin">
                            <h3 style="line-height: 3px; text-transform: uppercase">{{ $d->status }}</h3>
                            <small><span style="font-weight: bold">Keterangan:</span> {{ $d->keterangan }}</small></br>
                            <small><span style="font-weight: bold">Izin:</span> {{ hitunghari($d->tanggal,$d->tgl_izin_sampai) }} Hari</small><br>
                            @if (empty($d->alasan_tolak))
                            <small><span style="font-weight:bold">Alasan Penolakan:</span>{{ $d->alasan_tolak }}</small></br>
                            @else
                            <small><span style="font-weight:bold">Alasan Penolakan:</span> {{ $d->alasan_tolak }}</small></br>
                            @endif
                        </div>
                        @endif
                    <div class="status">
                        @if ($d->statues_approved == 0 )
                        <span class="badge bg-warning" style="width: 100px; height: 30px">Pending</span><br>
                        @elseif ($d->statues_approved == 1)
                        <span class="badge bg-success" style="width: 100px; height: 30px">Approved</span><br>
                        @elseif ($d->statues_approved == 2)
                        <span class="badge bg-danger" style="width: 100px; height: 30px">Rejected</span><br>
                        @endif
                    </div>
                </div>
            </div>
        </div>
       {{--<ul class="listview image-listview">
            <li>
                <div class="item">
                    <div class="in">
                        <div>
                        <b>{{ date("d-m-Y", strtotime($d->tanggal)) }} ({{ $d->status }})</b></br>
                        <small class="text-muted">{{ $d->keterangan }}</small>
                        </div>
                        @if ($d->statues_approved == 0)
                        <span class="badge bg-warning">Pending untuk Approval</span>
                        @elseif ($d->statues_approved == 1)
                        <span class="badge bg-success">Approved</span>
                        @elseif ($d->statues_approved == 2)
                        <span class="badge bg-danger">Rejected</span>
                        @endif
                    </div>
                </div>
            </li>
        </ul>
        kemungkinan masih ada kegunaan  !important jng dihapus --}}
        @endforeach
    </div>
</div>
<!-- untuk membuatizin  -->
<div class="fab-button animate bottom-right dropdown" style="margin-bottom: 70px">
    <a href="#" class="fab bg-primary" data-toggle="dropdown">
        <ion-icon name="add-outline" roles="img" class="md hyreated" aria-label="add outline"></ion-icon>
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item bg-primary" href="{{url('/izinabsen')}}">
            <ion-icon name="document-outline"></ion-icon>
            <p>Izin absen</p>
        </a>
        <a class="dropdown-item bg-primary" href="{{url('/izinsakit')}}">
            <ion-icon name="document-outline"></ion-icon>
            <p>Sakit</p>
        </a>
        <a class="dropdown-item bg-primary" href="{{url('/izincuti')}}">
            <ion-icon name="document-outline"></ion-icon>
            <p>Cuti</p>
        </a>
        <a class="dropdown-item bg-primary" href="{{url('/izindinas')}}">
            <ion-icon name="document-outline"></ion-icon>
            <p>Dinas</p>
        </a>
    </div>
</div>
<!-- modal untuk mengedit dan menghapus izin/sakit/cuti/dinas -->
<div class="modal fade action-sheet" id="actionSheetIconed" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aksi</h5>
            </div>
            <div class="modal-body" id="showact">

            </div>
        </div>
    </div>
</div>
<!-- modal -->
<div class="modal fade dialogbox" id="deleteConfirm" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yakin Dihapus ?</h5>
            </div>
            <div class="modal-body">
                Data Pengajuan Izin Akan dihapus
            </div>
            <div class="modal-footer">
                <div class="btn-inline">
                    <a href="#" class="btn btn-text-secondary" data-dismiss="modal">Batalkan</a>
                    <a href="" class="btn btn-text-primary" id="hapuspengajuan">Hapus</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('myscript')
<!-- jquery untuk mendorong modal -->
<script>
    $(function(){
        $(".card_izin").click(function(e){
            var kode_izin = $(this).attr("kode_izin");
            var statues_approved =$(this).attr("statues_approved");
            if( statues_approved == 1){
                Swal.fire({
                    title: 'Oops!!!',
                    text: 'Data sudah disetujui, Tidak bisa diubah/edit',
                    icon: 'warning',
                    confirmButtonText: 'Oke'
                });
                return; // mencegah menjalankan #showact
            } else { //error showact tidak load
                console.log("Loading showact for kode_izin:", kode_izin); // Added log for debugging
                $("#showact").load('/izin/'+ kode_izin +'/showact');
            }
        });
    });
</script>
@endpush
