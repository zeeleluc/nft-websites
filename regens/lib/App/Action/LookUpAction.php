<?php
namespace App\Action;

class LookUpAction extends BaseAction
{
    public function run()
    {
        parent::__construct();

        $id = (int) $this->getRequest()->getPostParam('regensid');

        if ($id >= 1 && $id <= 6666) {
            header('Location:' . env('APP_ORIGIN_URL') . '/regen/' . $id);
            exit;
        } else {
            abort();
        }
    }
}
