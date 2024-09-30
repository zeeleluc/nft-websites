<?php
namespace App\Action;

class CacheTop25HoldersAction extends BaseAction
{
    public function run()
    {
        parent::__construct();

        $this->setTerminal(true);

        $richList = (array) json_decode(file_get_contents(env('WL_COLLECTION_SOURCE')), true);

        $top25 = [];
        foreach (array_slice($richList, 0, 25) as $wallet => $richListData) {
            $top25[] = [
                'wallet' => $wallet,
                'total' => $richListData['total'],
            ];
        }

        $totalInTop25 = array_sum(array_column($top25, 'total'));

        foreach ($top25 as $key => $top25Data) {
            $top25[$key]['percentage'] = number_format(($top25Data['total'] / $totalInTop25) * 100, 6);
            $top25[$key]['eth_share'] = number_format(($top25[$key]['percentage'] / 100), 3);
        }

//        $totalInTop25Percentage = number_format(array_sum(array_column($top25, 'percentage')), 2);
//        $totalEthShare = number_format(array_sum(array_column($top25, 'eth_share')), 2);

        file_put_contents(ROOT . '/top-25-holders-1-eth-share.json', json_encode($top25));
    }
}
