<?php
namespace App\Query;

use App\ProjectsEnum;
use App\TypesEnum;
use Carbon\Carbon;

class DoShillQuery extends Query
{

    private string $table = 'shills';

    public function doShill(ProjectsEnum $projectsEnum, TypesEnum $typesEnum)
    {
        $values = [
            'date' => Carbon::now('America/Curacao')->format('Y-m-d'),
            'project' => $projectsEnum->value,
            'type' => $typesEnum->value,
        ];

        $result = $this->db->insert($this->table, $values);
        if (!$result) {
            throw new \Exception('Shill not added.');
        }

        return true;
    }

    public function getShills(Carbon $date): array
    {
        return $this->db
            ->where('date', $date->format('Y-m-d'))
            ->get($this->table);
    }
}
