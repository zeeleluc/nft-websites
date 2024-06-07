<?php

namespace App\Collection;

use App\Query\NFTQuery;
use Doctrine\DBAL\Driver\Exception;

class NFTs
{

    private NFTQuery $NFTQuery;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->NFTQuery = new NFTQuery();
    }

    /**
     * @param int $total
     * @return array|NFTs[]
     * @throws Exception
     */
    public function getRandom(int $total = 10): array
    {
        $ids = range(1, 8888);
        shuffle($ids);
        $ids = array_slice($ids, 0, $total);

        $NFTs = [];
        foreach ($ids as $id) {
            $NFTs[] = $this->NFTQuery->getNFT($id);
        }

        return $NFTs;
    }

    /**
     * @throws Exception
     */
    public function getFiltered(array $filters): array
    {
        return $this->NFTQuery->getNFTsFiltered($filters);
    }
}
