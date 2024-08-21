<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SmsSendException extends ValidationException
{
}
