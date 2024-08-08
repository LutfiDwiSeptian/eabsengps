@extends('layout.presensi')
@section('content')
<div class="section" id="user-section">
            <div id="user-detail">
                <div class="avatar">
                    @if(!empty (Auth::guard('karyawan')->user()->foto))
                    <?php
                        $path = Storage::url('upload/karyawan/'.Auth::guard('karyawan')->user()->foto);
                    ?>
                    <img src="{{ url($path) }}" alt="avatar" class="imaged w64" style="height: 60px;" onerror="this.onerror=null; this.src='{{ asset('assets/img/sample/avatar/avatar1.jpg') }}';">
                    @else
                    <img src="{{ asset('assets/img/sample/avatar/avatar1.jpg')}}" alt="avatar" class="imaged w64 rounded">
                    @endif
                </div>
                <div id="user-info">
                    <h2 id="user-name">{{ Auth::guard('karyawan')->user()->nama_lengkap}}<span class="ml-1" style="font-size:small;">{{ Auth::guard('karyawan')->user()->kode_dpt}}</span></h2>
                    <span id="user-role" style="font-size: 1.2rem;">{{ Auth::guard('karyawan')->user()->jabatan}} {{ Auth::guard('karyawan')->user()->nik}}</span>
                </div>
            </div>
        </div>
        <div class="section" id="menu-section">
            <div class="card">
                <div class="card-body text-center">
                    <div class="list-menu">
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ url('/editprofile') }}" class="green" style="font-size: 40px;">
                                    <ion-icon name="person-sharp"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Profil</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ url('/presensi/izin')}}" class="danger" style="font-size: 40px;">
                                    <ion-icon name="calendar-number"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Izin</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ url('/presensi/histori')}}" class="warning" style="font-size: 40px;">
                                    <ion-icon name="document-text"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Histori</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ url('/proseslogout') }}" class="orange" style="font-size: 40px;">
                                <ion-icon name="log-out-outline"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Logout
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hari"></div>
        <div class="section mt-2" id="presence-section">
            <div class="todaypresence">
                <div class="row">
                    <div class="col-6">
                        <div class="card gradasigreen">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        @if ($presensihariini != null)
                                        @php
                                            $path = Storage::url('upload/absensi/'.$presensihariini->foto_in);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w48 ">
                                        @else ($presensiharini = null)
                                        <ion-icon name="camera"></ion-icon>
                                        @endif
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Masuk</h4>
                                        <span>{{ $presensihariini != null ? $presensihariini->jam_in : 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card gradasired">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                    @if ($presensihariini != null )
                                        @php
                                            $path = Storage::url('upload/absensi/'.$presensihariini->foto_out);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w48 ">
                                        @else ($presensiharini = null)
                                        <ion-icon name="camera"></ion-icon>
                                        @endif
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Pulang</h4>
                                        <span>{{ $presensihariini != null && $presensihariini->jam_out != null ? $presensihariini->jam_out : 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="rekappresensi">
                <h3 >Ini hari {{ $namahari[$inihari] }} Tanggal {{ $tanggalini }}</h3>
                <h3 >Rekap Presensi Bulan {{ $namabulan[$bulanini] }} Tahun {{ $tahunini }}</h3>
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
                            <span class="badge bg-danger" style="position: absolute; top: 0; right: 0;" z-index="99">{{ $rekapabsen->jmlhadir }}</span>
                            <ion-icon name="accessibility-outline" style="font-size: 1.7rem;" class="text-primary mb-1"></ion-icon>
                            <br>
                            <span style="font-weight: bold; font-size: 0.7rem;">Hadir</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
                        <span class="badge bg-danger" style="position: absolute; top: 0; right: 0;" z-index="99">{{$rekapizin->jmlizin}}</span>
                            <ion-icon name="newspaper-outline" style="font-size: 1.7rem;" class="text-success mb-1"></ion-icon>
                            <br>
                            <span style="font-weight: bold; font-size: 0.7rem;">Izin</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
                            <span class="badge bg-danger" style="position: absolute; top: 0; right: 0;" z-index="99">{{$rekapizin->jmlsakit}}</span>
                            <ion-icon name="bag-add-outline" style="font-size: 1.7rem;" class="text-warning mb-1"></ion-icon>
                            <br>
                            <span style="font-weight: bold; font-size: 0.7rem;">Sakit</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
                            <span class="badge bg-danger" style="position: absolute; top: 0; right: 0;" z-index="99">{{ $rekapabsen->jmlterlambat  }}</span>
                            <ion-icon name="timer-outline" style="font-size: 1.7rem;" class="text-danger mb-1"></ion-icon>
                            <br>
                            <span style="font-weight: bold; font-size: 0.7rem;">Telat</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="presencetab mt-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Bulan Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Leaderboard
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach($historibulanini as $d)
                            @if ($d->status == "hadir")
                            @php
                            $path = Storage::url('upload/absensi/'.$d->foto_in);
                             @endphp
                            <li>
                            <div class="item">
                                <div class="icon-box bg-primary">
                                    <img src="{{ url($path) }}" alt="" class="imaged w64">
                                </div>
                                    <div class="in">
                                    <div>{{ date("d-m-Y",strtotime($d->tgl_presensi))}}</div>
                                        <span class="badge badge-success">{{$d->jam_in}}</span>
                                        <span class="badge badge-danger">{{ $presensihariini != null && $d->jam_out!= null ? $d->jam_out : 'Belum Absen'}}</span>
                                    </div>
                                </div>
                             </li>
                             @elseif ($d->status == "izin" || $d->status == "sakit" || $d->status == "cuti" || $d->status == "dinas" )
                             <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                   <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-file text-primary">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 2l.117 .007a1 1 0 0 1 .876 .876l.007 .117v4l.005 .15a2 2 0 0 0 1.838 1.844l.157 .006h4l.117 .007a1 1 0 0 1 .876 .876l.007 .117v9a3 3 0 0 1 -2.824 2.995l-.176 .005h-10a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-14a3 3 0 0 1 2.824 -2.995l.176 -.005h5z" />
                                        <path d="M19 7h-4l-.001 -4.001z" />
                                    </svg>
                                    </div>
                                    <h5>IZIN</h5><hr>
                                    <div>
                                        <h5>{{ date("d-m-Y",strtotime($d->tgl_presensi))}}</h5>
                                    </div>
                                </div>
                            </li>
                            @endif
                            @endforeach 
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach($leaderboard as $d)
                            <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    <div class="in">
                                        <div>
                                            {{ $d->nama_lengkap}}<br>
                                            <small class="text-muted">{{ $d->jabatan}}</small>
                                        </div>
                                        <span class="badge {{ $d->jam_in < '08:30' ? 'badge-success' : 'badge-danger'}}">{{ $d->jam_in}}</span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                </div>
            </div>
        </div>
@endsection