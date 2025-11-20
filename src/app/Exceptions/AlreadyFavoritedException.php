<?php

namespace App\Exceptions;

use Exception;

class AlreadyFavoritedException extends Exception
{
    protected $message = 'すでにお気に入りに登録されています。';
}
