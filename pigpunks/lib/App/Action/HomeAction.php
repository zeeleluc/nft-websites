<?php
namespace App\Action;

use App\Variable;
use Doctrine\DBAL\Driver\Exception;

class HomeAction extends BaseAction
{
    /**
     * @throws Exception
     */
    public function run()
    {
        parent::__construct();

        $this->setLayout('default');
        $this->setView('website/home');

        $images = range(1, 26);
        shuffle($images);
        $this->setVariable(new Variable('images', array_slice($images, 0, 16)));
    }
}
