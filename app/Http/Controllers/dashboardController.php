<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    public function index()
    {
        if (session()->get('id')) {
            $id = session()->get('id');

            $user = DB::table('tb_userdetail')
                ->where('id', $id)
                ->first();

            return view('dashboard')
                ->with('user_name', $user->nama_lengkap)
                ->with('user_mail', $user->email);
        } else {
            session()->flash('session_stop', 'Session berakhir!');
            return redirect('/');
        }
    }
}
