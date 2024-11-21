<?php

namespace CriminalCases\App\Domain\Interfaces;

interface UseCase
{
    public function execute(mixed $data = null): mixed;
}
