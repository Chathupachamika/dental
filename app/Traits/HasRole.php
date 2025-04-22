<?php

namespace App\Traits;

trait HasRole
{
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
