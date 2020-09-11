<?php

namespace App\Http\Messages;

trait ResponseMessageTrait
{
    // api responses
    public function apiReponse($status, $message, $code){
        return response()->json([
            'status' => $status,
            'message' => $message
        ], $code);
    }

}
