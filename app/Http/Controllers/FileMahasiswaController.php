<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileMahasiswa;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreFileMahasiswaRequest;
use App\Http\Requests\UpdateFileMahasiswaRequest;
use Exception;

class FileMahasiswaController extends Controller
{
    public function Upload(Request $request){
        if(!Session::get('islogin')||!Session::get('idmahasiswa')){
            return redirect('/');
        }
        try{
            $request->validate([
                't_nilai'=>'mimes:pdf|max:8192',
                'b_ukt'=>'mimes:pdf|max:8192',
                'pddikti'=>'mimes:pdf|max:8192',
                'b_ujian'=>'mimes:pdf|max:8192',
                's_dokumen'=>'mimes:pdf|max:8192',
                's_skripsi'=>'mimes:pdf|max:8192',
                's_pembimbing'=>'mimes:pdf|max:8192'
            ]);
            $datas = array('t_nilai','b_ukt','pddikti','b_ujian','s_dokumen','s_skripsi','s_pembimbing');
            $files = array($request->t_nilai, $request->b_ukt, $request->pddikti, $request->b_ujian, $request->s_dokumen,
            $request->s_skripsi, $request->s_pembimbing);
            $checker = FileMahasiswa::where('id_mahasiswa',Session::get('idmahasiswa'))->get();
            //dd($checker);
            //dd(count($files));
            $fileName = null;
            $i = 0;
            if($checker->count()==0){
                foreach ($files as $f) {
                    if($f){
                        $fileName = time().$f->getClientOriginalName();
                        $request->file($datas[$i])->storeAs('file', $fileName);
                        $fileName = explode('.',$fileName);
                        FileMahasiswa::create([
                            'id_mahasiswa' => Session::get('idmahasiswa'),
                            'lokasi' => $fileName[0],
                            'tipe' => $i,
                            'status' => 0
                        ]);
                    }
                    $i++;
                }
            }else{
                for ($i=0; $i < count($files); $i++) {
                    if($files[$i]){
                        $fileName = time().$files[$i]->getClientOriginalName();
                        $request->file($datas[$i])->storeAs('file', $fileName);
                        $fileName = explode('.',$fileName);
                        FileMahasiswa::where('idfile',$checker[$i]->idfile)->update([
                            'lokasi'=>$fileName[0],
                            'status'=>0
                        ]);
                    }
                }
            }
        }catch(Exception $e){
            return back()->withErrors(['msg' => 'File Harus Dalam Bentuk PDF']);
        }
        return redirect('/berandamahasiswa');
    }
}
