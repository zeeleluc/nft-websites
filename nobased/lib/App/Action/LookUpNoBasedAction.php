<?php
namespace App\Action;

class LookUpNoBasedAction extends BaseAction
{
    public function run()
    {
        parent::__construct();

        $this->setTerminal(true);

        $id = (int) $this->getRequest()->getPostParam('id');

        if ($id >= 0 && $id <= 9999) {
            echo json_encode([
                'success' => true,
                'id' => $id,
                'url' => env('IMAGED_ENDPOINT') . $id . '.png',
            ]);
        } else {
            echo json_encode([
                'success' => false,
            ]);
        }

        exit;
    }
}
