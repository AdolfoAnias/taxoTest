<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Contracts;

use Illuminate\Http\Request;

/**
 *
 * @author doimeadios
 */
interface IUserRepository {

    public function all();
    public function create(array $data);
    public function update($id, $data);
    public function findBy($att, $column);
    public function destroy($id);
    public function find($id);
}
