<?php

namespace App\Exceptions;

use Exception;

class NotUsersRequest extends Exception
{
    public function render()
    {
        return ['errors'=> 'Storage request does not belong to the user'];
    }
}
