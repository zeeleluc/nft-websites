<?php
namespace App\Query;

use App\Slack;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\ParameterType;

class MigrationQuery extends Query
{

    private string $table = 'migrations';

    /**
     * @throws Exception
     */
    public function has(string $identifier): bool
    {
        $sql = /** @lang sql */
            <<<SQL
SELECT * FROM migrations WHERE identifier = ? LIMIT 1
SQL;

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(1, $identifier, ParameterType::STRING);
        $results = $statement->execute()->fetchAssociative();

        if (!$results) {
            return false;
        }

        return true;
    }

    /**
     * @throws Exception
     */
    public function getAllIdentifiers(): array
    {
        $sql = /** @lang sql */
            <<<SQL
select * from `migrations` limit 10000;
SQL;

        $statement = $this->connection->prepare($sql);
        $results = $statement->execute()->fetchAllAssociative();

        if (!$results) {
            return [];
        }

        return array_column($results, 'identifier');
    }

    public function executeMigration(string $sql, string $identifier): bool
    {
        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute();
            $this->addMigrationDone('sql-' . $identifier);
            return true;
        } catch (\Exception $e) {
            $slack = new Slack();
            $slack->sendErrorMessage($e->getMessage());
            return false;
        } catch (Exception $e) {
            $slack = new Slack();
            $slack->sendErrorMessage($e->getMessage());
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function addMigrationDone(string $identifier): bool
    {
        $sql = /** @lang sql */
            <<<SQL
INSERT INTO migrations (identifier) VALUES (?)
SQL;

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(1, $identifier, ParameterType::STRING);
        $result = $statement->execute();

        return $result->rowCount() >= 1;
    }
}
