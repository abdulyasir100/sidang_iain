<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Jadwal;
use App\Models\Undangan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\AktorFakultas;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

use Illuminate\Http\RedirectResponse;
use SMSGatewayMe\Client\Configuration;
use Illuminate\Support\Facades\Session;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\Model\SendMessageRequest;

class AdminProdiController extends Controller
{
    public function index(){
        if(!Session::get('islogin')||Session::get('tipe')!='adminprodi'){
            return redirect('/');
        }
        $mahasiswa = DB::table('mahasiswa')
                    ->join('akun','mahasiswa.id_akun','=','akun.idAkun')
                    ->where('mahasiswa.status',1)
                    ->get();
        return view('adminprodi/berandaadminprodi')->with(['mahasiswa'=>$mahasiswa]);
    }

    public function carijadwal($idmahasiswa){
        if(!Session::get('islogin')||Session::get('tipe')!='adminprodi'){
            return redirect('/');
        }
        $mahasiswa = Mahasiswa::where('idmahasiswa',$idmahasiswa)
                    ->join('akun','mahasiswa.id_akun','=','akun.idAkun')->first();
        $jadwal = Jadwal::where('id_mahasiswa',$idmahasiswa)->first();
        if(!is_null($jadwal)){
            return view('adminprodi/carijadwal')->with(['mahasiswa'=>$mahasiswa,'jadwal'=>$jadwal]);
        }else{
            return view('adminprodi/carijadwal')->with(['mahasiswa'=>$mahasiswa]);
        }
    }

    public function caridosen(Request $request){
        if(!Session::get('islogin')||Session::get('tipe')!='adminprodi'){
            return redirect('/');
        }
        $jadwal = $request->jadwal;
        //cek sudah penuh atau belum
        //x = total penuh sidang pada hari itu
        $x = 6;
        $tanggaljadi = new DateTime($jadwal);
        $totaljadwal = Jadwal::whereDate('tanggal','=',$tanggaljadi);
        if($totaljadwal->count()>=$x){
           return back();
        }
        $tempat = $request->tempat;
        $id=$request->idmahasiswa;
        $dosen = DB::table('aktorfakultas as a')
                ->leftjoin('dosenpembimbing as d','a.idAktor','=','d.id_dosen')
                ->join('akun as ak','a.idAkun','=','ak.idAkun')
                ->leftjoin('undangan as u','a.idAktor','=','u.id_dosen')
                ->leftjoin('jadwal as j','u.id_jadwal','=','j.idjadwal')
                ->where('d.id_mahasiswa','!=',$id)->orWhereNull('d.id_mahasiswa')
                //->where('j.id_mahasiswa','=',$id)
                ->where('tipe','=',0)
                ->get();
        $data = array(
            "idmahasiswa"=>$id,
            "jadwal"=>$jadwal,
            "tempat"=>$tempat
        );
        return view('adminprodi/caridosen')->with(['dosen'=>$dosen,'data'=>$data]);
    }

    public function undang(Request $request){
        if(!Session::get('islogin')||Session::get('tipe')!='adminprodi'){
            return redirect('/');
        }
        $jadwal = Jadwal::where('id_mahasiswa',$request->idmahasiswa)->first();
        $id="";
        if(is_null($jadwal)){
            $id = Jadwal::create([
                'id_adminprodi'=>Session::get('idaktor'),
                'id_mahasiswa'=>$request->idmahasiswa,
                'tempat'=>$request->tempat,
                'tanggal'=>$request->tanggal,
                'status'=>0
            ]);
        }
        $undangan = null;
        if($id==""){
            $undangan = Undangan::create([
                'id_adminprodi'=>Session::get('idaktor'),
                'id_dosen'=>$request->iddosen,
                'id_jadwal'=>$jadwal->idjadwal,
                'status'=>0
            ]);
        }else{
            $undangan = Undangan::create([
                'id_adminprodi'=>Session::get('idaktor'),
                'id_dosen'=>$request->iddosen,
                'id_jadwal'=>$id->idjadwal,
                'status'=>0
            ]);
        }
        //undang melalui email
        $this->kirimEmail($request->tempat,$request->tanggal,$request->iddosen,$undangan->idundangan);
        //$this->kirimSMS();
        return back()->withInput([
            'jadwal' => $request->tanggal,
            'tempat' => $request->tempat,
            'idmahasiswa' => $request->idmahasiswa
        ]);
    }

    public function kirimEmail($tempat,$tanggal,$iddosen,$idundangan){
        if(!Session::get('islogin')||Session::get('tipe')!='adminprodi'){
            return redirect('/');
        }
        $dosen = AktorFakultas::find($iddosen);
        $tanggaljadi = new DateTime($tanggal);
        $tanggalcopy = $tanggaljadi;
        $hari = $hari = Carbon::parse($tanggaljadi)->translatedFormat('l');
        $jam = $tanggaljadi->format('H');
        $menit = $tanggaljadi->format('i');
        $tanggalcopy->modify('+1 hour');
        $sampaijam = $tanggalcopy->format('H');
        $sampaimenit = $tanggalcopy->format('i');
        $tanggalcopy = date_format($tanggaljadi,'d-m-Y');
        $url = url('/')."/undangansidang/$idundangan";
        $adminfakultas = AktorFakultas::find(Session::get('idaktor'));
        $details = [
            'title' => 'Undangan Sidang Skripsi',
            'body' => "<p>Assalamu&apos;alaikum &nbsp;Wr Wb</p>
            <p>Diinformasikan undangan sebagai penguji Sidang Skripsi adalah sebagai berikut :</p>
            <p>Hari &amp; Tanggal : $hari, $tanggalcopy</p>
            <p>Jam : $jam:$menit - $sampaijam:$sampaimenit</p>
            <p>Tempat : $tempat</p>
            <a href='$url'>$url</a>",
            'sender' => $adminfakultas->Akun->nama,
            'jabatan' => "Administrasi Prodi"
        ];
        Mail::to($dosen->Akun->email)->send(new \App\Mail\UndanganSidang($details));
    }

    public function mailtest(){
        $email = "abdulyasir100@gmail.com";
        $details = [
            'title' => 'Test Email',
            'body' => "<p>Test kirim email</p>",
            'sender' => 'Test',
            'jabatan' => 'Tester'
        ];
        Mail::to($email)->send(new \App\Mail\UndanganSidang($details));
    }

}
