<?php

namespace App\Services;

use App\Exceptions\SmsSendException;
use App\Services\Contracts\SmsServiceContract;
use App\Traits\FacadeHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\Translation\t;

class SmsService implements SmsServiceContract
{
    use FacadeHelper;
    private const URL = 'https://api2.smsplanet.pl/sms';
    private bool $test;
    private string $message;
    private string|array $to;
    private string $from;

    private const RULES = [
        'test' => ['boolean'],
        'message' => ['string', 'max:160'],
        'to' => ['required'],
        'from' => ['required', 'string'],
    ];

    public function __construct()
    {
        $this->test = config('env') !== 'production';

    }

    public function send(): bool
    {
        $this->validate();
        $response = Http::withToken(env('SMS_API_TOKEN'))
            ->post(
                self::URL,
                [
                    'msg' => $this->message ?? '',
                    'to' => $this->to,
                    'from' => $this->from
                ]
            );
        $response->throwUnlessStatus(JsonResponse::HTTP_OK);
        return true;
    }

    public function validate(): void
    {
        $validator = Validator::make($this->toArray(), self::RULES);
        $validator->setException(SmsSendException::class)->validate();
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function setTo(string|array $to): self
    {
        $this->to = $to;

        return $this;
    }

    public function setFrom(string $from): self
    {
        $this->from = $from;

        return $this;
    }
}
