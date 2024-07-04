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

        $filteredNFTs = (new NFTs())->getFiltered($filters);
        $totalFilteredNFTs = count($filteredNFTs);

        shuffle($filteredNFTs);
        $filteredNFTs = array_slice($filteredNFTs, 0, env('FILTER_LIMIT'));

        $this->setVariable(new Variable('totalFilteredNFTs', $totalFilteredNFTs));
        $this->setVariable(new Variable('filteredNFTs', $filteredNFTs));
        $this->setVariable(new Variable('currentFilter', $this->getRequest()->get()['filter']));
    }
}
