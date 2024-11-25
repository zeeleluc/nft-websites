<?php
namespace App\Action;

use App\Variable;

class RichlistAction extends BaseAction
{
    public function run()
    {
        parent::__construct();

        $this->setLayout('default');
        $this->setView('website/richlist');

        $richlistWallets = (array) json_decode(file_get_contents(env('WL_COLLECTION_SOURCE')), true);
        $this->setVariable(new Variable('richlistWallets', $richlistWallets));

    }
}
