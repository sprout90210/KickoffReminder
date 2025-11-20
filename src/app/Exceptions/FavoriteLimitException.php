<?php

namespace App\Exceptions;

use Exception;

class FavoriteLimitException extends Exception
{
    protected $message = 'お気に入り登録数の上限に達しています。';
}
