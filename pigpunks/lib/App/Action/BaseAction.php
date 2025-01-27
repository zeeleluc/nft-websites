<?php
namespace App\Action;

use App\Object\BaseObject;
use App\Template\Template;
use App\Variable;

abstract class BaseAction extends BaseObject
{
    protected bool $terminal = false;

    private array $variables = [];

    private Template $template;

    public function __construct()
    {
        if ($this->terminal) {
            if (!is_cli()) {
                exit;
            }
        } else {

            $htmlTitle = 'PigPunks - pigs with an attitude';

            $this->setVariable(new Variable('htmlTitle', $htmlTitle));
            $this->template = new Template();

            $this->setVariable(new Variable('alert', $this->getSession()->getItem('alert')));

            if (array_key_exists('action', $this->getRequest()->get())) {
                $this->setVariable(new Variable('currentAction', $this->getRequest()->get()['action']));
            } else {
                $this->setVariable(new Variable('currentAction', null));
            }
        }
    }

    public function setVariable(Variable $variable): void
    {
        $this->variables[$variable->getName()] = $variable;
    }

    public function getVariables(): array
    {
        $variables = [];
        foreach ($this->variables as $variable) { /* @var $variable Variable */
            $variables[$variable->getName()] = $variable->getValue();
        }
        return $variables;
    }

    public function getVariable($variableName): mixed
    {
        if (false === array_key_exists($variableName, $this->getVariables())) {
            throw new \Exception(sprintf('Variable %s does not exists.', $variableName));
        }

        return $this->getVariables()[$variableName];
    }

    /**
     * @throws \Exception
     */
    public function setLayout(string $layoutName): void
    {
        $this->getTemplate()->setLayout($layoutName);
    }

    /**
     * @throws \Exception
     */
    public function setView(string $viewName): void
    {
        $this->getTemplate()->setView($viewName);
    }

    public function getTemplate(): Template
    {
        return $this->template;
    }

    public function setTerminal(bool $terminal): void
    {
        $this->getTemplate()->setTerminal($terminal);
    }
}
