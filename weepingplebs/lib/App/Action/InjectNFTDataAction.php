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
            if (!$this->NFTQuery->hasNFT($id)) {
                $json = file_get_contents(env('CDN_ENDPOINT_METADATA') . $id . '.json');
                $metadata = (array) json_decode($json, true);
                $properties = [
                    'nft_id' => $id,
                ];

                foreach ($metadata['attributes'] as $attribute) {
                    $properties[snake_case($attribute['trait_type'])] = snake_case($attribute['value']);
                }

                $this->NFTQuery->addNFT($properties);
                echo '#' . $id . ' added..' . PHP_EOL;
            } else {
                echo '#' . $id . ' already exists..' . PHP_EOL;
            }
        }
    }
}
