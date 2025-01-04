<?php
namespace App\Action;

use App\ProjectsEnum;
use App\Query\DoShillQuery;
use App\TypesEnum;
use Doctrine\DBAL\Driver\Exception;

class DoShillAction extends BaseAction
{
    /**
     * @throws Exception
     */
    public function run()
    {
        parent::__construct();

        $this->setTerminal(true);

        $project = $this->getRequest()->getPostParam('project');
        $action = $this->getRequest()->getPostParam('action');

        $query = new DoShillQuery();
        $query->doShill(ProjectsEnum::from($project), TypesEnum::from($action));


        $response = [
            'success' => true,
        ];
        echo json_encode($response);
        exit;
    }
}
