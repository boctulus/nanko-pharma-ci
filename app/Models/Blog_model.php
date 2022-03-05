<?php namespace App\Models;

use CodeIgniter\Model;

class Blog_model extends Model
{
    protected $table      = 'blog';
    protected $primaryKey = 'id_blog';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['titulo','contenido','img_portada','descripcion','fecha','estado'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
}