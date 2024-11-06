<?php
namespace App\Query;

use App\Model\NFT;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\ParameterType;

class NFTQuery extends Query
{

    private string $table = 'regens';

    /**
     * @throws Exception
     */
    public function getNFT(int $nft_id): ?NFT
    {
        $sql = /** @lang sql */
            <<<SQL
SELECT * FROM regens WHERE nft_id = ? LIMIT 1
SQL;

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(1, $nft_id, ParameterType::INTEGER);
        $data = $statement->execute()->fetchAssociative();

        if ($data === false) {
            return null; // NFT not found
        }

        return new NFT($nft_id);
    }

    public function countNFTsFiltered(array $filters): int
    {
        $sql = "SELECT id FROM regens";

        $conditions = [];
        $parameters = [];
        $types = [];

        foreach ($filters as $column => $value) {
            // Use backticks around column names
            $column = str_replace(' ', '_', do_spaces($column));
            $conditions[] = "`property_$column` = ?";
            $parameters[] = htmlspecialchars($value);
            $types[] = ParameterType::STRING;
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        $statement = $this->connection->prepare($sql);

        foreach ($parameters as $index => $parameter) {
            $statement->bindValue($index + 1, $parameter, $types[$index]);
        }

        $results = $statement->execute()->fetchAllAssociative();

        return count($results);
    }

    public function getNFTsFiltered(array $filters, int $offset = 0): array
    {
        // Define the maximum number of results to return
        $limit = env('FILTER_LIMIT');

        // Initialize SQL parts
        $sql = "SELECT * FROM regens";

        $conditions = [];
        $parameters = [];
        $types = [];

        // Process filters
        foreach ($filters as $column => $value) {
            // Use backticks around column names
            $column = str_replace(' ', '_', do_spaces($column));
            $conditions[] = "`property_$column` = ?";
            $parameters[] = htmlspecialchars($value);
            $types[] = ParameterType::STRING;
        }

        // Add conditions to SQL if there are any
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        // Add ORDER BY nft_id and limit with offset for pagination
        $sql .= " ORDER BY nft_id LIMIT ? OFFSET ?";

        // Prepare the statement
        $statement = $this->connection->prepare($sql);

        // Bind all parameters
        foreach ($parameters as $index => $parameter) {
            $statement->bindValue($index + 1, $parameter, $types[$index]);
        }

        // Bind the limit and offset parameters
        $statement->bindValue(count($parameters) + 1, $limit, ParameterType::INTEGER);
        $statement->bindValue(count($parameters) + 2, $offset, ParameterType::INTEGER);

        // Execute query
        $results = $statement->execute()->fetchAllAssociative();

        // Convert results to NFT objects
        $nfts = [];
        foreach ($results as $result) {
            // Assuming NFT constructor takes nft_id as a parameter
            $nfts[] = new NFT($result['nft_id']);
        }

        return $nfts;
    }

    /**
     * @throws Exception
     */
    public function hasNFT(int $nftId): bool
    {
        $sql = /** @lang sql */
            <<<SQL
select 1 from regens where nft_id = ? LIMIT 1
SQL;

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(1, $nftId, ParameterType::INTEGER);
        $result = $statement->execute()->fetchAssociative();

        return $result !== false;
    }

    /**
     * @throws Exception
     */
    public function addNFT(array $properties): bool
    {
        // List of all possible columns
        $possibleColumns = [
            'nft_id',
            'background',
            'drip',
            'eyes',
            'hair',
            'head',
            'top',
            'type',
            'eye_shadow',
            'mouth',
            'outer_wear',
            'glasses',
            'artist',
        ];

        // Filter the properties to include only those that are present in the possible columns
        $filteredProperties = array_intersect_key($properties, array_flip($possibleColumns));

        // If no valid properties are provided, return false
        if (empty($filteredProperties)) {
            return false;
        }

        // Build the SQL query dynamically
        $columns = implode(', ', array_keys($filteredProperties));
        $placeholders = implode(', ', array_fill(0, count($filteredProperties), '?'));
        $sql = <<<SQL
insert into regens ($columns) values ($placeholders)
SQL;

        $statement = $this->connection->prepare($sql);

        // Bind the values to the placeholders
        $i = 1;
        foreach ($filteredProperties as $value) {
            $statement->bindValue($i++, $value, ParameterType::STRING);
        }

        // Execute the statement
        $result = $statement->execute();

        return $result->rowCount() >= 1;
    }
}
