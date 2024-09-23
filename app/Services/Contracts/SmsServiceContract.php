<?php

namespace App\Services\Contracts;

interface SmsServiceContract
{
    public function send(): bool;
    public function validate(): void;
    public function setMessage(string $message): self;
    public function setTo(string|array $to): self;
    public function setFrom(string $from): self;
}
