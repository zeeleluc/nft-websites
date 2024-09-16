<?php
namespace App\Action;

class CacheWhiteListAction extends BaseAction
{
    public function run()
    {
        parent::__construct();

        $this->setTerminal(true);

        $whiteListSource = (array) json_decode(file_get_contents(env('WL_SOURCE')), true);
        $whiteListSourceBaseAliens = (array) json_decode(file_get_contents(env('WL_SOURCE_BASE_ALIENS')), true);
        $whiteListSourceWeepingPlebs = (array) json_decode(file_get_contents(env('WL_SOURCE_WEEPING_PLEBS')), true);

        $wallets = array_keys($whiteListSource);
        $wallets = array_merge(
            $wallets,
            array_keys($whiteListSourceBaseAliens),
            array_keys($whiteListSourceWeepingPlebs)
        );
        $wallets = array_unique($wallets);

        file_put_contents('wallets-wl-nobased.json', json_encode($wallets));

        $csv = '';
        foreach ($wallets as $wallet) {
            $csv .= $wallet . PHP_EOL;
        }
        file_put_contents('wallets-wl-nobased.csv', $csv);

        $csv = '';
        foreach ($wallets as $wallet) {
            $csv .= $wallet . ',1' . PHP_EOL;
        }
        file_put_contents('wallets-wl-nobased-opensea.csv', $csv);
    }
}
