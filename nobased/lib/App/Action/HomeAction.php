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
    }
}
