@extends ('layout.admin.tabler')
@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
        <div class="col">
            <!-- Page pre-title -->
            <h2 class="page-title">
                  Data Department
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
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
                        <div class="row mt-2">
                            <div class="col-12">
                                <form action="{{url('/department')}}" method="GET">
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="nama_dept"  placeholder="Nama Department" name="nama_dept" value="{{ Request('nama_dept')}}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                    <path d="M21 21l-6 -6" />
                                                </svg>
                                                Cari
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-2 mt-2">
                                            <div class="form-group">
                                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-inputkaryawan" id="btntambahdepartment">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" />
                                                    <path d="M5 12l14 0" />
                                                </svg>
                                                Tambah Data
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div class="col-12 mt-3">
                        <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Department</th>
                        <th>Nama Department</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($department as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $d->kode_dept}}</td>
                            <td>{{ $d->nama_dept}}</td>
                            <td>
                                <div class="btn-group mb-2">
                                    <a href="#" class="edit btn btn-primary btn-sm" kode_dept="{{ $d->kode_dept }}">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" />
                                            </svg>
                                        </a>
                                    </div>
                                    <form action="{{ url('/department/'.$d->kode_dept.'/delete') }}" method="POST" id="form-deletekaryawan">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#" class="btn btn-danger btn-sm delete-confirm" >
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                        </a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                        </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal-inputdept" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Data Department</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered">
                <form action="{{ url('/department/store')}}" method="POST" id="form-inputdept">
                    @csrf
                    <div class="row">
                    <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-barcode"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7v-1a2 2 0 0 1 2 -2h2" /><path d="M4 17v1a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v1" /><path d="M16 20h2a2 2 0 0 0 2 -2v-1" /><path d="M5 11h1v2h-1z" /><path d="M10 11l0 2" /><path d="M14 11h1v2h-1z" /><path d="M19 11l0 2" /></svg>
                                </span>
                                <input type="text" value="" id="kode_department"class="form-control" placeholder="Kode Department" name="kode_dept">
                        </div>
                    </div>
                    <div class="row">
                    <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path></svg>
                                </span>
                                <input type="text" value="" id="nama_department" class="form-control" placeholder="Nama Department" name="nama_dept">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-primary w-100">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                                        Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </table>
          </div>
        </div>
      </div>
    </div>
<!-- Modal Edit -->
    <div class="modal modal-blur fade" id="modal-editdepartment" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Data Department</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="loadedit">

          </div>
        </div>
      </div>
    </div>
@endsection
@push('myscript')
<script>
    $(document).ready(function(){
        $('#btntambahdepartment').click(function(){
            $('#modal-inputdept').modal('show');
        });

        $('.edit').click(function(){
            var kode_dept = $(this).attr('kode_dept');
            $.ajax({
                type:"POST"
                ,   url:'/department/edit'
                ,   cache:false
                ,   data:{
                       _token:"{{  csrf_token() }}"
                    ,  kode_dept: kode_dept

                },
                success:function(respond){
                    $('#loadedit').html(respond);
                }
            });
            $('#modal-editdepartment').modal('show');
        });

        $('.delete-confirm').click(function(e){
            var form = $(this).closest('form');
            e.preventDefault();
            Swal.fire({
                title: "Menghapus Data?",
                showCancelButton: true,
                confirmButtonText: "Hapus",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire("Data berhasil dihapus", "", "success");
                }
            });
        });

        $('#form-inputkaryawan').submit(function(e){
            var nik = $("#nik").val();
            var nama_lengkap = $("#nama_lengkap").val();
            var jabatan = $("#jabatan").val();
            var no_hp = $("#no_hp").val();
            var alamat = $("#alamat").val();
            var foto = $("#foto").val();
            var kode_dept = $("form-inputkaryawan").find("#kode_dept").val();

            if(nik == '' || nama_lengkap == '' || jabatan == '' || no_hp == '' || alamat == '' || foto == '' || kode_dept == ''){
                //alert('Semua field harus diisi');
                Swal.fire({
                    title: 'Masih ada yang kosong',
                    text: 'Semua field harus diisi',
                    icon: 'warning',
                    confirmButtonText: 'Cool'
                })
                return false;
            }
        });
    });
</script>
@endpush
