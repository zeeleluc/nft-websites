<?php
namespace App\Action;

use App\Variable;
use Doctrine\DBAL\Driver\Exception;

class HomeAction extends BaseAction
{
    /**
     * @throws Exception
     */
    public function run()
    {
        parent::__construct();

        $this->setLayout('default');
        $this->setView('website/home');

        $jsonFile = ROOT . '/wallets-wl-nobased.json';
        $wallets = (array) json_decode(file_get_contents($jsonFile), true);

        $jsonFile = ROOT . '/top-25-holders-1-eth-share.json';
        $lastModified = filemtime($jsonFile);
        $top25Wallets1EthPrize = (array) json_decode(file_get_contents($jsonFile), true);

        $images = glob(ROOT . '/assets/images/example_images/*.png');
        shuffle($images);
        $imageFileNames = [];
        foreach ($images as $image) {
            $imageFileNames[] = pathinfo($image)['basename'];
        }

        $whitelistCollections = [
            'Weeping Plebs',
            'BaseAliens',
            'No-Punks',
            'based punks',
            'Bario Punks',
            'NoUnkes',
            'HaHa Hyenas',
            'Based Chimpers',
            'Tiny DinoPunks',
            'Based Nakamigos',
        ];

        $caseInsensitive = array_map('strtolower', $whitelistCollections);
        array_multisort($caseInsensitive, SORT_ASC, $whitelistCollections);

        $this->setVariable(new Variable('whitelistCollections', $whitelistCollections));
        $this->setVariable(new Variable('totalWallets', count($wallets)));
        $this->setVariable(new Variable('images', array_slice($imageFileNames, 0, 4)));

        $this->setVariable(new Variable('top25syncedAt', date("Y-m-d H:i", $lastModified)));
        $this->setVariable(new Variable('top25Wallets1EthPrize', $top25Wallets1EthPrize));

        $this->setVariable(new Variable('giveaways', array_reverse($this->getGiveaways())));
    }

    private function getGiveaways(): array
    {
        $giveaways = [];

        $file = ROOT . '/giveaways.csv';
        if (($handle = fopen($file, 'r')) !== false) {
            $i = 0;
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($i > 0) {
                    $giveaways[] = [
                        'post_url' => $data[0],
                        'prize' => $data[1],
                        'winners' => $data[2] ? explode(':', $data[2]) : null,
                    ];
                }

                $i++;
            }

            fclose($handle);
        }

        return $giveaways;
    }
}
