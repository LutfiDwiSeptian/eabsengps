<?php

namespace App\Http\Controllers;

use App\Models\karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {

        $nama = karyawan::query();
        $nama->select('karyawan.*','department.nama_dept');
        $nama->join('department', 'karyawan.kode_dpt', '=', 'department.kode_dept');
        $nama->orderBy('nama_lengkap');
        if($request->nama_karyawan){
            $nama->where('nama_lengkap', 'like', '%'.$request->nama_karyawan.'%');
        }
        if($request->kode_dept){
            $nama->where('kode_dpt', $request->kode_dept);
        }
        $karyawan = $nama->paginate(10); 
        
        if ($request->has('alamat')) {
            $alamat = DB::table('karyawan')->where('alamat', $request->alamat)->first();
        } else {
            $alamat = null;
        }

        $department = DB::table('department')->get();
        return view('karyawan.index', compact('karyawan', 'department', 'alamat'));
    }   

    public function store(Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $alamat = $request->alamat;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');
        $old_foto = $request->foto;

        // Check if NIK already exists
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        if ($karyawan) {
            return Redirect::back()->with(['error' => 'NIK sudah ada']);
        }

        if($request->hasFile('foto')){
            $foto = $request->file('foto')->store('foto');
        } else {
            $foto = $old_foto;
        }

        $data = [
            'nik' => $nik,
            'nama_lengkap' => $nama_lengkap,
            'jabatan' => $jabatan,
            'no_hp' => $no_hp,
            'alamat' => $alamat,
            'kode_dpt' => $kode_dept,
            'password' => $password,
            'foto' => $foto
        ];

        try {
            DB::table('karyawan')->insert($data);
            if ($request->hasFile('foto')){
                $folderPath = "public/upload/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return redirect()->route('karyawan.index')->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Tersimpan']);
        }
    }

    public function edit(Request $request)
    {
        $nik = $request->nik;
        $department = DB::table('department')->get();
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('karyawan.edit', compact('department', 'karyawan'));
    }
    
    public function update(Request $request, $nik)
    {
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $alamat = $request->alamat;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');

        $data = [
            'nama_lengkap' => $nama_lengkap,
            'jabatan' => $jabatan,
            'no_hp' => $no_hp,
            'alamat' => $alamat,
            'kode_dpt' => $kode_dept,
            'password' => $password,
        ];

        try {
            DB::table('karyawan')->where('nik', $nik)->update($data);
            return redirect()->route('karyawan.index')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal diupdate']);
        }
    }

    public function delete($nik)
    {
        $delete = DB::table('karyawan')->where('nik', $nik)->delete();
        if($delete){
            return Redirect::back()->with('success','Data berhasil dihapus');
        } else {
            return Redirect::back()->with('error','Data gagal dihapus');
        }
    }
}
