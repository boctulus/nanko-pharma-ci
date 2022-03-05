<?php namespace App\Models;

use CodeIgniter\Model;

class Categoria_model extends Model
{
    protected $table      = 'categoria';
    protected $primaryKey = 'id_categoria';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre','nombre_ing','categoria_padre'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}
