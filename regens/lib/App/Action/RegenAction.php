<?php
namespace App\Action;

use App\Collection\NFTs;
use App\Query\NFTQuery;
use App\Variable;
use Doctrine\DBAL\Driver\Exception;

class RegenAction extends BaseAction
{
    /**
     * @throws Exception
     */
    public function run()
    {
        parent::__construct();

        $this->setLayout('default');
        $this->setView('website/regen');

        $id = (int) $this->getRequest()->getParam('id');
        if (!$id) {
            abort();
        }

        if ($id > 6666 || $id < 1) {
            abort();
        }

        if ($id <= 1) {
            $previous = null;
        } else {
            $previous = $id - 1;
        }

        if ($id >= 6666) {
            $next = null;
        } else {
            $next = $id + 1;
        }

        $this->setVariable(new Variable('previous', $previous));
        $this->setVariable(new Variable('next', $next));
        $this->setVariable(new Variable('NFT', (new NFTQuery())->getNFT($id)));
        $this->setVariable(new Variable('randomNFTs', (new NFTs())->getRandom(3)));
    }
}
