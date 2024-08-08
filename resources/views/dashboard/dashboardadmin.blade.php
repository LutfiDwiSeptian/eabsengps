@extends('layout.admin.tabler')
@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
<div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Overview
                </div>
                <h2 class="page-title">
                  Dashboard Admin
                </h2>
              </div>
            </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="row">
      <div class="col-md-6 col-xl-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-success text-white avatar">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-fingerprint">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M18.9 7a8 8 0 0 1 1.1 5v1a6 6 0 0 0 .8 3" />
                  <path d="M8 11a4 4 0 0 1 8 0v1a10 10 0 0 0 2 6" />
                  <path d="M12 11v2a14 14 0 0 0 2.5 8" />
                  <path d="M8 15a18 18 0 0 0 1.8 6" />
                  <path d="M4.9 19a22 22 0 0 1 -.9 -7v-1a8 8 0 0 1 12 -6.95" />
                </svg>
                            </span>
                          </div>
          <div class="col">
            <div class="font-weight-medium">
              {{ $rekapabsen->jmlhadir}}
            </div>
              <div class="text-secondary">
                Total karyawan hadir 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-primary text-white avatar">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                  <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                </svg>
                            </span>
                          </div>
          <div class="col">
            <div class="font-weight-medium">
              {{ $karyawan }}
            </div>
              <div class="text-secondary">
                Total karyawan 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-info text-white avatar">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-pill">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M4.5 12.5l8 -8a4.94 4.94 0 0 1 7 7l-8 8a4.94 4.94 0 0 1 -7 -7" />
                  <path d="M8.5 8.5l7 7" /></svg>
                            </span>
                          </div>
          <div class="col">
            <div class="font-weight-medium">
              {{ $rekapizin->jmlsakit != null ? $rekapizin->jmlsakit : 0 }}
            </div>
              <div class="text-secondary">
                Sakit 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-info text-white avatar">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-description">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                  <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                  <path d="M9 17h6" />
                  <path d="M9 13h6" />
                </svg>
                            </span>
                          </div>
          <div class="col">
            <div class="font-weight-medium">
              {{ $rekapizin->jmlizin != null ? $rekapizin->jmlizin : 0 }}
            </div>
              <div class="text-secondary">
                Izin 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-danger text-white avatar">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-alarm"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M12 10l0 3l2 0" /><path d="M7 4l-2.75 2" /><path d="M17 4l2.75 2" />
              </svg>
                </svg>
                            </span>
                          </div>
          <div class="col">
            <div class="font-weight-medium">
            {{ $rekapabsen->jmlterlambat }}
            </div>
              <div class="text-secondary">
                Terlambat 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection