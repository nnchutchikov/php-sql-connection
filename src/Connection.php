<?php
declare (strict_types = 1);

namespace NNChutchikov\Sql\Connection;

class Connection implements IConnection
{
    private $pdo = null;
    private $options = null;

    private function __construct(\PDO $_pdo, $_options)
    {
        $this->pdo = $_pdo;
        $this->options = $_options;
    }

    public function connectionOptions()
    {
        return $this->options;
    }

    public function pdo(): \PDO
    {
        return $this->pdo;
    }

    function clone (): IConnection {
        return self::create($this->options);
    }

    public static function create($_options): IConnection
    {

        $pdo = null;
        $dsn = '';
        $user = '';
        $password = '';
        $driverOptions = [];

        if ($_options instanceof IDsn) {
            $dsn = $_options->connectionString();
        } else {
            throw Exception::connectionStringAbsent();
        }

        if ($_options instanceof IAuthentication) {
            $user = $_options->user();
            $password = $_options->password();
        }

        if ($_options instanceof IDriverOptions) {
            $driverOptions = $_options->driverOptions();
        }

        try {
            $pdo = new \PDO($dsn, $user, $password, $driverOptions);
        } catch (\PDOException $e) {
            throw Exception::connectionError($dsn);
        }

        return new self($pdo, $_options);
    }
}
