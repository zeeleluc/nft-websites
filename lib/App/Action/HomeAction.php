<?php
namespace App\Action;

class HomeAction extends BaseAction
{
    public function run()
    {
        parent::__construct('');

        $this->setLayout('default');
        $this->setView('website/home');
    }
}
