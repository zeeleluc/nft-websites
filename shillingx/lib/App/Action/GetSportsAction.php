<?php
namespace App\Action;

use App\Query\DoSportQuery;
use App\SportTypesEnum;
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
        $allSports = $query->getAllSports();

        $goalPoints = (int) env('SPORTS_GOAL');
        $doneToday = count($sports);

        $yearGoalPoints = $goalPoints * 365;
        $doneThisYear = count($allSports);

        $percentageDone = $goalPoints > 0 ? ($doneToday / $goalPoints) * 100 : 0;
        $percentageDone = min(100, round($percentageDone));

        $percentageYearDone = $goalPoints > 0 ? ($doneThisYear / $yearGoalPoints) * 100 : 0;
        $percentageYearDone = min(100, $percentageYearDone);

        // should have done this year
        $currentDayOfYear = date('z') + 1;
        $shouldHaveDoneThisYear = $currentDayOfYear * $goalPoints;
        $missingPointsThisYear = $shouldHaveDoneThisYear - $doneThisYear;
        $missingPointsThisYear = max(0, $missingPointsThisYear);

        $percentageYearMissing = $goalPoints > 0 ? ($missingPointsThisYear / $yearGoalPoints) * 100 : 0;
        $percentageYearMissing = min(100, $percentageYearMissing);

        $this->setVariable(new Variable('missingPointsThisYear', $missingPointsThisYear));
        $this->setVariable(new Variable('percentageDone', $percentageDone));
        $this->setVariable(new Variable('percentageYearDone', $percentageYearDone));
        $this->setVariable(new Variable('percentageYearMissing', $percentageYearMissing));
        $this->setVariable(new Variable('exercisesGrouped', $this->groupExercisesByType($sports)));

        $this->setLayout('async');
        $this->setView('async/sports');
    }

    private function groupExercisesByType(array $exercises): array
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
                $exerciseLabel = substr($sportType->label(), $position + 1);
            }

            if (!array_key_exists($subject, $grouped)) {
                $grouped[$subject] = [];
            }

            if (!array_key_exists($exerciseLabel, $grouped[$subject])) {
                $grouped[$subject][$exerciseLabel]['count'] = 0;
                $grouped[$subject][$exerciseLabel]['enum'] = $sportType;
            }

            if (isset($grouped[$subject][$exerciseLabel]['count'])) {
                $grouped[$subject][$exerciseLabel]['count'] = $grouped[$subject][$exerciseLabel]['count'] + (1 * $sportType->multiplier());
            } else {
                $grouped[$subject][$exerciseLabel]['count'] = 1 * $sportType->multiplier();
            }
        }

        return $grouped;
    }
}
