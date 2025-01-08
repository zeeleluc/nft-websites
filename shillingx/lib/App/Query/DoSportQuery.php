<?php
namespace App\Query;

use App\SportTypesEnum;
use Carbon\Carbon;

class DoSportQuery extends Query
{

    private string $table = 'sports';

    public function doSport(SportTypesEnum $sportTypesEnum)
    {
        $values = [
            'date' => Carbon::now('America/Curacao')->format('Y-m-d'),
            'type' => $sportTypesEnum->value,
        ];

        $result = $this->db->insert($this->table, $values);
        if (!$result) {
            throw new \Exception('Sport not added.');
        }

        return true;
    }

    public function getSports(Carbon $date): array
    {
        return $this->db
            ->where('date', $date->format('Y-m-d'))
            ->get($this->table);
    }

    public function getAllSports(): array
    {
        return $this->db
            ->get($this->table);
    }
}
