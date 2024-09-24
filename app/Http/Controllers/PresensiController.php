<?php

namespace App\Http\Controllers;

use App\Models\karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\Pengajuanizin;

class PresensiController extends Controller
{
    // Function to create a new presensi entry
    public function create()
    {
        $hariini = date("Y-m-d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nik', $nik)->count();
        $lokasi = DB::table('konfigurasi_lokasi')->where('id',0)->first();
        return view('presensi.create', compact('cek','lokasi'));
    }

    // Function to store a new presensi entry
    public function store(Request $request)
    {
        try {
            $nik = Auth::guard('karyawan')->user()->nik;
            $tgl_presensi = date("Y-m-d");
            $jam = date("H:i:s");
            $lokasi_kantor = DB::table('konfigurasi_lokasi')->where('id',0)->first();
            $lok = explode(",",$lokasi_kantor->lokasi_kantor);
            $latitudekantor =  $lok[0];
            $longitudekantor = $lok[1];
            $lokasi = $request->lokasi;
            $lokasiuser = explode(",", $lokasi);
            $latitudeuser = $lokasiuser[0];
            $longitudeuser = $lokasiuser[1];
            $jarak = $this->distance($latitudekantor,$longitudekantor,$latitudeuser,$longitudeuser);
            $radius = round($jarak["meters"]);

            $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();
            if ($cek > 0){
                $ket ="out.";
            }else{
                $ket ="in.";
            }
            $image = $request->image;
            $folderPath = "public/upload/absensi/";
            $formatName = $nik."-".$tgl_presensi."-".$ket;
            $image_parts = explode(";base64,", $image);
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = $formatName."png";
            $file = $folderPath . $fileName;


            if ($radius > $lokasi_kantor->radius){
                echo "Error|Jarak anda ".$radius." meter dari kantor|jarak";
            } else {
                if ($cek > 0){
                    // Update data jika sudah ada
                    $data_pulang = [
                        'jam_out' => $jam,
                        'foto_out' => $fileName,
                        'lokasi_out' => $lokasi,
                    ];
                    $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                    if ($update){
                        echo "Sucess|Terimakasih, Berhati-hati dijalan|out";
                        Storage::put($file, $image_base64);
                    } else {
                        echo 'error|Maaf, Absensi Gagal|out';
                    }
                } else {
                    // Insert data jika belum ada
                    $data = [
                        'nik' => $nik,
                        'tgl_presensi' => $tgl_presensi,
                        'jam_in' => $jam,
                        'foto_in' => $fileName,
                        'lokasi_in' => $lokasi,
                        'status' => 'hadir'
                    ];
                    $simpan = DB::table('presensi')->insert($data);
                    if ($simpan){
                        echo "Sucess|Terimakasih, Absensi Sudah diterima|in";
                        Storage::put($file, $image_base64);
                    } else {
                        echo 'error|Maaf, Absensi Gagal|in';
                    }
                }
            }
        } catch (\Exception $e) {
            header('Content-Type: text/plain');
            echo 'Error: ' . $e->getMessage();
        }
    }

    // Menghitung Jarak
    private function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }


