<?php
namespace App\Action;

use App\Action\Interfaces\CliActionInterface;
use App\Query\NFTQuery;
use Doctrine\DBAL\Driver\Exception;

class InjectNFTDataAction extends BaseAction implements CliActionInterface
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
     * @throws Exception
     */
    public function run(): void
    {
        foreach (range(1, 8888) as $id) {
            $json = file_get_contents(env('CDN_ENDPOINT_METADATA') . $id . '.json');
            $metadata = (array) json_decode($json, true);
            $properties = [
                'nft_id' => $id,
            ];

            foreach ($metadata['attributes'] as $attribute) {
                $properties[snake_case($attribute['trait_type'])] = $attribute['value'];
            }

            if (!$this->NFTQuery->hasNFT($id)) {
                $this->NFTQuery->addNFT($properties);
            }
        }
    }
}
