<?php namespace App\Models;

use CodeIgniter\Model;

class Colaboradores_model extends Model
{
    protected $table      = 'colaborador';
    protected $primaryKey = 'id_colaborador';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'apellidos','direccion','correo_n','correo_p','cp','descuento','estado','telefono','pais','estado_p'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}
