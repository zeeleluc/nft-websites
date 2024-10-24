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
        } elseif ($get['action'] === 'filter') {
            return new Action\FilterAction();
        } elseif ($get['action'] === 'regen') {
            return new Action\RegenAction();
        }

        throw new \Exception('Page not found.');
    }
}
