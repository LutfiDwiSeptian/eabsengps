@extends ('layout.admin.tabler')
@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
        <div class="col">
            <!-- Page pre-title -->
            <h2 class="page-title">
                  Data IZIN / SAKIT
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="rw">
            <div class="col-12">
                @if (Session::get('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                @endif
                @if (Session::get('error'))
                <div class="alert alert-error">
                    {{Session::get('error')}}
                @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="{{ url('/presensi/izinsakit')}}" method="GET" autocomplete="off">
                    <div class="row">
                        <div class="col-6">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-event">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                        <path d="M16 3l0 4" />
                                        <path d="M8 3l0 4" />
                                        <path d="M4 11l16 0" />
                                        <path d="M8 15h2v2h-2z" />
                                    </svg>
                                </span>
                                <input type="text" value="{{ Request('dari')}}" id="dari"class="form-control" placeholder="Dari" name="dari">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-event">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                        <path d="M16 3l0 4" />
                                        <path d="M8 3l0 4" />
                                        <path d="M4 11l16 0" />
                                        <path d="M8 15h2v2h-2z" />
                                    </svg>
                                </span>
                                <input type="text" value="{{ Request('sampai')}}" id="sampai" class="form-control" placeholder="Sampai" name="sampai">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-id">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                        <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M15 8l2 0" />
                                        <path d="M15 12l2 0" />
                                        <path d="M7 16l10 0" />
                                    </svg>
                                </span>
                                <input type="text" value="{{ Request('nik')}}" id="nik"class="form-control" placeholder="Nik" name="nik">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    </svg>
                                </span>
                                <input type="text" value="{{ Request('nama_lengkap')}}" id="nama_lengkap"class="form-control" placeholder="Nama Karyawan" name="nama_lengkap">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <select name="statues_approved" id="statues_approved" class="form-select">
                                    <option value="">Pilih Status</option>
                                    <option value="0" {{ Request('statues_approved')== '0' ? 'selected' : ''}}>Pending</option>
                                    <option value="1" {{ Request('statues_approved')==1 ? 'selected' : ''}}>Approved</option>
                                    <option value="2" {{ Request('statues_approved')==2 ? 'selected' : ''}}>Rejected</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>Cari Data
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-border">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Pengajuan</th>
                            <th>Tanggal</th>
                            <th>Nik</th>
                            <th>Nama</th>
                            <th>Department</th>
                            <th>Izin/sakit</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($izinsakit as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $d->kode_izin }}</td>
                            <td>{{ date('d-m-Y',strtotime($d->tanggal)) }} S/D {{ date('d-m-Y',strtotime($d->tgl_izin_sampai)) }}  </td>
                            <td>{{ $d->nik}}</td>
                            <td>{{ $d->nama_lengkap}}</td>
                            <td>{{ $d->nama_dept}}</td>
                            <td>{{ $d->status }}</td>
                            <td>{{ $d->keterangan}}</td>
                            <td>
                                @if ($d->statues_approved == 1)
                                <span class="badge bg-success" style="color: white">Approved</span>
                                @elseif ($d->statues_approved == 2)
                                <span class="badge bg-danger" style="color: white">Rejected</span>
                                @elseif ($d->statues_approved == 0)
                                <span class="badge bg-warning" style="color: white">Pending</span>
                                @endif
                            </td>
                             <td>
                                @if ($d->statues_approved == 0)
                                <a href="#" class="btn btn-lg btn-outline-primary tombol" id="" kode_izin="{{ $d->kode_izin }}">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-external-link">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" />
                                        <path d="M11 13l9 -9" />
                                        <path d="M15 4h5v5" />
                                    </svg>
                                </a>
                                @else
                                <a href="{{ url('/presensi/' . $d->kode_izin . '/batalkanzizinsakit') }}" class="btn btn-outline-warning">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M18 6l-12 12" />
                                    <path d="M6 6l12 12" />
                                </svg></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $izinsakit->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal-izinsakit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Approve/Rejected</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ url('/presensi/approveizinsakit') }}" method="POST">
                @csrf
                <input type="hidden" id="kode_izin_form" name="kode_izin_form">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <select name="statues_approved" id="statues_approved" class="form-select">
                                <option value="1">Approved</option>
                                <option value="2">Rejected</option>
                            </select>
                            <div class="mb-3 mt-5">
                               <label class="form-label">Alasan Penolakan<span class="form-label-description"></span></label>
                               <textarea class="form-control" name="alasan_tolak" rows="6" placeholder="Alasan penolakan"></textarea>
                             </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-primary w-100" type="submit"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('myscript')
<script>
    $(function(){
        $(".tombol").click(function(e){
            e.preventDefault();
            var kode_izin = $(this).attr("kode_izin");
            $("#kode_izin_form").val(kode_izin);
            $("#modal-izinsakit").modal("show");
            console.log("Clicked button with id_izinsakit: " + id_izinsakit);
        });

        $("#dari, #sampai").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });
    });
</script>
@endpush
