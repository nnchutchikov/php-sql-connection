<?php
declare (strict_types = 1);

namespace NNChutchikov\Sql\Connection;

interface IDriverOptions
{
    public function driverOptions(): array;
}
