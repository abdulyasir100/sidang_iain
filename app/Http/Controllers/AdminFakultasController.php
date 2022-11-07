<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileMahasiswa;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\AktorFakultas;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Mail;

class AdminFakultasController extends Controller
{
    public function index(){
        if(!Session::get('islogin')||Session::get('tipe')!='adminfakultas'){
            return redirect('/');
        }
        $mahasiswa = DB::table('filemahasiswa')
                    ->join('mahasiswa','filemahasiswa.id_mahasiswa','=','mahasiswa.idmahasiswa')
                    ->join('akun','mahasiswa.id_akun','=','akun.idAkun')
                    ->where('filemahasiswa.status',0)
                    ->get(['mahasiswa.*','akun.*','filemahasiswa.*','filemahasiswa.status as status_file']);
        return view('aktorcekberkas/adminfakultasberanda')->with(['mahasiswa'=>$mahasiswa]);
    }

    public function terima($idfile){
        if(!Session::get('islogin')||Session::get('tipe')!='adminfakultas'){
            return redirect('/');
        }
        FileMahasiswa::find($idfile)->update([
            'status'=>1
        ]);
        return back();
    }

    public function tolak($idfile){
        if(!Session::get('islogin')||Session::get('tipe')!='adminfakultas'){
            return redirect('/');
        }
        FileMahasiswa::find($idfile)->update([
            'status'=>2
        ]);
        //email mahasiswa
        $akademikbiro = AktorFakultas::find(Session::get('idaktor'));
        $url = url('/');
        $file = FileMahasiswa::find($idfile);
        $mhs = $file->Mahasiswa;
        $details = [
            'title' => 'Berkas Sidang Skripsi',
            'body' => "<p>Assalamu&apos;alaikum &nbsp;Wr Wb</p>
            <p>Diinformasikan bahwa semua berkas anda telah selesai diperiksa dan ditolak oleh Administrasi Fakultas dan Akademik Biro.</p>
            <p>Segera kirimkan ulang berkas berkas yang ditolak untuk dilakukan pengecekan ulang.</p>
            <a href='$url'>$url</a>",
            'sender' => $akademikbiro->Akun->nama,
            'jabatan' => "Administrasi Fakultas"
        ];
        Mail::to($mhs->Akun->email)->send(new \App\Mail\UndanganSidang($details));
        return back();
    }
}
