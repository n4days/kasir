<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthGroupsUsersModel extends Model
{
    protected $table      = 'auth_groups_users';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';

    protected $allowedFields = ['group_id', 'user_id'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAuthGroupsUsers()
    {
        $builder = $this->table($this->table);
        $builder->join('auth_groups', 'auth_groups.id=' . $this->table . '.group_id', 'LEFT');
        $builder->join('users', 'users.id=' . $this->table . '.user_id', 'LEFT');
        return $builder->get();
    }
}
