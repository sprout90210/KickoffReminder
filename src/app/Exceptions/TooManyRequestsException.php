<?php

namespace App\Exceptions;

use Exception;

class TooManyRequestsException extends Exception
{
  protected $message = 'リクエストが多すぎます。時間を空けて再度実行してください。';
}
