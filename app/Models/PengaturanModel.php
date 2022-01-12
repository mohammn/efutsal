<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{

    protected $table = "pengaturan";
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'jmlLap', 'jamBuka', 'jamTutup', 'password'];
}
