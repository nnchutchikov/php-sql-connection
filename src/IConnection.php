<?php
declare (strict_types = 1);

namespace NNChutchikov\Sql\Connection;

interface IConnection
{
    public function connectionOptions();
    public function pdo(): \PDO;
    public function clone (): IConnection;
    public static function create($_connectionOptions): IConnection;
}
