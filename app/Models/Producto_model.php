<?php namespace App\Models;

use CodeIgniter\Model;

class Producto_model extends Model
{
    protected $table      = 'productos';
    protected $primaryKey = 'idProducto';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['idCategoria','nombre','nombre_ing','descripcion','precio_1','precio_2','precio_3','precio_4','precio_5','regiones','stock','estado','img_port','img_sec','cantidad_vendida','descripcion_ingles','peso','desc_mex','desc_peru','desc_eur','desc_arg','desc_rest'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}
