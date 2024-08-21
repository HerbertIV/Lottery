<?php

namespace App\Traits;

trait FacadeHelper
{
    public function toArray(): array
    {
        $reflection = new \ReflectionClass($this);

        return collect($reflection->getProperties())->mapWithKeys(
            fn (\ReflectionProperty $reflection) => [
                $reflection->getName() => $reflection->isInitialized($this) ? $reflection->getValue($this) : null
            ]
        )->toArray();
    }

    public function make(...$params): self
    {
        return new self($params);
    }
}
