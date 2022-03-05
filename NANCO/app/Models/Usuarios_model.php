<?php namespace App\Models;

use CodeIgniter\Model;

class Usuarios_model extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre','direccion','telefono','correo','cp','fecha_nacimiento','estado','pais'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
}