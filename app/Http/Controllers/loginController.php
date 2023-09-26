<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class loginController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function store(Request $r)
    {
        $r->validate([
            "username" => ['required'],
            "password" => ['required']
        ]);

        $data = DB::table('tb_user')
            ->join('tb_userdetail', 'tb_userdetail.id', '=', 'tb_user.id')
            ->where('tb_user.username', $r->username)
            ->where('tb_user.password', $r->password)
            ->first();

        if (!empty($data)) {
            session()->flash('success-login', 'Selamat, Anda berhasil login!');
            session()->put("id", $data->id);

            return redirect('/dashboard');
        } else {
            session()->flash('invalid', 'Data tidak tersedia, Coba ulangi lagi!');
            return back();
        }
    }
}
