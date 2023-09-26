<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class serviceController extends Controller
{
    public function index()
    {
        // asdasd

        $id = session()->get('id');

        $user = DB::table('tb_userdetail')
            ->where('id', $id)
            ->first();

        return view('formservice')
            ->with('user_name', $user->nama_lengkap)
            ->with('user_mail', $user->email);
    }
    public function detailservice()
    {
        $id = session()->get('id');

        $user = DB::table('tb_userdetail')
            ->where('id', $id)
            ->first();

        $detailService = DB::table('tb_service')
            ->paginate(25);

        return view('detailservice')
            ->with('user_name', $user->nama_lengkap)
            ->with('user_mail', $user->email)
            ->with('detailService', $detailService);
    }
    public function prosesNewService(Request $r)
    {
        $r->validate([
            "nama_layanan" => ['required'],
            "deskripsi_layanan" => ['required'],
            "harga_layanan" => ['required'],
            "thumbnail" => ['required', 'file', 'max:2048', 'mimes:png']
        ]);

        if ($r->hasFile('thumbnail')) {
            $file = $r->file('thumbnail');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('upload', $fileName); // Simpan file ke direktori 'storage/app/uploads'

            // Lakukan penyimpanan data yang lain (nama_layanan, deskripsi_layanan, harga_layanan) ke database di sini
            $insert = DB::table('tb_service')->insert([
                "nama_layanan" => $r->nama_layanan,
                "deskripsi_layanan" => $r->deskripsi_layanan,
                "harga_layanan" => $r->harga_layanan,
                "thumbnail" => $filePath, // Simpan path file di database
            ]);

            if (!$insert) {
                session()->flash('insert-crash', 'Ada kesalahan dalam menambahkan Data, Periksa Kembali!');
                return redirect('/new/service/add');
            } else {
                session()->flash('insert-success', 'Data Berhasil di tambahkan!');
                return redirect('/new/service/add');
            }
        }
    }
    public function deleteService($id_service)
    {
        $del = DB::table('tb_service')
            ->where('id', $id_service)
            ->delete();

        if (!$del) {
            session()->flash('delete-crash', 'Ada kesalahan dalam menghapus Data, Periksa Kembali!');
            return redirect('/detail/service');
        } else {
            session()->flash('delete-success', 'Data Berhasil di Hapus!');
            return redirect('/detail/service');
        }
    }
    public function updateService($id_service)
    {
        $id = session()->get('id');

        $user = DB::table('tb_userdetail')
            ->where('id', $id)
            ->first();

        $data = DB::table('tb_service')
            ->where('id', $id_service)
            ->first();

        return view('formUpdateService')
            ->with('data', $data)
            ->with('user_name', $user->nama_lengkap)
            ->with('user_mail', $user->email);;
    }
    public function prosesUpdateService(Request $r, $id_service)
    {
        if (session()->has('id')) {
            $update = DB::table('tb_service')
                ->where('id', $id_service)
                ->update([
                    "nama_layanan" => $r->nama_layanan,
                    "deskripsi_layanan" => $r->deskripsi_layanan,
                    "harga_layanan" => $r->harga_layanan
                ]);

            if (!$update) {
                session()->flash('update-crash', 'Ada kesalahan dalam mengubah Data, Periksa Kembali!');
                return redirect('/detail/service');
            } else {
                session()->flash('update-success', 'Data Berhasil di Diubah!');
                return redirect('/detail/service');
            }
        } else {
            session()->flash('session_stop', 'Session berakhir!');
            return redirect('/');
        }
    }
}
