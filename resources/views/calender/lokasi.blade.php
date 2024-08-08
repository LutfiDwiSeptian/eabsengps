@extends('layout.presensi')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
      <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
<style>
    #map {
        height: 100px;
    }
</style>
@section('header')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="/" class="btn btn-block bg-transparent" style="margin-top: 12px">
        <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">LOKASI</div>
    <div class="right"></div>
</div>
@endsection
@section ('content')
<div id="map"></div>
@endsection