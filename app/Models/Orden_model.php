<?php namespace App\Models;

use CodeIgniter\Model;

class Orden_model extends Model
{
    protected $table      = 'ordenes';
    protected $primaryKey = 'id_orden';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['fecha','precio_total', 'precio_envio','estado','num_guia','id_direccion','id_usuario','id_pago','tipo_pago','estado_pago','pais','url_pdf'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}
