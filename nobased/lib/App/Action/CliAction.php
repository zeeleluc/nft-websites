<?php
namespace App\Action;

class CliAction extends BaseAction
{

    private string $action;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->terminal = true;
        parent::__construct();

        if (!$_SERVER['argv']) {
            exit;
        }

        if (!isset($_SERVER['argv'][1])) {
            exit;
        }

        $this->action = $_SERVER['argv'][1];

        if ($this->action === 'cache-wl-data') {
            $action = new CacheWhiteListAction();
            $action->run();
        }

        if ($this->action === 'cache-wl-data') {
            $action = new CacheWhiteListAction();
            $action->run();
        }

        if ($this->action === 'cache-top-25-holders-1-eth-prize') {
            $action = new CacheTop25HoldersAction();
            $action->run();
        }

        exit;
    }
}
