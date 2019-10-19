<?php
declare (strict_types = 1);

namespace NNChutchikov\Sql\Connection;

class Exception extends \Exception
{
    const EXCP_CONNECTION_ERROR = 1;
    const EXCP_CONNECTION_DSN_ABSENT = 2;

    public static function connectionError(string $_dsn)
    {
        return new self("Connection error ({$_dsn})", self::EXCP_CONNECTION_ERROR);
    }

    public static function connectionStringAbsent()
    {
        return new self("Connection options dsn absent", self::EXCP_CONNECTION_DSN_ABSENT);
    }
}
