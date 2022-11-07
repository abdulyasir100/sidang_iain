<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Mahasiswa;
use Nette\Utils\DateTime;
use App\Models\DownloadFile;
use App\Models\DosenPembimbing;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Novay\WordTemplate\WordTemplate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use App\Models\LogSidang;

class DownloadFileController extends Controller
{
    public function Download($idfile){
        if(!Session::get('islogin')||!Session::get('idmahasiswa')){
            return redirect('/');
        }
        $data = DownloadFile::find($idfile);
        $file = public_path("template\\".$data->lokasi.".rtf");
        $mahasiswa = Mahasiswa::find(Session::get('idmahasiswa'));
        $datadosbing = DosenPembimbing::where('id_mahasiswa',$mahasiswa->idmahasiswa)->get();
        $dosbing = DB::table('akun')
                    ->join('aktorfakultas','akun.idAkun','=','aktorfakultas.idAkun')
                    ->join('dosenpembimbing','aktorfakultas.idAktor','=','dosenpembimbing.id_dosen')
                    ->where('dosenpembimbing.id_mahasiswa','=',$mahasiswa->idmahasiswa)
                    ->get();
        $array = array(
			'[NAMA]' => $mahasiswa->Akun->nama,
			'[NIM]' => $mahasiswa->nim,
			'[SEMESTER]' => $mahasiswa->semester,
			'[PROGRAMSTUDI]' => $mahasiswa->prodi,
			'[FAKULTAS]' => $mahasiswa->fakultas,
            '[JURUSAN]' => $mahasiswa->jurusan,
            '[ALAMAT]' => $mahasiswa->alamat,
            '[JUDUL]' => $mahasiswa->judul_skripsi,
			'[TANGGAL]' => Carbon::parse(new DateTime())->translatedFormat('d F Y'),
            '[DOSBINGNAMAI]' => $dosbing[0]->nama,
            '[DOSBINGNIPI]' => $datadosbing[0]->Dosen->nip,
            '[DOSBINGNAMAII]' => $dosbing[1]->nama,
            '[DOSBINGNIPII]' => $datadosbing[1]->Dosen->nip,
			'[NAME]' => $mahasiswa->Akun->nama,
			'[NIME]' => $mahasiswa->nim
		);
        $nama_file = $data->lokasi.'.doc';

        return WordTemplate::export($file,$array,$nama_file);
    }

    public function BeritaAcara(){
        if(!Session::get('islogin')||!Session::get('idmahasiswa')){
            return redirect('/');
        }
        $jadwal = Jadwal::where('id_mahasiswa',Session::get('idmahasiswa'))->first();
        //ubah status jadwal ke 2
        Jadwal::where('id_mahasiswa',Session::get('idmahasiswa'))->limit(1)->update([
            'status'=>2
        ]);
        $file = public_path("template\berita_acara_sidang.rtf");
        $mahasiswa = Mahasiswa::find(Session::get('idmahasiswa'));
        $penguji = DB::table('undangan as u')
                    ->join('jadwal as j','u.id_jadwal','=','j.idjadwal')
                    ->join('aktorfakultas as af','u.id_dosen','=','af.idAktor')
                    ->join('akun as a','af.idAkun','=','a.idAkun')
                    ->where('u.id_jadwal',$jadwal->idjadwal)
                    ->where('u.status',2)
                    ->get();
        $tgl = LogSidang::where('id_jadwal',$jadwal->idjadwal)->first();
        $tanggaljadi = new DateTime($tgl->created_at);
        $tanggal = Carbon::parse($tanggaljadi)->translatedFormat('d F Y');
        $hari = Carbon::parse($tanggaljadi)->translatedFormat('l');
        $upper = strtoupper($mahasiswa->jurusan);
        //0-1-2 penguji
        //3-4 dosbing
        $array = array(
            '[UPPER]' => $upper,
            '[JURUSAN]' => $mahasiswa->jurusan,
            '[HARI]' => $hari,
            '[TANGGAL]' => $tanggal,
			'[NAMA]' => $mahasiswa->Akun->nama,
			'[NIM]' => $mahasiswa->nim,
            '[JUDUL]' => $mahasiswa->judul_skripsi,
            '[PEMBIMB2NG]' => $penguji[3]->nama,
            '[NILAI]' => $penguji[3]->nilai,
            '[P]' => $penguji[4]->nama,
            '[NILA2]' => $penguji[4]->nilai,
            '[PENGUJ1]' => $penguji[0]->nama,
            '[NILA3]' => $penguji[0]->nilai,
            '[PENGUJ2]' => $penguji[1]->nama,
            '[NILA4]' => $penguji[1]->nilai,
            '[PENGUJ3]' => $penguji[2]->nama,
            '[NILA5]' => $penguji[2]->nilai,
		);
        $nama_file = "berita_acara_sidang.doc";
        return WordTemplate::export($file,$array,$nama_file);
    }

}
