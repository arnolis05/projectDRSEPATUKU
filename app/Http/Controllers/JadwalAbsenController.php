<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class JadwalAbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = session()->get('id');
        $user = DB::table('tb_userdetail')
            ->where('id', $id)
            ->first();

        // get data jadwal absensi
        $jadwal_absen = DB::table('tb_absensi')
            ->select('*')

            ->get();



        return view('Cabang.JadwalAbsen.index')
            ->with('user_name', $user->nama_lengkap)
            ->with('user_mail', $user->email)
            ->with('jadwal_absen', $jadwal_absen);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tanggal  = $request->tanggal;
        $jam_masuk =  $request->jam_masuk;
        $jam_keluar = $request->jam_keluar;
        $department = $request->department;

        // save jadwal absen
        DB::table('tb_absensi')
            ->insert(['tanggal' => $tanggal, 'jam_masuk' => $jam_masuk, 'jam_keluar' => $jam_keluar, 'id_department' => $department]);

            return redirect('/jadwal-absen')->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = [
            'tanggal' => 1,
            'jam_masuk' =>2,
            'jam_keluar' => 1,
            'id_department' => 2
        ];

        // update data 
        DB::table('tb_absensi')
            ->where('id', $id) 
            ->update($data);

            return redirect('/jadwal-absen')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('tb_absensi')
        ->where('id', $id) 
        ->delete();

        return redirect('/jadwal-absen')->with('success', 'Data berhasil dihapus!');
    }
}
