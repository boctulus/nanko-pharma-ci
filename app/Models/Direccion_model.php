<?php namespace App\Models;

use CodeIgniter\Model;

class Direccion_model extends Model
{
    protected $table      = 'direccion_usuario';
    protected $primaryKey = 'id_direccion';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_usuario','nombre','direccion','cp','estado','colonia','ciudad', 'municipio', 'calle', 'num_ext', 'num_int','pais','tel','instrucciones','estatus'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}
