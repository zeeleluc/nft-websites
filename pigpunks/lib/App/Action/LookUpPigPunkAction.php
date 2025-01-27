<?php
namespace App\Action;

class LookUpPigPunkAction extends BaseAction
{
    public function run()
    {
        parent::__construct();

        $this->setTerminal(true);

        $id = (int) $this->getRequest()->getPostParam('id');

        if ($id >= 1 && $id <= 10000) {
            echo json_encode([
                'success' => true,
                'id' => $id,
                'url' => env('IMAGED_ENDPOINT') . $id . '.png',
                'url_cryptopunk_compare' => env('IMAGES_CRYPTOPUNK_COMPARE_ENDPOINT') . $id . '.png',
                'url_x_banner' => env('IMAGES_X_BANNERS_ENDPOINT') . $id . '.png',
            ]);
        } else {
            echo json_encode([
                'success' => false,
            ]);
        }

        exit;
    }
}
