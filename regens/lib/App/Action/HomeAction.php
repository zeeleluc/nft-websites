<?php
namespace App\Action;

use App\Collection\NFTs;
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

        $this->setVariable(new Variable('randomNFTs', (new NFTs())->getRandom(12)));
    }
}
