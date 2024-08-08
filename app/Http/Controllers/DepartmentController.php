<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\karyawan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $nama_dept = $request->nama_dept ?? '';
        $query = Department::query();
        $query->select('*');
        if($nama_dept != ''){
            $query->where('nama_dept', 'like', '%'.$nama_dept.'%');
        }
        $department = $query->get();

        //$department = DB::table('department')->orderBy('kode_dept')->get();
        return view('department.index', compact('department'));
    }

    public function store(Request $request){
        $kode_dept = $request->kode_dept;
        $nama_dept = $request->nama_dept ?? '';
        $data = [
            'kode_dept' => $kode_dept,
            'nama_dept' => $nama_dept  
        ];
        $simpan = DB::table('department')->insert($data);
        if($simpan ){
            return Redirect::back()->with('success',"data berhasil disimpan");
        }else{
            return Redirect::back()->with('error',"data gagal disimpan");
        }
    }


    public function delete($kode_dept)
    {
        $delete = DB::table('department')->where('kode_dept', $kode_dept)->delete();
        if ($delete) {
            return Redirect::back()->with('success', 'Data berhasil dihapus');
        } else {
            return Redirect::back()->with('error', 'Data gagal dihapus');
        }
    }

    public function edit(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $department = DB::table('department')->where('kode_dept',$kode_dept)->first();
        return view('department.edit', compact('department'));
    }

    public function update($kode_dept,Request $request)
    {
        $nama_dept = $request->nama_dept;
        $data = [
            'nama_dept' => $nama_dept
        ];

        $update = DB::table('department')->where('kode_dept',$kode_dept)->update($data);
        if($update){
            return Redirect::back()->with('success','Data berhasil di update');
        }else{
            return Redirect::back()->with('error','Data gagal di update');
        }
    }
}
