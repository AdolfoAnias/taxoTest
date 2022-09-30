<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Contracts\IUserRepository;
use App\Models\User;

/**
 * Description of AgencyRepository
 *
 * @author doimeadios
 */
class UserRepository implements IUserRepository {

    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function all() {
        return $this->user->all();
    }

    public function create(array $data) {
        return $this->user->create($data);
    }

    public function update($id, $data) {
        return $this->user->find($id)->update($data);
    }

    public function findBy($att, $column) {
        return $this->user->where($att, $column)->get();
    }

    public function destroy($id) {
        $user = $this->user->find($id);
        if ($user != null) {
            return $user->delete();
        }
        return false;
    }

    public function find($id) {
        return $this->user->find($id);
    }

}
