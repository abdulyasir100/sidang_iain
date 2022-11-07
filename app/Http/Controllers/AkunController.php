<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\AktorFakultas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AkunController extends Controller
{
    public function index(){
        if(Session::get('islogin')){
            $aktor = Mahasiswa::where('id_akun',Session::get('idakun'))->first();
                if(!is_null($aktor)&&$aktor->count() > 0){
                    Session::put('idmahasiswa',$aktor->idmahasiswa);
                    return redirect('berandamahasiswa');
                }else{
                    $aktor = AktorFakultas::where('idAkun',Session::get('idakun'))->first();
                    Session::put('idaktor',$aktor->idAktor);
                    switch($aktor->tipe){
                        case 0:
                            Session::put('tipe','dosen');
                            return redirect('berandadosen');
                            break;
                        case 1:
                            Session::put('tipe','adminfakultas');
                            return redirect('berandaadminfakultas');
                            break;
                        case 2:
                            Session::put('tipe','akademikbiro');
                            return redirect('berandaakademikbiro');
                            break;
                        case 3:
                            Session::put('tipe','adminprodi');
                            return redirect('berandaadminprodi');
                            break;
                        default:
                            return back()->withErrors(['msg'=>'Gagal Melakukan Login!']);
                    }
                    return redirect('beranda'.Session::get('tipe'));

                }
        }
        return view('login');
    }

    public function login(Request $request)
    {
        Session::flush();
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);
        $email = $request->email;
        $password = $request->password;
        $data = Akun::where('email',$email)->first();
        if(!is_null($data)&&$data->count() > 0){
            if($password==$data->password){
                Session::put('nama',$data->nama);
                Session::put('islogin',TRUE);
                Session::put('idakun',$data->idAkun);
                $aktor = Mahasiswa::where('id_akun',Session::get('idakun'))->first();
                if(!is_null($aktor)&&$aktor->count() > 0){
                    Session::put('idmahasiswa',$aktor->idmahasiswa);
                    return redirect('berandamahasiswa');
                }else{
                    $aktor = AktorFakultas::where('idAkun',Session::get('idakun'))->first();
                    Session::put('idaktor',$aktor->idAktor);
                    switch($aktor->tipe){
                        case 0:
                            Session::put('tipe','dosen');
                            return redirect('berandadosen');
                            break;
                        case 1:
                            Session::put('tipe','adminfakultas');
                            return redirect('berandaadminfakultas');
                            break;
                        case 2:
                            Session::put('tipe','akademikbiro');
                            return redirect('berandaakademikbiro');
                            break;
                        case 3:
                            Session::put('tipe','adminprodi');
                            return redirect('berandaadminprodi');
                            break;
                        default:
                            return back()->withErrors(['msg'=>'Gagal Melakukan Login!']);
                    }
                    return redirect('beranda'.Session::get('tipe'));

                }
            }
        }

        return back()->withErrors(['msg'=>'Gagal Melakukan Login!']);
        //$data = Akun::getAkun();
    }

    public function logout(){
        Session::flush();
        return redirect("/");
    }

}
