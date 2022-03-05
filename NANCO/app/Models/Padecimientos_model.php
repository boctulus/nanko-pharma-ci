<?php namespace App\Models;

use CodeIgniter\Model;

class Padecimientos_model extends Model
{
    protected $table      = 'padecimiento';
    protected $primaryKey = 'idPadecimiento';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre_p', 'descripcion','estado','id_producto'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
}