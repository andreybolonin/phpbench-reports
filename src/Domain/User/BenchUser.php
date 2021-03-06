<?php

namespace App\Domain\User;

interface BenchUser
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_BENCHMARKER = 'ROLE_BENCHMARKER';

    public function vendorId(): string;

    public function username(): string;

    public function id(): string;

    public function setRoles(array $roles): void;
}
