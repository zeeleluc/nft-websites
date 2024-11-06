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

        $page = (int) $this->getRequest()->getParam('page');
        if ($page === 0) {
            $offset = 0;
            $page = 1;
        } elseif ($page === 1) {
            $offset = 0;
        } else {
            $offset = (($page - 1) * env('FILTER_LIMIT'));
        }

        $filteredNFTs = (new NFTs())->getFiltered($filters, $offset);
        $totalFilteredNFTs = (new NFTs())->countFiltered($filters);
        $totalPages = round($totalFilteredNFTs / env('FILTER_LIMIT')) + 1;

        if (count($filteredNFTs) === 0) {
            abort();
        }

        $this->setVariable(new Variable('totalPages', $totalPages));
        $this->setVariable(new Variable('currentPage', $page));
        $this->setVariable(new Variable('totalFilteredNFTs', $totalFilteredNFTs));
        $this->setVariable(new Variable('filteredNFTs', $filteredNFTs));
        $this->setVariable(new Variable('currentFilter', $this->getRequest()->get()['filter']));
    }
}
