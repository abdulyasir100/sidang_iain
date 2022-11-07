<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Jadwal;
use App\Models\Undangan;
use App\Models\LogSidang;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\AktorFakultas;
use App\Models\DosenPembimbing;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class DosenController extends Controller
{
    public function index()
    {
        if (!Session::get('islogin') || Session::get('tipe') != 'dosen') {
            return redirect('/');
        }
        $undangan = $this->listundangan();
        $jadwal = DB::table('jadwal as j')
            ->join('undangan as u', 'j.idjadwal', '=', 'id_jadwal')
            ->join('mahasiswa as m', 'j.id_mahasiswa','=','m.idmahasiswa')
            ->join('akun as a','m.id_akun','=','a.idAkun')
            ->where('u.id_dosen', '=', Session::get('idaktor'))
            ->where('u.status', '=', 2)
            //->where('j.status', '=', 0)
            ->orderby('j.tanggal')
            ->get();
        return view('dosen/berandadosen')->with(['jadwal' => $jadwal, 'undangan' => $undangan]);
    }

    public function showundangan()
    {
        if (!Session::get('islogin') || Session::get('tipe') != 'dosen') {
            return redirect('/');
        }
        $undangan = DB::table('undangan as u')
            ->leftjoin('aktorfakultas as a', 'u.id_adminprodi', '=', 'a.idAktor')
            ->join('akun as ak', 'a.idAkun', '=', 'ak.idAkun')
            ->join('jadwal as j','u.id_jadwal','=','j.idjadwal')
            ->where('u.id_dosen', Session::get('idaktor'))->where('u.status', 0)
            ->orderby('u.created_at')
            ->get();
        return view('dosen/listundangan')->with([
            'undangan' => $undangan
        ]);
    }

    public function listundangan()
    {
        if (!Session::get('islogin') || Session::get('tipe') != 'dosen') {
            return redirect('/');
        }
        $undangan = DB::table('undangan as u')
            ->leftjoin('aktorfakultas as a', 'u.id_adminprodi', '=', 'a.idAktor')
            ->join('akun as ak', 'a.idAkun', '=', 'ak.idAkun')
            ->where('u.id_dosen', Session::get('idaktor'))->where('u.status', 0)
            ->orderby('u.created_at')
            ->get();
        return $undangan;
    }

    public function detailjadwal($idjadwal)
    {
        if (!Session::get('islogin') || Session::get('tipe') != 'dosen') {
            return redirect('/');
        }
        $undangan = $this->listundangan();
        $jadwal = Jadwal::find($idjadwal);
        $idundangan = DB::table('jadwal as j')
            ->join('undangan as u', 'j.idjadwal', '=', 'id_jadwal')
            ->where('u.id_dosen', '=', Session::get('idaktor'))
            ->where('u.status', '=', 2)
            ->where('j.idjadwal', '=', $idjadwal)
            ->select('u.idundangan')
            ->first();
        $id = $idundangan->idundangan;
        $detail = Undangan::find($id);
        $mahasiswa = Mahasiswa::find($jadwal->id_mahasiswa);
        return view('dosen/dosenjadwal')->with([
            'jadwal' => $jadwal, 'mahasiswa' => $mahasiswa, 'undangan' => $undangan, 'detail' => $detail, 'idundangan' => $id
        ]);
    }

    public function undangansidang($idundangan)
    {
        if (!Session::get('islogin') || Session::get('tipe') != 'dosen') {
            return redirect('/');
        }
        $undangan = $this->listundangan();
        $detail = Undangan::find($idundangan);
        $jadwal = Jadwal::find($detail->id_jadwal);
        $mahasiswa = Mahasiswa::find($jadwal->id_mahasiswa);
        return view('dosen/dosenundangan')->with([
            'detail' => $detail,
            'undangan' => $undangan,
            'mahasiswa' => $mahasiswa,
        ]);
    }

    public function terima($idundangan)
    {
        if (!Session::get('islogin') || Session::get('tipe') != 'dosen') {
            return redirect('/');
        }
        $undangan = Undangan::find($idundangan);
        $listUndangan = DB::table('jadwal as j')
            ->join('undangan as u', 'j.idjadwal', '=', 'u.id_jadwal')
            ->where('j.id_mahasiswa', $undangan->Jadwal->id_mahasiswa)
            ->where('u.status', 2)
            ->get();
        if ($listUndangan->count() >= 3) {
            $undangan->update([
                'status' => 1
            ]);
            return redirect('/berandadosen');
        } else {
            $undangan->update([
                'status' => 2
            ]);
            $listUndangan = DB::table('jadwal as j')
                ->join('undangan as u', 'j.idjadwal', '=', 'u.id_jadwal')
                ->where('j.id_mahasiswa', $undangan->Jadwal->id_mahasiswa)
                ->where('u.status', 2)
                ->get();
            if ($listUndangan->count() == 3) {
                Mahasiswa::find($undangan->Jadwal->id_mahasiswa)->update([
                    'status' => 2
                ]);
                $this->setupDosenPembimbing($undangan->Jadwal->id_mahasiswa, $undangan->id_adminprodi, $undangan->id_jadwal);
                $this->kirimEmail(
                    $undangan->Jadwal->tempat,
                    $undangan->Jadwal->tanggal,
                    $undangan->Jadwal->id_mahasiswa,
                    $undangan->id_adminprodi
                );
            }
            return redirect('/berandadosen');
        }
    }

    public function setupDosenPembimbing($idmahasiswa, $idadminprodi, $idjadwal)
    {
        $dosbing = DosenPembimbing::where('id_mahasiswa', $idmahasiswa)->get();
        foreach ($dosbing as $d) {
            Undangan::create([
                'id_adminprodi' => $idadminprodi,
                'id_dosen' => $d->id_dosen,
                'id_jadwal' => $idjadwal,
                'status' => 2
            ]);
        }
    }

    public function tolak($idundangan)
    {
        if (!Session::get('islogin') || Session::get('tipe') != 'dosen') {
            return redirect('/');
        }
        Undangan::find($idundangan)->update([
            'status' => 1
        ]);
        $dosen = AktorFakultas::find(Session::get('idaktor'));
        $undangan = Undangan::find($idundangan);
        $adminprodi = AktorFakultas::find($undangan->id_adminprodi);
        $nama = $dosen->Akun->nama;
        $details = [
            'title' => 'Pelaksanaan Sidang Skripsi',
            'body' => "<p>Assalamu&apos;alaikum &nbsp;Wr Wb</p>
                <p>Diinformasikan untuk undangan Sidang Skripsi telah ditolak oleh: $nama </p>
                <p>Diharapkan untuk mengirimkan ulang undangan Sidang Skripsi kepada dosen yang tersedia</p>",
            'sender' => $nama,
            'jabatan' => "Dosen"
        ];
        Mail::to($adminprodi->Akun->email)->send(new \App\Mail\UndanganSidang($details));
        return redirect('/berandadosen');
    }

    public function berinilai(Request $request)
    {
        if (!Session::get('islogin') || Session::get('tipe') != 'dosen') {
            return redirect('/');
        }
        $nilai = $request->nilai;
        $idundangan = $request->idundangan;
        $idmahasiswa = $request->idmahasiswa;
        Undangan::find($idundangan)->update([
            'nilai' => $nilai
        ]);
        $temp = Undangan::find($idundangan);
        $allUndangan = Undangan::where('id_jadwal', $temp->id_jadwal)
            ->where('status', 2)
            ->get();
        $nulls = 0;
        foreach ($allUndangan as $u) {
            if ($u->nilai == null) {
                $nulls++;
            }
        }
        if ($nulls == 0) {
            LogSidang::create([
                'id_jadwal' => $temp->id_jadwal
            ]);
            Mahasiswa::find($idmahasiswa)->update([
                'status' => 3
            ]);
            Jadwal::find($temp->id_jadwal)->update([
                'status' => 1
            ]);
        }
        return redirect('/berandadosen');
    }

    public function kirimEmail($tempat, $tanggal, $idmahasiswa, $idadminprodi)
    {
        if (!Session::get('islogin') || Session::get('tipe') != 'dosen') {
            return redirect('/');
        }
        $mahasiswa = DB::table('mahasiswa as m')
            ->join('akun as a', 'm.id_akun', '=', 'a.idAkun')
            ->where('m.idmahasiswa', $idmahasiswa)
            ->first();
        $dosen = DB::table('aktorfakultas as d')
            ->join('akun as a', 'd.idAkun', '=', 'a.idAkun')
            ->leftjoin('undangan as u', 'd.idAktor', '=', 'u.id_dosen')
            ->where('u.status', 2)
            ->get();
        if ($dosen->count() >= 3) {
            $tanggaljadi = new DateTime($tanggal);
            $tanggalcopy = $tanggaljadi;
            $hari = Carbon::parse($tanggaljadi)->translatedFormat('l');
            $jam = $tanggaljadi->format('H');
            $menit = $tanggaljadi->format('i');
            $tanggalcopy->modify('+1 hour');
            $sampaijam = $tanggalcopy->format('H');
            $sampaimenit = $tanggalcopy->format('i');
            $tanggalcopy = date_format($tanggaljadi, 'd-m-Y');
            $nama1 = $dosen[0]->nama;
            $nip1 = $dosen[0]->nip;
            $no1 = $dosen[0]->nomor_telp;
            $nama2 = $dosen[1]->nama;
            $nip2 = $dosen[1]->nip;
            $no2 = $dosen[1]->nomor_telp;
            $nama3 = $dosen[2]->nama;
            $nip3 = $dosen[2]->nip;
            $no3 = $dosen[2]->nomor_telp;

            $adminfakultas = AktorFakultas::find($idadminprodi);

            $details = [
                'title' => 'Pelaksanaan Sidang Skripsi',
                'body' => "<p>Assalamu&apos;alaikum &nbsp;Wr Wb</p>
                <p>Diinformasikan untuk pelaksanaan Sidang Skripsi adalah sebagai berikut :</p>
                <p>Hari &amp; Tanggal : $hari, $tanggalcopy</p>
                <p>Jam : $jam:$menit - $sampaijam:$sampaimenit</p>
                <p>Tempat : $tempat</p>
                <p>Dosen Penguji :&nbsp;</p>
                <ol>
                    <li>$nama1 / $nip1 / $no1</li>
                    <li>$nama2 / $nip2 / $no2</li>
                    <li>$nama3 / $nip3 / $no3</li>
                </ol>",
                'sender' => $adminfakultas->Akun->nama,
                'jabatan' => "Administrasi Fakultas"
            ];
            Mail::to($mahasiswa->email)->send(new \App\Mail\UndanganSidang($details));
        }
    }
}
