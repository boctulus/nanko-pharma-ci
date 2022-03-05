<?php namespace App\Models;

use CodeIgniter\Model;

class Dosis_model extends Model
{
    protected $table      = 'dosis';
    protected $primaryKey = 'id_dosis';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_producto','edad_min','edad_max','peso_min','peso_max','subir_1','subir_2','fecha','resultado_m','resultado_t','resultado_n','estado','padecimientos'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
}