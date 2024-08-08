@extends('layout.admin.tabler')

@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
        <div class="col">
            <!-- Page pre-title -->
            <h2 class="page-title">
                  Setting Lokasi Kantor
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        @if (Session::get('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        @if (Session::get('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                        @endif
                        <form action="/konfigurasi/updatelokasi" method="POST">
                        @csrf
                        <div class="row">
                            <h4>Coordinate Lokasi Kantor</h4>
                            <h5>Coordinate saat ini {{$lok_kantor->lokasi_kantor}}</h5>
                        </div>
                        <div class="row">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-map">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M3 7l6 -3l6 3l6 -3v13l-6 3l-6 -3l-6 3v-13" />
                                    <path d="M9 4v13" />
                                    <path d="M15 7v13" />
                                </svg>
                                </span>
                                <input type="text" value="{{$lok_kantor->lokasi_kantor}}" id="lokasikantor" class="form-control" placeholder="Lokasi Kantor" name="lokasikantor">
                                </div>
                            </div>
                            <div class="row">
                                <h4>Radius</h4>
                                <h5>Radius dihitung dengan meter</h5>
                            </div>
                            <div class="row">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-meter-cube">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M17 5h1.5a1.5 1.5 0 0 1 0 3h-.5h.5a1.5 1.5 0 0 1 0 3h-1.5" />
                                        <path d="M4 12v6" /><path d="M4 14a2 2 0 0 1 2 -2h.5a2.5 2.5 0 0 1 2.5 2.5v3.5" />
                                        <path d="M9 15.5v-1a2.5 2.5 0 1 1 5 0v3.5" />
                                    </svg>
                                    </span>
                                    <input type="text" value="{{$lok_kantor->radius}}" id="radius"class="form-control" placeholder="Radius" name="radius">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100">Update Lokasi</button>
                                    </div>
                                </div>
                        </form>
                        <div class="row">
                            <div class="col-12">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection