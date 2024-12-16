<?php
namespace App\Action;

use App\Query\DoShillQuery;
use App\ShillConfig;
use App\Variable;
use Carbon\Carbon;
use Doctrine\DBAL\Driver\Exception;

class GetTasksAction extends BaseAction
{
    /**
     * @throws Exception
     */
    public function run()
    {
        parent::__construct();

        $query = new DoShillQuery();
        $shills = $query->getShills(Carbon::now('America/Curacao'));

        $this->setVariable(new Variable('progress', calculateCompletionPercentages($shills, ShillConfig::get())));
        $this->setVariable(new Variable('remaining', calculateRemainingActions($shills, ShillConfig::get())));

        $this->setLayout('async');
        $this->setView('async/tasks');
    }
}
