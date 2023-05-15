<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use DB;


class DashboardController extends Controller
{
    public function getDataForSelectedDate(Request $request)
    {
        $date = Carbon::parse($request->date);
        $dayBefore = $date->copy()->subDay();

        $dataForSelectedDate = $this->getTransactionDataForDate($date);
        $dataForDayBefore = $this->getTransactionDataForDate($dayBefore);

        $ratio = $this->calculateRatio($dataForSelectedDate, $dataForDayBefore);

        return response()->json([
            'data' => $dataForSelectedDate,
            'ratio' => $ratio,
        ]);
    }

    private function getTransactionDataForDate($date)
    {
        return Transaction::whereDate('created_at', $date)
            ->groupBy('description')
            ->selectRaw('description, SUM(amount) as total')
            ->get();
    }

    private function calculateRatio($dataForSelectedDate, $dataForDayBefore)
    {
        $ratios = [];

        foreach ($dataForSelectedDate as $selectedDateData) {
            $description = $selectedDateData->description;
            $selectedDateTotal = $selectedDateData->total;
            $dayBeforeTotal = 0;

            foreach ($dataForDayBefore as $dayBeforeData) {
                if ($dayBeforeData->description === $description) {
                    $dayBeforeTotal = $dayBeforeData->total;
                    break;
                }
            }

            if ($dayBeforeTotal > 0) {
                $ratio = (($selectedDateTotal - $dayBeforeTotal) / $dayBeforeTotal) * 100;
            } else {
                $ratio = $selectedDateTotal > 0 ? 100 : 0;
            }

            $ratios[$description] = round($ratio, 2);
        }

        return $ratios;
    }

    public function getChartData()
    {
        $today = Carbon::now();
        $thirtyDaysAgo = $today->copy()->subDays(30);

        $data = Transaction::select('description', DB::raw('SUM(amount) as total'))
            ->whereBetween('created_at', [$thirtyDaysAgo, $today])
            ->groupBy('description')
            ->orderBy('total', 'desc')
            ->get();

        return response()->json($data);


    }

    public function getTop10()
    {
        $data = Transaction::select('person', DB::raw('SUM(amount) as total'))
            ->whereMonth('created_at', now()->month)
            ->groupBy('person')
            ->orderByDesc('total')
            ->take(10)
            ->get()
            ->toArray();

        return $data;
    }

    public function getSalesByDay()
    {

        $sales = Transaction::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
                    ->groupBy('date')
                    ->orderByDesc('date')
                    ->take(15)
                    ->get();

        return $sales;

    }
}
