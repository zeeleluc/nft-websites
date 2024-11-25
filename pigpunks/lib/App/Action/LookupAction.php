<?php
namespace App\Action;

class LookupAction extends BaseAction
{
    public function run()
    {
        parent::__construct();

        $this->setLayout('default');
        $this->setView('website/lookup');
    }
}
