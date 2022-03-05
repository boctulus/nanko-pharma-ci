<?php namespace App\Models;

use CodeIgniter\Model;

class Testimonio_model extends Model
{
    protected $table      = 'testimonio';
    protected $primaryKey = 'id_testimonio';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre','titulo','mensaje','img','estado'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
}