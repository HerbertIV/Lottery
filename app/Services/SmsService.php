<?php

namespace App\Services;

use App\Services\Contracts\SmsServiceContract;
use Illuminate\Support\Facades\Http;

class SmsService implements SmsServiceContract
{
    //TODO I have to add VO with validate params to send sms, and I should make facade with that
    private const URL = 'https://api2.smsplanet.pl/sms';
    private bool $test;
    private string $message;
    private string $to;
    private string $from;

    public function __construct()
    {
        $this->test = config('env') !== 'production';
    }

    public function send()
    {
        Http::withToken(env('SMS_API_TOKEN'))->post(self::URL, [
            'test' => $this->test,
            'msg' => $this->message,
            'to' => $this->to,
            'from' => $this->from
        ]);
    }
}
