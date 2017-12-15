<?php

namespace App\Domain\Store;

interface SuiteStore
{
    public function store(string $id, array $data): void;

    public function forSuiteUuid(string $uuid): array;
}
