<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DepartmentController extends Controller
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


        // get data department
        $department = DB::table('tb_department')
            ->select('*')
            ->get();








        return view('Cabang.Department.index')
            ->with('user_name', $user->nama_lengkap)
            ->with('user_mail', $user->email)
            ->with('department', $department);
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
        $judul_department = $request->department;
        $deskripsi_department = $request->deskripsi;
        $id_user  = 1;



        $data = [
            'judul_department' => $judul_department,
            'deskripsi_department' => $deskripsi_department,
            'id_user' => $id_user
        ];

        // save jadwal absen
        DB::table('tb_department')
            ->insert($data);

        return redirect('/department')->with('success', 'Data berhasil disimpan!');
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
            'judul_department' => 'asdasdas',
            'deskripsi_department' => 'asdasdasd',

        ];

        // update data 
        DB::table('tb_department')
            ->where('id', $id)
            ->update($data);

        return redirect('/department')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('tb_department')
        ->where('id', $id)
            ->delete();

        return redirect('/department')->with('success', 'Data berhasil dihapus!');
    }
}
