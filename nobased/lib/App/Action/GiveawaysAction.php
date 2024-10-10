<?php
namespace App\Action;

use App\Variable;

class GiveawaysAction extends BaseAction
{
    public function run()
    {
        parent::__construct();

        $this->setLayout('default');
        $this->setView('website/giveaways');

        $this->setVariable(new Variable('giveaways', array_reverse($this->getGiveaways())));
    }

    private function getGiveaways(): array
    {
        $giveaways = [];

        $file = ROOT . '/giveaways.csv';
        if (($handle = fopen($file, 'r')) !== false) {
            $i = 0;
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($i > 0) {
                    $giveaways[] = [
                        'post_url' => $data[0],
                        'prize' => $data[1],
                        'winners' => $data[2] ? explode(':', $data[2]) : null,
                    ];
                }

                $i++;
            }

            fclose($handle);
        }

        return $giveaways;
    }
}
