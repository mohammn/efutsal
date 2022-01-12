<?php

namespace App\Controllers;

use App\Models\PesanModel;
use App\Models\PengaturanModel;

class Admin extends BaseController
{
    public function __construct()
    {
        $this->pesanModel = new PesanModel;
        $this->pengaturanModel = new PengaturanModel;
    }
    public function index()
    {
        if (!session()->get('id')) {
            return redirect()->to(base_url() . "/beranda");
        }
        $pengaturan = $this->pengaturanModel->where("id", 1)->first();
        $data = [
            "pengaturan" => $pengaturan
        ];
        return view('admin', $data);
    }

    public function getPengaturan()
    {
        echo json_encode($this->pengaturanModel->where("id", 1)->first());
    }

    public function simpanPengaturan()
    {
        $data = [
            "nama" => $this->request->getPost("nama"),
            "jmlLap" => $this->request->getPost("jmlLap"),
            "jamBuka" => $this->request->getPost("jamBuka"),
            "jamTutup" => $this->request->getPost("jamTutup")
        ];

        $this->pengaturanModel->update(1, $data);

        echo json_encode("");
    }

    public function pesanan()
    {
        echo json_encode($this->pesanModel->where(['selesai' => 0])->findAll());
    }

    public function lunasHariIni()
    {
        date_default_timezone_set("Asia/Jakarta");
        $tanggalMulai = date('Y-m-d', strtotime('today'));
        $tanggalSelesai = date('Y-m-d', strtotime('today'));

        echo json_encode($this->pesanModel->where(['tanggal >=' => $tanggalMulai, 'tanggal <=' => $tanggalSelesai, 'selesai' => 1])->findAll());
    }

    public function tambah()
    {
        $data = [
            "nama" => $this->request->getPost("nama"),
            "tanggal" => $this->request->getPost("tanggal"),
            "jam" => $this->request->getPost("jam"),
            "lapangan" => $this->request->getPost("lapangan"),
            "bayar" => $this->request->getPost("bayar"),
            "selesai" => 0
        ];

        $cekJam = $this->pesanModel->where(["tanggal" => $this->request->getPost("tanggal"), "jam" => $this->request->getPost("jam"), "lapangan" => $this->request->getPost("lapangan")])->first();
        if ($cekJam) {
            echo json_encode("Lapangan dengan jam dan tanggal tersebut sudah di pesan.");
        } else {
            $this->pesanModel->save($data);
            echo json_encode("");
        }
    }

    public function bayar()
    {
        $id = $this->request->getPost("id");
        $data = [
            "bayar" => $this->request->getPost("bayar"),
            "selesai" => $this->request->getPost("selesai")
        ];

        $this->pesanModel->update($id, $data);

        echo json_encode("");
    }

    public function laporan()
    {
        $tanggalMulai = $this->request->getPost('tanggalMulai');
        $tanggalSelesai = $this->request->getPost('tanggalSelesai');

        $transaksi = $this->pesanModel->where(['tanggal >=' => $tanggalMulai, 'tanggal <=' => $tanggalSelesai, 'selesai' => 1])->findAll();

        echo json_encode($transaksi);
    }

    public function ubahPass()
    {
        $passBaru = $this->request->getPost('passBaru');
        $konfiPass = $this->request->getPost('konfirPass');
        $passLama = $this->request->getPost('passLama');

        $passLamaDB = $this->pengaturanModel->where("id", 1)->first()["password"];

        if ($passBaru != $konfiPass) {
            echo json_encode("Password Konfirmasi tidak cocok.");
        } else if (password_verify($passLama, $passLamaDB)) {
            $data = ["password" => password_hash($passBaru, PASSWORD_DEFAULT)];
            $this->pengaturanModel->update(1, $data);
            echo json_encode("");
        } else {
            echo json_encode("Password lama anda salah.");
        }
    }

    public function hapus()
    {
        $this->pesanModel->delete($this->request->getPost("id"));
        echo json_encode("");
    }

    public function logout()
    {
        session()->remove('id');
        return redirect()->to(base_url() . "/beranda");
    }
}
