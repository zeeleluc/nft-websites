<?php
namespace App\Action;

class LookUpWhiteListAction extends BaseAction
{
    public function run()
    {
        parent::__construct();

        $this->setTerminal(true);

        sleep(1);

        $wallet = $this->getRequest()->getPostParam('wallet');
        if (!$wallet) {
            echo json_encode([
                'success' => false,
                'message' => 'Missing wallet address',
            ]);
            exit;
        }

        $wallet = strtolower($wallet);
        if (!preg_match('/^0x[a-fA-F0-9]{40}$/', $wallet)) {
            echo json_encode([
                'success' => false,
                'message' => 'Not a valid wallet',
            ]);
            exit;
        }

        $jsonFile = ROOT . '/wallets-wl-nobased.json';
        $wallets = (array) json_decode(file_get_contents($jsonFile), true);
        $wallets = array_map('strtolower', $wallets);

        $walletOnWhitelist = in_array($wallet, $wallets);
        echo json_encode([
            'success' => $walletOnWhitelist,
            'wallet' => $wallet,
            'message' => !$walletOnWhitelist ? 'This wallet is not based enough' : 'This wallet is based-af',
        ]);
        exit;
    }
}
