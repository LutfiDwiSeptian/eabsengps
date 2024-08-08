@extends('layout.presensi')
@section('header')
<div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Presensi</div>
        <div class="right"></div>
    </div>
    <style>
        .webcam-capture,
        .webcam-capture video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 20px;
        }
        #map { 
            height: 180px;
            border-radius: 15px; 
        }

    </style>
@endsection
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-path-transform"></script>
@section('content')
 <div class="row" style="margin-top: 70px">
   <div class="col">
    <input type="hidden" id="lokasi">
    <div class="webcam-capture">   
    </div>
   </div>
 </div>
 <div class="row">
    <div class="col">
        @if ($cek > 0)
        <button id="takeabsen" class="btn btn-danger btn-block disabled"><ion-icon name="camera-outline"></ion-icon>ABSEN PULANG</button>
        @else
        <button id="takeabsen" class="btn btn-primary btn-block"><ion-icon name="camera-outline"></ion-icon>ABSEN MASUK</button>
        @endif
    </div>
 </div>
 <div class="row mt-2">
    <div class="col">
    <div id="map"></div>
    </div>
 </div>

 <audio id="notifikasi_in">
    <source src="{{asset('assets/sound/notifikasi_in.mp3')}}" type="audio/mpeg">
 </audio>
 <audio id="notifikasi_out">
    <source src="{{asset('assets/sound/notifikasi_out.mp3')}}" type="audio/mpeg">
 </audio>
 <audio id="notifikasi_jarak">
    <source src="{{asset('assets/sound/notifikasi_jarak.mp3')}}" type="audio/mpeg">
 </audio>
 @endsection
 @push('myscript')
 <script>

    var notifikasi_in = document.getElementById('notifikasi_in');
    var notifikasi_out = document.getElementById('notifikasi_out');
    var notifikasi_jarak = document.getElementById('notifikasi_jarak')

    Webcam.set({
        width: 640,
        height: 480,
        image_format: 'jpeg',
        image_quality: 80,
        max_retries: 10
    });
    Webcam.attach('.webcam-capture');

    var lokasi = document.getElementById('lokasi');
    if (navigator.geolocation){
         navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    }

    function successCallback(position){
        lokasi.value = position.coords.latitude + ',' + position.coords.longitude;
        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
        var lokasi_kantor = "{{ $lokasi->lokasi_kantor }}"
        var lok = lokasi_kantor.split(",");
        var lat_kantor = lok[0];
        var long_kantor = lok[1];
        var radius = {{$lokasi->radius}};
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        // Menggunakan L.circle untuk membuat lingkaran
        //-6.904601096406407, 107.58408868052425]lokasi kantor untuk absen
        //-6.906026076486947, 107.5858670046314 lokasi palsu untuk pengetesan
        var circle = L.circle([lat_kantor,long_kantor], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: radius // Radius dalam meter
        }).addTo(map);
    }

    function errorCallback(error){
        console.log(error);
    }

    $("#takeabsen").click(function(e){
        console.log("Button clicked"); // Cek apakah tombol benar-benar diklik
        Webcam.snap(function(uri){
            var image = uri;
            console.log("Image captured", image); // Cek apakah gambar berhasil diambil

            var lokasi = $("#lokasi").val();
            console.log("Location", lokasi); // Cek nilai lokasi

            $.ajax({
                type:'POST',
                url:'/presensi/store',
                data:{
                    _token:"{{ csrf_token() }}",
                    image: image,
                    lokasi: lokasi
                },
                cache:false,
                success:function(respond){
                    var status = respond.split("|");
                    if (status[0] == "Sucess"){
                        if(status[2] == "in"){
                          notifikasi_in.play();
                        }else{
                          notifikasi_out.play();
                        }
                        Swal.fire({
                            title: 'Berhasil!',
                            text: status[1],
                            icon: 'success',
                            confirmButtonText: 'Oke'
                            })
                            setTimeout(()=>{
                                window.location.href = '/dashboard';
                            }, 4000);
                    }else{
                        if (status[2] == "jarak"){
                            notifikasi_jarak.play(); // Corrected variable name
                        }
                        Swal.fire({
                            title: 'Gagal!',
                            text: status[1],
                            icon: 'error',
                            confirmButtonText: 'Oke'
                            })
                    }
                }
            });
        });
    });

 </script>
 @endpush

