<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class registerController extends Controller
{
    public function index()
    {
        return view('register');
    }
    public function store(Request $r)
    {
        $r->validate([
            "nama_lengkap" => ['required'],
            "nomor_telp" => ['required'],
            "email" => ['required'],
            "username" => ['required'],
            "password" => ['required'],
            "alamat" => ['required']
        ]);

        $kode = Str::random(20);

        $cekData = DB::table('tb_user')
            ->where('tb_user.username', $r->username)
            ->where('tb_user.password', $r->password)
            ->first();

        if (empty($cekData)) {

            $tb_user = DB::table('tb_user')
                ->insert([
                    "id" => $kode,
                    "username" => $r->username,
                    "password" => $r->password,
                ]);

            $tb_userdetail = DB::table('tb_userdetail')
                ->insert([
                    "id" => $kode,
                    "nama_lengkap" => $r->nama_lengkap,
                    "nomor_telphone" => $r->nomor_telp,
                    "alamat" => $r->alamat,
                    "email" => $r->email,
                    "hak_akses" => "Employee"
                ]);

            if (($tb_user) && ($tb_userdetail)) {
                session()->flash('success-new_akun', 'Selamat, Akun berhasil dibuat!');
                return redirect('/');
            } else {
                session()->flash('invalid-new_akun', 'Gagal membuat Akun!');
                return back();
            }
        } else {
            session()->flash('duplicate-new_akun', 'Data Duplikat!');
            return back();
        }
    }
}
