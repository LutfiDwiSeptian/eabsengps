<?php
function selisih($jam_masuk, $jam_keluar)
        {
            list($h, $m, $s) = explode(":", $jam_masuk);
            $dtAwal = mktime($h, $m, $s, "1", "1", "1");
            list($h, $m, $s) = explode(":", $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode(".", $totalmenit / 60);
            $sisamenit = ($totalmenit / 60) - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return $jml_jam . ":" . round($sisamenit2);
        }
?>
<?php
use Illuminate\Support\Facades\Storage;
?>
@foreach ($presensi as $d)
<?php
    $foto_in = Storage::url('upload/absensi/' . $d->foto_in);
    $foto_out = Storage::url('upload/absensi/' . $d->foto_out);
?>
<tr>
    <td>{{ $loop->iteration}}</td>
    <td>{{ $d->nik }}</td>
    <td>{{ $d->nama_lengkap }}</td>
    <td>{{ $d->nama_dept }}</td>
    <td>{{ $d->jam_in }}</td>
    <td><img src="{{ $foto_in }}" alt="Foto Masuk" class="avatar"></td>
    <td>{{ $d->jam_out }}</td>
    <td><img src="{{ $foto_out }}" alt="Foto Pulang" class="avatar"></td>
    <td>
        @if($d->jam_in >= '08:10:59')
        <?php
            $jamterlambat = selisih('08:10:59', $d->jam_out);
        ?>
            <span class="badge bg-danger" style="color: white;">Terlambat {{ $jamterlambat }}</span>
        @else
            <span class="badge bg-success" style="color: white;">Tepat Waktu</span>
        @endif
    </td>
    <td>
        <a href="#" class="btn btn-primary tampilkanpeta" id="{{ $d->id }}">
        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="#ffffff"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-current-location"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M12 12m-8 0a8 8 0 1 0 16 0a8 8 0 1 0 -16 0" /><path d="M12 2l0 2" /><path d="M12 20l0 2" /><path d="M20 12l2 0" /><path d="M2 12l2 0" /></svg></a>
    </td>
</tr>
@endforeach

<script>
    $(function(){
        $(".tampilkanpeta").click(function(e){
            var id =$(this).attr("id");
            $.ajax({
                type:'POST',
                url:'/tampilkanpeta',
                data:{
                    _token:"{{ csrf_token()}}",
                    id: id ,
                },
                cache:false,
                success:function(respond){
                    $("#loadmap").html(respond);
                }
            })
            $("#modal-peta").modal("show");
        });
    });
</script>