<?php
namespace App\Query;

use App\Object\BaseObject;
use Doctrine\DBAL\Driver\Mysqli\Connection;

abstract class Query extends BaseObject
{
    protected Connection $connection;

    public function __construct()
    {
        $this->connection = new Connection(new \mysqli(
            env('DB_HOST'),
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_DBNAME')
        ));
    }
}
