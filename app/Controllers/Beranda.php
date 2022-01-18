<?php

namespace App\Controllers;

use App\Models\PesanModel;
use App\Models\PengaturanModel;

class Beranda extends BaseController
{
    public function __construct()
    {
        $this->pesanModel = new PesanModel;
        $this->pengaturanModel = new PengaturanModel;
    }
    public function index()
    {
        $pengaturan = $this->pengaturanModel->where("id", 1)->first();
        $data = [
            "pengaturan" => $pengaturan,
            "tglHari" => $this->hariSeminggu(),
        ];
        return view('beranda', $data);
    }

    public function pesanan()
    {
        date_default_timezone_set("Asia/Jakarta");
        $tanggal = date('Y-m-d', strtotime('today'));

        echo json_encode($this->pesanModel->where(['tanggal >=' => $tanggal,  'selesai' => 0])->findAll());
    }

    public function hariSeminggu()
    {
        date_default_timezone_set("Asia/Jakarta");
        $hari = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
        $hariIndo = array("Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu", "Minggu");

        $hariIni = array_search(date('D', strtotime('today')), $hari);

        $tanggalSeminggu = array(date('d-m-Y', strtotime('next monday')), date('d-m-Y', strtotime('next tuesday')), date('d-m-Y', strtotime('next wednesday')), date('d-m-Y', strtotime('next thursday')), date('d-m-Y', strtotime('next friday')), date('d-m-Y', strtotime('next saturday')), date('d-m-Y', strtotime('next sunday')));

        $tanggalSeminggu[$hariIni] = date('d-m-Y', strtotime('today'));

        $hasil = array();

        for ($i = $hariIni; $i < count($hari); $i++) {
            array_push($hasil, array($hariIndo[$i], $tanggalSeminggu[$i]));
        }
        for ($i = 0; $i < $hariIni; $i++) {
            array_push($hasil, array($hariIndo[$i], $tanggalSeminggu[$i]));
        }

        return $hasil;
    }

    public function login()
    {
        $pengaturan = $this->pengaturanModel->where("id", 1)->first();
        $pass = $this->request->getPost("pass");
        if (password_verify($pass, $pengaturan["password"])) {
            session()->set('id', 1);
            echo json_encode("");
        } else {
            echo json_encode("Password salah :(");
        }
    }

    public function logout()
    {
        session()->remove('id');
        return redirect()->to(base_url() . "/beranda");
    }
}