    public function editprofile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('presensi.editprofile', compact('karyawan'));
    }
    public function updateprofile(Request $request)
    {
       $nik = Auth::guard('karyawan')->user()->nik;
       $nama_lengkap = $request->nama_lengkap;
       $no_hp = $request->no_hp;
       $password = Hash::make($request->password);
       $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
       if ($request->hasFile('foto')){
        $foto = $nik.".".$request->file('foto')->getClientOriginalExtension();
       }else {
        $foto = $karyawan->foto;
       }
       if (empty($request->password)) {
           $data = [
               'nama_lengkap' => $nama_lengkap,
               'no_hp' => $no_hp,
               'foto' => $foto,
           ];
       } else {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto,
            ];
       }

       try {
            $update = DB::table('karyawan')->where('nik', $nik)->update($data);

            if ($request->hasFile('foto')){
                $folderPath = "public/upload/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }

            return Redirect::back()->with(['success' => 'DATA BERHASIL TERSIMPAN']);
       } catch (\Throwable $th) {
           return Redirect::back()->with(['error'=> 'Data Gagal di Update']);
       }
    }

    public function histori()
    {
        $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        return view('presensi.histori', compact('namabulan'));
    }
    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;
        $histori = DB::table('presensi')
        ->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
        ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
        ->where('nik',$nik)
        ->orderBy('tgl_presensi')
        ->get();

        return view('presensi.gethistori', compact('histori'));

    }

    public function izin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;

        $dataizin = DB::table('pengajuan_izin as pi') // Alias untuk tabel
            ->leftJoin('master_cuti as mc', 'pi.kode_cuti', '=', 'mc.kode_cuti')
            ->where('pi.nik', $nik)
            ->orderByDesc('pi.tanggal') // Pastikan menggunakan alias
            ->when(!empty($request->bulan) && !empty($request->tahun), function ($query) use ($request) {
                return $query->whereRaw('MONTH(pi.tanggal)="'.$request->bulan.'"')
                             ->whereRaw('YEAR(pi.tanggal)="'.$request->tahun.'"');
            })
            ->limit(10)
            ->get();

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view ('presensi.izin', compact('dataizin','namabulan'));
    }

    public function buatizin()
    {
        return view ('presensi.buatizin');
    }
    public function storeizin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tanggal = $request->tanggal;
        $status = $request->status;
        $keterangan = $request->keterangan;

        // untuk upload data ke database
        $data = [
            'nik' => $nik,
            'tanggal' => $tanggal,
            'status' => $status,
            'keterangan' => $keterangan,
        ];

        // data masuk ke database
        $simpan = DB::table('pengajuan_izin')->insert($data);
        if ($simpan) {
            return redirect('/presensi/izin')->with(['success' => 'DATA BERHASIL TERSIMPAN']);
        } else {
            return redirect('/presensi/izin')->with(['error' => 'Data Gagal di Update']);
        }
    }
    public function lokasi()
    {
        return view('calender.lokasi');
    }

    public function monitoring()
    {
        return view('presensi.monitoring');
    }

    public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi')
        ->select('presensi.*','nama_lengkap','nama_dept')
        ->join('karyawan','presensi.nik','=','karyawan.nik')
        ->join('department','karyawan.kode_dpt','=','department.kode_dept')
        ->where('tgl_presensi',$tanggal)
        ->get();
        return view('presensi.getpresensi', compact('presensi'));
    }

    public function downloadfile($file)
    {
        return Storage::download('public/upload/surat/'.$file);
    }

    public function tampilkanpeta(Request $request)
    {
        $id = $request->id;
        $presensi = DB::table('presensi')
        ->join('karyawan','presensi.nik','=','karyawan.nik')
        ->where('id',$id)
        ->first();
        return view('presensi.showmap',compact('presensi'));
    }

    public function laporan()
    {
        $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        $karyawan = DB::table('karyawan')->orderBy('nama_lengkap')->get();
        return view('presensi.laporan', compact('namabulan','karyawan'));
    }

    public function cetaklaporan(Request $request)
    {
        $nik = $request->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["","JANUARI","FEBRUARI","MARET","APRIL","MEI","JUNI","JULI","AGUSTUS","SEPTEMBER","OKTOBER","NOVEMBER","DESEMBER"];
        $karyawan = DB::table('karyawan')->where('nik',$nik)
        ->join('department','karyawan.kode_dpt','=','department.kode_dept')
        ->first();

        $presensi = DB::table('presensi')
        ->where('nik',$nik)
        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->orderBy('tgl_presensi','asc')
        ->get();
        return view('presensi.cetaklaporan', compact('namabulan','bulan','tahun','karyawan','presensi'));
    }

    public function rekap()
    {
        $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        $department = DB::table('department')->get();
        return view('presensi.rekap', compact('namabulan','department'));

    }

    public function cetakrekap(Request $request)
    {
        $bulan = (int)$request->bulan; // Convert to integer
        $bulan_str = str_pad($bulan, 2, '0', STR_PAD_LEFT); // Ensure month is two digits
        $tahun = $request->tahun;
        $kode_dept = $request->kode_dept;
        $dari = $tahun . "-" . $bulan_str . "-01"; // Correct date format
        $sampai = date("Y-m-t", strtotime($dari));
        $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];


        // Populate $rangetanggal with all days of the month
        while (strtotime($dari) <= strtotime($sampai)) {
            $rangetanggal[] = $dari; // Add each date to the array
            $dari = date("Y-m-d", strtotime("+1 days", strtotime($dari)));
        }

        $jmlhari = count($rangetanggal);
        $lastrange = $jmlhari - 1;
        $sampai = $rangetanggal[$lastrange];
        if ($jmlhari >= 30) {
            array_push($rangetanggal, NULL);
        } elseif ($jmlhari == 29) {
            array_push($rangetanggal, NULL, NULL);
        }
        elseif ($jmlhari == 28) {
            array_push($rangetanggal, NULL, NULL);
        }
        $query = Karyawan::query();
        $query->selectRaw("karyawan.nik, nama_lengkap,
        tgl_1,
        tgl_2,
        tgl_3,
        tgl_4,
        tgl_5,
        tgl_6,
        tgl_7,
        tgl_8,
        tgl_9,
        tgl_10,
        tgl_11,
        tgl_12,
        tgl_13,
        tgl_14,
        tgl_15,
        tgl_16,
        tgl_17,
        tgl_18,
        tgl_19,
        tgl_20,
        tgl_21,
        tgl_22,
        tgl_23,
        tgl_24,
        tgl_25,
        tgl_26,
        tgl_27,
        tgl_28,
        tgl_29,
        tgl_30,
        tgl_31"
    );
        $query->leftJoin(
            DB::raw("(
                SELECT presensi.nik,
                MAX(IF(tgl_presensi = '$rangetanggal[0]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_1,

                MAX(IF(tgl_presensi = '$rangetanggal[1]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_2,

                MAX(IF(tgl_presensi = '$rangetanggal[2]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_3,

                MAX(IF(tgl_presensi = '$rangetanggal[3]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_4,

                MAX(IF(tgl_presensi = '$rangetanggal[4]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_5,

                MAX(IF(tgl_presensi = '$rangetanggal[5]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_6,

                MAX(IF(tgl_presensi = '$rangetanggal[6]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_7,

                MAX(IF(tgl_presensi = '$rangetanggal[7]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_8,

                MAX(IF(tgl_presensi = '$rangetanggal[8]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_9,

                MAX(IF(tgl_presensi = '$rangetanggal[9]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_10,

                MAX(IF(tgl_presensi = '$rangetanggal[10]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_11,

                MAX(IF(tgl_presensi = '$rangetanggal[11]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_12,

                MAX(IF(tgl_presensi = '$rangetanggal[12]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_13,

                MAX(IF(tgl_presensi = '$rangetanggal[13]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_14,

                MAX(IF(tgl_presensi = '$rangetanggal[14]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_15,

                MAX(IF(tgl_presensi = '$rangetanggal[15]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_16,

                MAX(IF(tgl_presensi = '$rangetanggal[16]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_17,

                MAX(IF(tgl_presensi = '$rangetanggal[17]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_18,

                MAX(IF(tgl_presensi = '$rangetanggal[18]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_19,

                MAX(IF(tgl_presensi = '$rangetanggal[19]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_20,

                MAX(IF(tgl_presensi = '$rangetanggal[20]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_21,

                MAX(IF(tgl_presensi = '$rangetanggal[21]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_22,

                MAX(IF(tgl_presensi = '$rangetanggal[22]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_23,

                MAX(IF(tgl_presensi = '$rangetanggal[23]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_24,

                MAX(IF(tgl_presensi = '$rangetanggal[24]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_25,

                MAX(IF(tgl_presensi = '$rangetanggal[25]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_26,

                MAX(IF(tgl_presensi = '$rangetanggal[26]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_27,

                MAX(IF(tgl_presensi = '$rangetanggal[27]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_28,

                MAX(IF(tgl_presensi = '$rangetanggal[28]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_29,

                MAX(IF(tgl_presensi = '$rangetanggal[29]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_30,

                MAX(IF(tgl_presensi = '$rangetanggal[30]',
                CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                 IFNULL(presensi.status,'NA'),'|',
                   IFNULL(presensi.kode_izin,'NA'),'|'
                ),NULL)) as tgl_31

                FROM presensi
                LEFT JOIN pengajuan_izin ON presensi.kode_izin = pengajuan_izin.kode_izin
                WHERE tgl_presensi BETWEEN '$rangetanggal[0]' AND '$sampai'
                GROUP BY nik
            ) presensi"),
            function ($join) {
                $join->on('karyawan.nik', '=', 'presensi.nik');
            }
        );

        $query->join('department', 'karyawan.kode_dpt', '=', 'department.kode_dept');
        $query->where('karyawan.kode_dpt', $kode_dept);
        $query->orderBy('nama_lengkap');
        $rekap = $query->get();

        if (isset($_POST['exportexcel'])) {
            $time = date("M-Y H:I:S");
            //fungsi header
            header("Content-type:application/vnd-ms-excel");
            //mendefinisikan nama file
            header("content-Disposition: attachment; filename=Rekap Presensi Karyawan $time.xls");
        }

        return view('presensi.cetakrekap', compact('rangetanggal','namabulan','bulan','tahun','rangetanggal','jmlhari','rekap'));
    }

    public function izinsakit(Request $request)
    {
       $query = Pengajuanizin::query();
       $query->select('kode_izin','tanggal','tgl_izin_sampai','pengajuan_izin.nik','nama_lengkap','nama_dept','statues_approved','keterangan','status');
       $query->join('karyawan','pengajuan_izin.nik','=','karyawan.nik');
       $query->join('department','karyawan.kode_dpt','=','department.kode_dept');
       if (!empty($request->dari) && !empty($request->sampai)) {
           $query->whereBetween('tanggal', [$request->dari, $request->sampai]);
       }

       if (!empty($request->nik)) {
        $query->where('pengajuan_izin.nik', $request->nik);
       }

       if (!empty($request->nama_lengkap)) {
        $query->where('nama_lengkap','like','%'.$request->nama_lengkap.'%');
       }

       if ($request->statues_approved == '0'|| $request->statues_approved == '1' || $request->statues_approved == '2'){
        $query->where('statues_approved',$request->statues_approved);
       }

       $query->orderBy('tanggal','desc');
       $izinsakit = $query->paginate(10 );
       $izinsakit->appends($request->all());
        return view('presensi.izinsakit', compact('izinsakit'));
    }

    public function approveizinsakit(Request $request)
    {
        $statues_appoved = $request->statues_approved;
        $kode_izin = $request->kode_izin_form;
        $dataizin = DB::table('pengajuan_izin')->where('kode_izin',$kode_izin)->first();
        $nik = $dataizin->nik;
        $tgl_dari = $dataizin->tanggal;
        $tgl_sampai = $dataizin->tgl_izin_sampai;
        $status = $dataizin->status;
        $alasan = $request->alasan_tolak;
        DB::beginTransaction();
        try {
            if($statues_appoved == 1){
                while (strtotime($tgl_dari) <= strtotime($tgl_sampai)) {

                    DB::table('presensi')->insert([
                        'nik' => $nik,
                        'tgl_presensi' => $tgl_dari,
                        'status' => $status,
                        'kode_izin'=> $kode_izin,
                    ]);
                    $tgl_dari = date("Y-m-d", strtotime("+1 days", strtotime($tgl_dari)));
                }
            }
            DB::table('pengajuan_izin')->where('kode_izin',$kode_izin)
            ->update(['statues_approved' => $statues_appoved,
                      'alasan_tolak'=> $alasan]);
            DB::commit();
            return Redirect::back()->with(['success' => 'Data berhasil tersimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['error' => 'Data gagal tersimpan']);
        }

        //$update = DB::table('pengajuan_izin')
        //->where('kode_izin',$kode_izin)
        //->update([
        //    'statues_approved' => $statues_appoved,
        //    'alasan_tolak' => $alasan
        // ]);
        //if ($update) {
        //    return redirect::back()->with(['success'=>'Data berhasil di update']);
        //} else {
         //   return redirect::back()->with(['error'=>'Data gagal di update']);

    }

    public function batalkanizinsakit($kode_izin)
    {

        DB::beginTransaction();
        try {
            $update = DB::table('pengajuan_izin')->where('kode_izin',$kode_izin)->update(['statues_approved' => '0']);
            DB::table('presensi')->where('kode_izin', $kode_izin)->delete();
            DB::commit();
            return Redirect::back()->with(['success'=> 'Data Berhasil Dibatalkan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['error'=> 'Data Gagal Batalkan']);
        }

        //$update = DB::table('pengajuan_izin')
        //->where('id',$id)
        //->update([
            //'statues_approved' => '0'
        //]);
        //if ($update) {
            //return redirect::back()->with(['success'=>'Data berhasil di update']);
        //} else {
            //return redirect::back()->with(['warning'=>'Data gagal di update']);
        //}
    }

    public function pengecekanizin(Request $request)
    {
        $tanggal = $request->tanggal;
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('pengajuan_izin')->where('nik',$nik)->where('tanggal',$tanggal)->count();
        return $cek;
    }

    public function showact($kode_izin)
    {
        $dataizin = DB::table('pengajuan_izin')->where('kode_izin',$kode_izin)->first();
        return view('presensi.showact',compact('dataizin'));
    }

    public function deleteizin($kode_izin)
    {
        $ceksurat = DB::table('pengajuan_izin')->where('kode_izin',$kode_izin)->first();
        $docsid = $ceksurat->SID;
        try {
            DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->delete();
            if ($docsid != null)
                Storage::delete('/public/uploads/sid/' . $docsid);
            return redirect('/presensi/izin')->with(['success' => 'Data berhasil Terhapus']);
        } catch (\Exception $e) {
            return redirect('/presensi/izin')->with(['error' => 'Data gagal Terhapus']);
        }
    }
}
