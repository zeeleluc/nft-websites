<?php
namespace App\Action;

use App\Collection\NFTs;
use App\Query\NFTQuery;
use App\Variable;
use Doctrine\DBAL\Driver\Exception;

class WeepingPlebAction extends BaseAction
{
    /**
     * @throws Exception
     */
    public function run()
    {
        parent::__construct();

        $this->setLayout('default');
        $this->setView('website/weepingpleb');

        $id = (int) $this->getRequest()->getParam('id');
        if (!$id) {
            abort();
        }

        $this->setVariable(new Variable('NFT', (new NFTQuery())->getNFT($id)));
        $this->setVariable(new Variable('randomNFTs', (new NFTs())->getRandom(4)));
    }
}
