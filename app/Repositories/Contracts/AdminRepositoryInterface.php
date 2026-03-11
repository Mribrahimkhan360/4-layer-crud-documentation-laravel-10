<?php


namespace App\Repositories\Contracts;


interface AdminRepositoryInterface
{
    public function all();
    public function allByUser($userId);
}
