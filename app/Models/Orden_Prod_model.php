<?php namespace App\Models;

use CodeIgniter\Model;

class Orden_Prod_model extends Model
{
    protected $table      = 'orden_producto';
    protected $primaryKey = 'id_ord_pro';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_producto', 'id_orden','cantidad'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
}