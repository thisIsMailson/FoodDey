<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ExceptionTrait
{
    public function apiException($request, $exception){

        if($this->isModel($exception)){
            return $this->errorResponse('Not found', Response::HTTP_NOT_FOUND);
        }

        if($this->isHttp($exception)){
            return $this->errorResponse('Incorrect route', Response::HTTP_NOT_FOUND);
        }

        return parent::render($request, $exception);

    }


    public function isModel($exception){
        return $exception instanceof ModelNotFoundException;
    }

    public function isHttp($exception){
        return $exception instanceof NotFoundHttpException;
    }


    public function errorResponse($message, $code){
        return response()->json([
            'errors' => $message
        ], $code);
    }

}
