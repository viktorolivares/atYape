<?php

namespace App\Http\Controllers;



use Symfony\Component\HttpFoundation\Response;
use App\Http\Services\Github;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Carbon\Carbon;

class LogsController extends Controller
{

    public function index(Request $request)
    {

        $model = $request->model;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $perPage = $request->perPage;
        $sortField = $request->sort_field;
        $sortDirection = $request->sort_direction;

        if (empty($startDate) && empty($endDate)) {
            $startDate = Carbon::now()->subDays(1)->format('Y-m-d H:i:s');
            $endDate = Carbon::now()->format('Y-m-d H:i:s');
        }

        $logs = ActivityLog::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when($model, function ($query, $model) {
                return $query->where('model', 'like', '%' . $model . '%');
            })
            ->when($sortField && $sortDirection, function ($query) use ($sortField, $sortDirection) {
                return $query->orderBy($sortField, $sortDirection);
            }, function ($query) {
                return $query->orderBy('created_at', "desc");
            })
            ->paginate($perPage);


        $logs->map(function ($created) {
            $created->formatted_date = Carbon::parse($created->created_at)->format('d/m/Y H:i:s');
            return $created;
        });

        return response()->json(
            [
                'success' => true,
                'data' => $logs,
            ],
            Response::HTTP_OK
        );
    }

    public function github()
    {
        $languages = Github::getLanguages();
        $changes = Github::getLatestChanges();

        return response()->json([
            'languages' => $languages,
            'changes' => $changes
        ]);
    }
}
