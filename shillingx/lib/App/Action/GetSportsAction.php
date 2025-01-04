<?php
namespace App\Action;

use App\Query\DoSportQuery;
use App\Variable;
use Carbon\Carbon;
use Doctrine\DBAL\Driver\Exception;

class GetSportsAction extends BaseAction
{
    /**
     * @throws Exception
     */
    public function run()
    {
        parent::__construct();

        $query = new DoSportQuery();
        $sports = $query->getSports(Carbon::now('America/Curacao'));

        $goalPoints = (int) env('SPORTS_GOAL');
        $doneToday = count($sports);

        $percentageDone = $goalPoints > 0 ? ($doneToday / $goalPoints) * 100 : 0;
        $percentageDone = min(100, round($percentageDone));

        $this->setVariable(new Variable('percentageDone', $percentageDone));
        $this->setVariable(new Variable('exercisesGrouped', $this->groupExercisesByType($sports)));

        $this->setLayout('async');
        $this->setView('async/sports');
    }

    private function groupExercisesByType(array $exercises): array
    {
        $grouped = [];

        foreach ($exercises as $exercise) {
            $type = $exercise['type']; // Get the type of the exercise
            if (isset($grouped[$type])) {
                $grouped[$type]++; // Increment the count if type already exists
            } else {
                $grouped[$type] = 1; // Initialize the count if type is new
            }
        }

        return $grouped;
    }
}
