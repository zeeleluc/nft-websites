<?php
namespace App\Action;

class CacheWhiteListAction extends BaseAction
{
    public function run()
    {
        parent::__construct();

        $this->setTerminal(true);

        $whiteListSource = (array) json_decode(file_get_contents(env('WL_SOURCE')), true);

        $wallets = array_keys($whiteListSource);

        file_put_contents(ROOT . '/wallets-wl-pigpunks.json', json_encode($wallets));

        $csv = 'wallet' . PHP_EOL;
        foreach ($wallets as $wallet) {
            $csv .= $wallet . PHP_EOL;
        }
        file_put_contents(ROOT . '/wallets-wl-pigpunks.csv', $csv);

        $csv = 'wallet,mints' . PHP_EOL;
        foreach ($wallets as $wallet) {
            $csv .= $wallet . ',1' . PHP_EOL;
        }
        file_put_contents(ROOT . '/wallets-wl-pigpunks-opensea.csv', $csv);
    }
}
