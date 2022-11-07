<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Mahasiswa;
use App\Models\DownloadFile;
use App\Models\FileMahasiswa;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;

class MahasiswaController extends Controller
{
    public function index()
    {
        if(!Session::get('islogin')||!Session::get('idmahasiswa')){
            return redirect('/');
        }
        //cek status
        $mahasiswa = Mahasiswa::find(Session::get('idmahasiswa'));
        $download = DownloadFile::all();
        $file_mhs = FileMahasiswa::where('id_mahasiswa',Session::get('idmahasiswa'))->get();
        switch($mahasiswa->status){
            case 0: //Belum Upload Dokumen
                Session::put('status','Belum Upload Dokumen');
                return view('mahasiswa/berandamahasiswa')->with(['download'=>$download,'file_mhs'=>$file_mhs]);
                break;
            case 1: //Menunggu Jadwal
                Session::put('status','Menunggu Jadwal');
                return view('mahasiswa/berandamahasiswa')->with(['download'=>$download,'file_mhs'=>$file_mhs]);;
                break;
            case 2: //Siap Sidang
                Session::put('status','Siap Sidang');
                $jadwal = Jadwal::where('id_mahasiswa',Session::get('idmahasiswa'))->first();
                $dosen = DB::table('aktorfakultas as a')
                        ->leftjoin('undangan as u','a.idAktor','=','u.id_dosen')
                        ->join('akun as ak','a.idAkun','=','ak.idAkun')
                        ->where('u.id_jadwal',$jadwal->idjadwal)
                        ->where('u.status',2)
                        ->get();
                return view('mahasiswa/mahasiswajadwal')->with(['jadwal'=>$jadwal,'mahasiswa'=>$mahasiswa,'dosen'=>$dosen]);
                break;
            case 3: //Selesai Sidang
                //cek nilai
                $rata = 75;
                $data = DB::table('undangan as u')
                        ->leftjoin('jadwal as j','u.id_jadwal','=','j.idjadwal')
                        ->leftjoin('mahasiswa as m', 'j.id_mahasiswa','=','m.idmahasiswa')
                        ->where('m.idmahasiswa',Session::get('idmahasiswa'))
                        ->get();
                $nilai=0;
                foreach($data as $d){
                    $nilai+=$d->nilai;
                }
                $nilai/=5;
                if($nilai<$rata){
                    Session::put('status','Gagal Sidang');
                }
                else{
                    Session::put('status','Selesai Sidang');
                }
                return view('mahasiswa/mahasiswaberitaacara');
                break;
        }
    }

}
