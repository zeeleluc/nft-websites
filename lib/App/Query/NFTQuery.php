<?php
namespace App\Query;

use App\Model\NFT;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\ParameterType;

class NFTQuery extends Query
{

    private string $table = 'nfts';

    /**
     * @throws Exception
     */
    public function getNFT(int $nft_id): ?NFT
    {
        $sql = /** @lang sql */
            <<<SQL
SELECT * FROM nfts WHERE nft_id = ? LIMIT 1
SQL;

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(1, $nft_id, ParameterType::INTEGER);
        $data = $statement->execute()->fetchAssociative();

        if ($data === false) {
            return null; // NFT not found
        }

        return new NFT($data);
    }

    /**
     * @throws Exception
     */
    public function hasNFT(int $nftId): bool
    {
        $sql = /** @lang sql */
            <<<SQL
select 1 from nfts where nft_id = ? LIMIT 1
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
            'back_props',
            'body',
            'plebs_heads',
            'clothes',
            'eyes',
            'hair',
            'hands',
            'mouth',
            'special',
            'accessories',
            'hats'
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
insert into nfts ($columns) values ($placeholders)
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
