<?php

namespace App\Exceptions;

use Exception;

class NotBelongsToUser extends Exception
{
    public function render()
    {
        return ['errors'=> 'Not belongs to user'];
    }
}
