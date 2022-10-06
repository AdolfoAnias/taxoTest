<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface IUserRepository 
{
    public function all();
    public function create(array $data);
    public function update($id, $data);
    public function findBy($att, $column);
    public function destroy($id);
    public function find($id);
}
