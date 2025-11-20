<?php

namespace App\Exceptions;

use Exception;

class FavoriteNotFoundException extends Exception
{
    protected $message = '対象のお気に入りが見つかりません。';
}
