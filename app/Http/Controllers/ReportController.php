<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {

        $validatedData = $request->validate([
            'state' => 'nullable|string',
            'description' => 'nullable|string',
            'startDate' => 'nullable|date|required_with:endDate',
            'endDate' => 'nullable|date|after_or_equal:startDate|required_with:startDate',
            'person' => 'nullable|string',
            'amountGreater' => 'nullable|numeric|min:0|required_with:amountLess',
            'amountLess' => 'nullable|numeric|min:0|gte:amountGreater|required_with:amountGreater',
            'perPage' => 'required|integer',
            'sortField' => 'nullable|string',
            'sortDirection' => 'nullable|string|in:asc,desc',
        ]);


        $state = $request->state;
        $description = $request->description;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $person = $request->person;
        $amountLess = $request->amountLess;
        $amountGreater = $request->amountGreater;
        $perPage = $request->perPage;
        $sortField = $request->sort_field;
        $sortDirection = $request->sort_direction;

        if (empty($startDate) && empty($endDate)) {
            $startDate = Carbon::now()->subDays(7)->format('Y-m-d H:i:s');
            $endDate = Carbon::now()->format('Y-m-d H:i:s');
        }

        $transactions = Transaction::query()
            ->with('updatedBy')
            ->when($state, function ($query, $state) {
                return $query->where('state', $state);
            })
            ->when($description, function ($query, $description) {
                return $query->where('description', $description);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->when($person, function ($query, $person) {
                return $query->where('person', 'like', '%' . $person . '%');
            })
            ->when($amountLess && $amountGreater, function ($query) use ($amountLess, $amountGreater) {
                return $query->whereBetween('amount', [$amountGreater, $amountLess]);
            })
            ->when($sortField && $sortDirection, function ($query) use ($sortField, $sortDirection) {
                return $query->orderBy($sortField, $sortDirection);
            }, function ($query) {
                return $query->orderBy('created_at', "desc");
            })
            ->paginate($perPage);

        $transactions->map(function ($created) {
            $created->formatted_date = Carbon::parse($created->created_at)->format('d/m/Y H:i:s');
            return $created;
        });

        return response()->json([
            'success' => true,
            'data' => $transactions,
        ], Response::HTTP_OK);
    }

    public function export(Request $request)
    {

        $state = $request->state;
        $description = $request->description;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $person = $request->person;
        $amountLess = $request->amountLess;
        $amountGreater = $request->amountGreater;

        if (empty($startDate) && empty($endDate)) {
            $startDate = Carbon::now()->subDays(7)->format('Y-m-d H:i:s');
            $endDate = Carbon::now()->format('Y-m-d H:i:s');
        }

        $transactions = Transaction::query()
            ->with('updatedBy')
            ->when($state, function ($query, $state) {
                return $query->where('state', $state);
            })
            ->when($description, function ($query, $description) {
                return $query->where('description', $description);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->when($person, function ($query, $person) {
                return $query->where('person', 'like', '%' . $person . '%');
            })
            ->when($amountLess && $amountGreater, function ($query) use ($amountLess, $amountGreater) {
                return $query->whereBetween('amount', [$amountGreater, $amountLess]);
            })
            ->get();

        $transactions->map(function ($created) {
            $created->formatted_date = Carbon::parse($created->created_at)->format('d/m/Y H:i:s');
            return $created;
        });

        return response()->json($transactions);
    }
}
