<?php
namespace App\Action;

use App\Query\DoSportQuery;
use App\SportTypesEnum;
use App\Variable;
use Carbon\Carbon;
use Doctrine\DBAL\Driver\Exception;

class SportAction extends BaseAction
{
    /**
     * @throws Exception
     */
    public function run()
    {
        parent::__construct();

        $this->setLayout('default');
        $this->setView('website/sport');
        $this->setVariable(new Variable('htmlTitle', 'Sport'));

        $query = new DoSportQuery();
        $sports = $query->getAllSports();

        $yearExercisesGrouped = $this->groupExercisesByType($sports, 'lessFirst');

        $goalPoints = (int) env('SPORTS_GOAL');

        $yearGoalPoints = $goalPoints * 365;
        $doneThisYear = count($sports);

        $percentageYearDone = $goalPoints > 0 ? ($doneThisYear / $yearGoalPoints) * 100 : 0;
        $percentageYearDone = min(100, $percentageYearDone);

        // should have done this year
        $currentDayOfYear = date('z') + 1;
        $shouldHaveDoneThisYear = $currentDayOfYear * $goalPoints;
        $missingPointsThisYear = $shouldHaveDoneThisYear - $doneThisYear;
        $missingPointsThisYear = max(0, $missingPointsThisYear);

        $percentageYearMissing = $goalPoints > 0 ? ($missingPointsThisYear / $yearGoalPoints) * 100 : 0;
        $percentageYearMissing = min(100, $percentageYearMissing);

        $this->setVariable(new Variable('yearExercisesGrouped', $yearExercisesGrouped));
        $this->setVariable(new Variable('progress', $sports));
        $this->setVariable(new Variable('sportTypes', $this->translateSportsPerSubject(SportTypesEnum::cases())));
        $this->setVariable(new Variable('missingPointsThisYear', $missingPointsThisYear));
        $this->setVariable(new Variable('percentageYearDone', $percentageYearDone));
        $this->setVariable(new Variable('percentageYearMissing', $percentageYearMissing));


    }

    private function translateSportsPerSubject(array $sportTypes)
    {
        $sportsPerSubject = [];

        foreach ($sportTypes as $sportType) {
            $position = strpos($sportType->label(), ':');
            if ($position === false) {
                $subject = 'General';
                $exercise = $sportType->label();
            } else {
                $subject = substr($sportType->label(), 0, $position);
                $exercise = substr($sportType->label(), $position + 1);
            }

            $sportsPerSubject[$subject][] = [
                'enum' => $sportType,
                'clean' => $exercise,
            ];
        }

        return $sportsPerSubject;
    }
}
