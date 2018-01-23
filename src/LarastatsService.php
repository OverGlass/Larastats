<?php

namespace Bigsnowfr\Larastats;

/**
 * Class LarastatsService
 * @package Bigsnowfr\Larastats
 */
class LarastatsService
{

    /**
     * @param object $model
     * @param string $start
     * @param string $end
     * @param string $type
     *
     * @return mixed
     */
    public static function getStatByDate(object $model, string $start, string $end, string $type = 'graph')
    {
        $start = $start ? Carbon::parse($start) : Carbon::now()->subWeek();
        $end   = $end ? Carbon::parse($end) : Carbon::now();

        if ($type === 'count') {
            return $model::whereBetween('created_at', [$start, $end])->count();
        } else {
            return $model::whereBetween('created_at', [$start, $end])->groupBy('x')->orderBy('x', 'DESC')->get([
              DB::raw('Date(created_at) as x'),
              DB::raw('COUNT(*) as y')
            ]);
        }
    }
}