<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\FileMahasiswa;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Models\AktorFakultas;

class AkademikBiroController extends Controller
{
    public function index()
    {
        if (!Session::get('islogin') || Session::get('tipe') != 'akademikbiro') {
            return redirect('/');
        }
        $mahasiswa = DB::table('filemahasiswa')
            ->join('mahasiswa', 'filemahasiswa.id_mahasiswa', '=', 'mahasiswa.idmahasiswa')
            ->join('akun', 'mahasiswa.id_akun', '=', 'akun.idAkun')
            ->where('filemahasiswa.status', 1)
            ->get(['mahasiswa.*', 'akun.*', 'filemahasiswa.*', 'filemahasiswa.status as status_file']);
        return view('aktorcekberkas/akademikbiroberanda')->with(['mahasiswa' => $mahasiswa]);
    }

    public function terima($idfile)
    {
        if (!Session::get('islogin') || Session::get('tipe') != 'akademikbiro') {
            return redirect('/');
        }
        $data = FileMahasiswa::find($idfile);
        $data->update([
            'status' => 3
        ]);
        $files = DB::table('filemahasiswa')
            ->join('mahasiswa', 'filemahasiswa.id_mahasiswa', '=', 'mahasiswa.idmahasiswa')
            ->where('filemahasiswa.id_mahasiswa', $data->id_mahasiswa)
            ->where('filemahasiswa.status', 3)
            ->get();
        if (count($files) == 7) {
            Mahasiswa::find($data->id_mahasiswa)->update([
                'status' => 1
            ]);
            //email mahasiswa
            $akademikbiro = AktorFakultas::find(Session::get('idaktor'));
            $url = url('/');
            $mhs = Mahasiswa::find($data->id_mahasiswa);
            $details = [
                'title' => 'Berkas Sidang Skripsi',
                'body' => "<p>Assalamu&apos;alaikum &nbsp;Wr Wb</p>
            <p>Diinformasikan bahwa semua berkas anda telah dan diperiksa dan diterima oleh Administrasi Fakultas dan Akademik Biro.</p>
            <p>Jadwal sidang akan diinformasikan melalui email</p>
            <a href='$url'>$url</a>",
                'sender' => $akademikbiro->Akun->nama,
                'jabatan' => "Akademik Biro"
            ];
            Mail::to($mhs->Akun->email)->send(new \App\Mail\UndanganSidang($details));
        }
        return back();
    }

    public function tolak($idfile)
    {
        if (!Session::get('islogin') || Session::get('tipe') != 'akademikbiro') {
            return redirect('/');
        }
        FileMahasiswa::find($idfile)->update([
            'status' => 2
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
            'jabatan' => "Akademik Biro"
        ];
        Mail::to($mhs->Akun->email)->send(new \App\Mail\UndanganSidang($details));
        return back();
    }
}
