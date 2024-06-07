<?php
namespace App\Action;

use App\Collection\NFTs;
use App\Service\Filter;
use App\Variable;
use Doctrine\DBAL\Driver\Exception;

class FilterAction extends BaseAction
{
    /**
     * @throws Exception
     */
    public function run()
    {
        parent::__construct();

        $this->setLayout('default');
        $this->setView('website/filter');

        $filter = $this->getRequest()->getParam('filter');
        if (!$filter) {
            abort();
        }

        $filters = Filter::parse($filter);
        if (!Filter::validate($filters)) {
            abort();
        }

        $this->setVariable(new Variable('filteredNFTs', (new NFTs())->getFiltered($filters)));
        $this->setVariable(new Variable('currentFilter', $this->getRequest()->get()['filter']));
    }
}
