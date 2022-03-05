<?php namespace App\Models;

use CodeIgniter\Model;

class Login_model extends Model
{
    protected $table      = 'login';
    protected $primaryKey = 'id_login';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre','apellidos','correo','pass','codigo','telefono','estado','tipo_usuario','fk_usuario','openpay','token_v','pais'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
}