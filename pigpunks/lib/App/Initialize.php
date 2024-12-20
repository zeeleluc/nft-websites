<?php
namespace App;

use App\Action;
use App\Action\Action as AbstractAction;
use App\Action\BaseAction;
use App\Object\BaseObject;
use App\Object\ObjectManager;

class Initialize extends BaseObject
{
    public function __construct()
    {
        ObjectManager::set(new Request());
        ObjectManager::set(new Session());
        ObjectManager::set(new AbstractAction());
    }

    /**
     * @throws \Exception
     */
    public function action(): Initialize
    {
        $this->getAbstractAction()->setAction($this->resolveAction());
        $this->getAbstractAction()->getAction()->run();

        return $this;
    }

    public function show(): void
    {
        $variables = $this->getAbstractAction()->getAction()->getVariables();

        extract($variables);

        ob_start();
        if (false === $this->getAbstractAction()->getAction()->getTemplate()->isTerminal()) {
            require_once ROOT . DS . 'templates' . DS . 'views' . DS . $this->getAbstractAction()->getAction()->getTemplate()->getView()->getViewName() . '.phtml';
        }
        $content = ob_get_contents();
        ob_end_clean();

        if (false === $this->getAbstractAction()->getAction()->getTemplate()->isTerminal()) {
            ob_start();
            require_once ROOT . DS . 'templates' . DS . 'layouts' . DS . $this->getAbstractAction()->getAction()->getTemplate()->getLayout()->getLayoutName() . '.phtml';
            $html = ob_get_contents();
            ob_end_clean();
        } else {
            $html = $content;
        }

        echo $html;
    }

    /**
     * @return BaseAction
     * @throws \Exception
     */
    private function resolveAction(): BaseAction
    {
        $get = $this->getRequest()->get();

        if (is_cli()) {
            return new Action\CliAction();
        }

        if (false === isset($get['action']) || (true === isset($get['action']) && '' === $get['action'])) {
            return new Action\HomeAction();
        }

        if ($get['action'] === 'lookup-whitelist') {
            return new Action\LookUpWhiteListAction();
        }

        if ($get['action'] === 'lookup-nobased') {
            return new Action\LookUpPigPunkAction();
        }

        if ($get['action'] === 'cache-whitelist') {
            return new Action\CacheWhiteListAction();
        }

        if ($get['action'] === 'richlist') {
            return new Action\RichlistAction();
        }

        if ($get['action'] === 'community') {
            return new Action\CommunityAction();
        }

        if ($get['action'] === 'lookup') {
            return new Action\LookupAction();
        }

        throw new \Exception('Page not found.');
    }
}
