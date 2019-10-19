<?php
declare (strict_types = 1);

namespace NNChutchikov\Sql\Connection;

interface IDsn
{
    public function connectionString(): string;
}
