<?php namespace App\Models;

use CodeIgniter\Model;

class Contacto_model extends Model
{
    protected $table      = 'contacto';
    protected $primaryKey = 'id_contacto';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre','correo','mensaje','dep_med','estado','fecha','telefono'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}
