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

        $query = new DoSportQuery();

        $type = $this->getRequest()->getPostParam('sportType');
        $multiple = (int) $this->getRequest()->getPostParam('multiple');

        if ($multiple) {
            for ($i = 1; $i <= $multiple; $i++) {
                $query->doSport(SportTypesEnum::from($type));
            }
        } else {
            $query->doSport(SportTypesEnum::from($type));
        }

        $response = [
            'success' => true,
        ];
        echo json_encode($response);
        exit;
    }
}
