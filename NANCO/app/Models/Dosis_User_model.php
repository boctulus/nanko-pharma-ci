<?php namespace App\Models;

use CodeIgniter\Model;

class Dosis_User_model extends Model
{
    protected $table      = 'dosis_usuario';
    protected $primaryKey = 'id_dos_us';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_usuario','id_dosis','fecha','edad','peso'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
}