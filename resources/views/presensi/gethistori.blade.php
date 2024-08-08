@if($histori->isEmpty())
    <div class="alert alert-warning">
        Data Kosong
    </div>
@endif
@foreach($histori as $d)
<ul class="listview image-listview">
    <li>
    <div class="item">
        @php
            $path = Storage::url('upload/absensi/'.$d->foto_in);
        @endphp
        <img src="{{ asset($path) }}" alt="image" class="image">
            <div class="in">
                <div>
                    {{ date("d-m-Y", strtotime($d->tgl_presensi))}}<br>
                    {{-- //<small class="text-muted">{{ $d->jabatan}}</small> --}}
                </div>
                <span class="badge {{ $d->jam_in < '08:30' ? 'badge-success' : 'badge-danger'}}">
                    {{ $d->jam_in}}</span>
                    <span class="badge bg-primary">{{ $d->jam_out}}</span>
                </div>
            </div>
        </li>
    </ul>
@endforeach

