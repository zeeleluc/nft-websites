<?php
namespace App\Action;

use App\Object\BaseObject;
use App\SportTypesEnum;
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

            $htmlTitle = 'Shilling X';

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

    protected function groupExercisesByType(array $exercises, string $sort = 'mostFirst'): array
    {
        $grouped = [];

        foreach ($exercises as $exercise) {

            $sportType = SportTypesEnum::from($exercise['type']);
            $position = strpos($sportType->label(), ':');
            if ($position === false) {
                $subject = 'General';
                $exerciseLabel = $sportType->label();
            } else {
                $subject = substr($sportType->label(), 0, $position);
                $exerciseLabel = substr($sportType->label(), $position + 2);
            }

            if (!array_key_exists($subject, $grouped)) {
                $grouped[$subject] = [];
                $grouped[$subject]['_subject_total'] = 0;
            }

            if (!array_key_exists($exerciseLabel, $grouped[$subject])) {
                $grouped[$subject][$exerciseLabel]['count'] = 0;
                $grouped[$subject][$exerciseLabel]['enum'] = $sportType;
            }

            if (isset($grouped[$subject][$exerciseLabel]['count'])) {
                $grouped[$subject][$exerciseLabel]['count'] = $grouped[$subject][$exerciseLabel]['count'] + (1 * $sportType->multiplier());
                $grouped[$subject]['_subject_total'] = $grouped[$subject]['_subject_total'] + (1 * $sportType->multiplier());
            } else {
                $grouped[$subject][$exerciseLabel]['count'] = 1 * $sportType->multiplier();
                $grouped[$subject]['_subject_total'] = 1 * $sportType->multiplier();
            }
        }

        if ($sort === 'lessFirst') {
            uasort($grouped, function ($a, $b) {
                return $a['_subject_total'] <=> $b['_subject_total'];
            });
        } elseif ($sort === 'mostFirst') {
            uasort($grouped, function ($a, $b) {
                return $b['_subject_total'] <=> $a['_subject_total'];
            });
        }

        foreach ($grouped as $subject => $data) {
            unset($grouped[$subject]['_subject_total']);
        }

        return $grouped;
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
