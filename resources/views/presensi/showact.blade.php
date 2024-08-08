<ul class="action-button-list">
    <li>
        @if ($dataizin->status=="izin")
        <a href="{{url('/izinabsen/{{ $dataizin->kode_izin}}/edit')}}"  class="btn btn-list text-primary">
            <span>
                <ion-icon name="create-outline"></ion-icon>
                Edit Absen
            </span>
        </a>
        @elseif($dataizin->status=="sakit")
        <a href="{{url('/izinsakit/{{ $dataizin->kode_izin}}/edit')}}"  class="btn btn-list text-primary">
            <span>
                <ion-icon name="create-outline"></ion-icon>
                Edit Sakit
            </span>
        </a>
        @elseif($dataizin->status=="cuti")
        <a href="{{url('/izincuti/{{ $dataizin->kode_izin}}/edit')}}"  class="btn btn-list text-primary">
            <span>
                <ion-icon name="create-outline"></ion-icon>
                Edit Cuti 
            </span>
        </a>
        @elseif($dataizin->status=="dinas")
        <a href="{{url('/izindinas/{{ $dataizin->kode_izin}}/edit')}}"  class="btn btn-list text-primary">
            <span>
                <ion-icon name="create-outline"></ion-icon>
                Edit dinas 
            </span>
        </a>
        @endif
    </li>
    <li>
        <a href="#" id="deletebutton" class="btn btn-list text-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteConfirm">
            <span>
                <ion-icon name="trash-outline"></ion-icon>
                Delete
            </span>
        </a>
    </li>
</ul>

<script>
    $(function(){
        $("#deletebutton").click(function(e){
            $("#hapuspengajuan").attr('href','/izin/'+'{{ $dataizin->kode_izin}}/delete'); 
        });
    });
</script>