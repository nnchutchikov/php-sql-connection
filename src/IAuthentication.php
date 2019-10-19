<?php
declare (strict_types = 1);

namespace NNChutchikov\Sql\Connection;

interface IAuthentication
{
    public function user(): string;
    public function password(): string;
}
