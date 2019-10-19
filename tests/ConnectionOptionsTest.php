<?php
declare (strict_types = 1);

namespace NNChutchikov\Sql\Connection\Tests\ConnectionTest;

use NNChutchikov\Sql\Connection\Connection;
use NNChutchikov\Sql\Connection\Exception;
use NNChutchikov\Sql\Connection\IAuthentication;
use NNChutchikov\Sql\Connection\IDriverOptions;
use NNChutchikov\Sql\Connection\IDsn;
use PHPUnit\Framework\TestCase;

require_once 'vendor/autoload.php';

class MyConnectionOption implements IDsn, IAuthentication, IDriverOptions
{

    public function __construct(string $_user, string $_password)
    {
        $this->user = $_user;
        $this->password = $_password;
    }

    public function connectionString(): string
    {
        return 'sqlite::memory:';
    }

    public function password(): string
    {
        return $this->password;
    }

    public function user(): string
    {
        return $this->user;
    }

    public function driverOptions(): array
    {
        return ['version' => 777];
    }
}

/**
 * @covers \NNChutchikov\Sql\Connection\Connection
 * @covers \NNChutchikov\Sql\Connection\Exception
 */
class ConnectionTest extends TestCase
{
    private $options = null;

    public function setUp(): void
    {
        $this->options = new MyConnectionOption('nnch', '123456');
    }

    public function testConnection()
    {
        $connection = Connection::create($this->options);
        $this->assertEquals($this->options, $connection->connectionOptions());
        $this->assertInstanceOf('PDO', $connection->pdo());
    }

    public function testConnectionClone()
    {
        $connection1 = Connection::create($this->options);
        $connection2 = $connection1->clone();

        $this->assertEquals($connection1->connectionOptions(), $connection2->connectionOptions());
    }

    public function testConnectionOptionsDsnAbsent()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(Exception::EXCP_CONNECTION_DSN_ABSENT);

        Connection::create(new class()
        {});
    }

    public function testConnectionCreationFail()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(Exception::EXCP_CONNECTION_ERROR);

        Connection::create(
            new class() implements IDsn
            {
                public function connectionString(): string
                {
                    return 'bla-bla-bla';
                }
            }
        );
    }
}
