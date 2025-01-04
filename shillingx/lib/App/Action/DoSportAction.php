<?php
namespace App\Action;

use App\Query\DoSportQuery;
use App\SportTypesEnum;
use Doctrine\DBAL\Driver\Exception;

class DoSportAction extends BaseAction
{
    /**
     * @throws Exception
     */
    public function run()
    {
        parent::__construct();

        $this->setTerminal(true);

        $type = $this->getRequest()->getPostParam('sportType');

        $query = new DoSportQuery();
        $query->doSport(SportTypesEnum::from($type));

        $response = [
            'success' => true,
        ];
        echo json_encode($response);
        exit;
    }
}
