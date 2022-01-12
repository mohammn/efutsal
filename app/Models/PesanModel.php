<?php

namespace App\Models;

use CodeIgniter\Model;

class PesanModel extends Model
{

    protected $table = "pesan";
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'tanggal', 'jam', 'lapangan', 'bayar', 'selesai'];
}
