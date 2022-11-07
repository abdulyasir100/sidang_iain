<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AdminProdiController;
use App\Http\Controllers\AkademikBiroController;
use App\Http\Controllers\DownloadFileController;
use App\Http\Controllers\AdminFakultasController;
use App\Http\Controllers\FileMahasiswaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Document
Route::get('/show/{filename}',[DocumentController::class,'Show']);
//FileMahasiswa
Route::post('/upload',[FileMahasiswaController::class,'Upload']);
//Mahasiswa
Route::get('/berandamahasiswa',[MahasiswaController::class,'index']);
//Dosen
Route::get('/berandadosen',[DosenController::class,'index']);
Route::get('/undangandosen',[DosenController::class,'showundangan']);
Route::get('/undangansidang/{idundangan}',[DosenController::class,'undangansidang']);
Route::get('/detailjadwal/{idjadwal}',[DosenController::class,'detailjadwal']);
Route::get('/terimaundangan/{idundangan}',[DosenController::class,'terima']);
Route::get('/tolakundangan/{idundangan}',[DosenController::class,'tolak']);
Route::post('/berinilai',[DosenController::class,'berinilai']);
//Admin Fakultas
Route::get('/berandaadminfakultas',[AdminFakultasController::class,'index']);
Route::get('/terimaadminfakultas/{idfile}',[AdminFakultasController::class,'terima']);
Route::get('/tolakadminfakultas/{idfile}',[AdminFakultasController::class,'tolak']);
//Akademik Biro
Route::get('/berandaakademikbiro',[AkademikBiroController::class,'index']);
Route::get('/terimaakademikbiro/{idfile}',[AkademikBiroController::class,'terima']);
Route::get('/tolakakademikbiro/{idfile}',[AkademikBiroController::class,'tolak']);
//Admin Prodi
Route::get('/berandaadminprodi',[AdminProdiController::class,'index']);
Route::get('/carijadwal/{idmahasiswa}',[AdminProdiController::class,'carijadwal']);
Route::get('/caridosen',[AdminProdiController::class,'caridosen']);
Route::post('/undang',[AdminProdiController::class,'undang']);
//Akun
Route::post('/login',[AkunController::class,'login']);
Route::get('/',[AkunController::class,'index']);
Route::get('/logout',[AkunController::class,'logout']);
//Download File
Route::get("/download/{idfile}",[DownloadFileController::class,'download']);
Route::get("/beritaacara",[DownloadFileController::class,'beritaacara']);
//Ajax
//TestData
Route::get("/testmail",[AdminProdiController::class,'mailtest']);