<?php
namespace App\Action;

use App\ProjectsEnum;
use App\Query\DoShillQuery;
use App\ShillConfig;
use App\ShillConfigBuilder;
use App\TypesEnum;
use App\Variable;
use Carbon\Carbon;
use Doctrine\DBAL\Driver\Exception;

class HomeAction extends BaseAction
{
    /**
     * @throws Exception
     */
    public function run()
    {
        parent::__construct();

        $query = new DoShillQuery();
        $shills = $query->getShills(Carbon::now('America/Curacao'));

//        $query->doShill(ProjectsEnum::HASMINTS, TypesEnum::GM);
//        $query->doShill(ProjectsEnum::NOBASED, TypesEnum::GM);
//        $query->doShill(ProjectsEnum::LOONEYLUKE, TypesEnum::GM);
//        $query->doShill(ProjectsEnum::LOONEYLUKE, TypesEnum::GM);
//        $query->doShill(ProjectsEnum::NOBASED, TypesEnum::LEFT_OR_RIGHT);
//        $query->doShill(ProjectsEnum::HASMINTS, TypesEnum::QUESTION_WITHOUT_IMAGE);

//        var_dump($shills);
//        var_dump(ShillConfig::get());

        $this->setVariable(new Variable('progress', calculateCompletionPercentages($shills, ShillConfig::get())));
        $this->setVariable(new Variable('remaining', calculateRemainingActions($shills, ShillConfig::get())));

        $this->setLayout('default');
        $this->setView('website/home');
    }
}
