<?php

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Events\NewTransactionSaved;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $description = $request->description;
        $person = $request->person;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $state = $request->state;
        $perPage = $request->perPage;
        $sortField = $request->sort_field;
        $sortDirection = $request->sort_direction;

        if (empty($startDate) && empty($endDate)) {
           $startDate = Carbon::now()->subDays(7)->format('Y-m-d H:i:s');
           $endDate = Carbon::now()->format('Y-m-d H:i:s');
        }

        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->when($description, function ($query, $description) {
                return $query->where('description', 'like', '%' . $description . '%');
            })
            ->when($person, function ($query, $person) {
                return $query->where('person', 'like', '%' . $person . '%');
            })
            ->when($state, function ($query, $state) {
                return $query->where('state', $state);
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
            Response::HTTP_OK
        ]);
    }

    public function saveTransaction(Request $request)
    {
        $key = $request->key;
        $message = $request->message;
        $description = $request->description;

        $person = explode("te", $message)[0];
        $person = trim(str_replace("Yape! ", "", $person));
        $amount_array = explode(" ", $message);
        $amount = end($amount_array);
        $uuid = Str::uuid()->toString();
        $transaction = substr((string) $key, 36) . '|' . $uuid;


        $data = [
            'description' => $description,
            'transaction' => $transaction,
            'message' => $message,
            'person' => $person,
            'amount' => $amount,
            'created_by' => 1,
            'updated_by' => 1
        ];

        $rules = [
            'description' => 'required',
            'transaction' => 'required|unique:transactions,transaction',
            'message' => 'required',
            'person' => 'required',
            'amount' => 'required|numeric',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->messages(),
                $data
            ], Response::HTTP_BAD_REQUEST);
        }

        $transactions = new Transaction();
        $transactions->fill($data);
        $transactions->save();

        // Fire the event when a new transaction is saved
        event(new NewTransactionSaved($transactions));

        return response()->json([
            'success' => true,
            'transaction' => $transactions,
        ], Response::HTTP_CREATED);
    }

    public function updateState(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->state = $request->state;
        $transaction->updated_by = $request->id;

        $transaction->save();

        return response()->json([
            'success' => true,
            Response::HTTP_CREATED
        ]);
    }

    public function updateDetails(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->details = $request->details;
        $transaction->updated_by = $request->id;
        $transaction->save();

        return response()->json([
            'success' => true,
            Response::HTTP_CREATED
        ]);
    }

    public function listByDescription($description, Request $request)
    {
        $person = $request->person;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $state = $request->state;
        $perPage = $request->perPage;
        $sortField = $request->sort_field;
        $sortDirection = $request->sort_direction;

        if (empty($startDate) && empty($endDate)) {
           $startDate = Carbon::now()->subDays(7)->format('Y-m-d H:i:s');
           $endDate = Carbon::now()->format('Y-m-d H:i:s');
        }

        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->when($description, function ($query, $description) {
                return $query->where('description', $description);
            })
            ->when($person, function ($query, $person) {
                return $query->where('person', 'like', '%' . $person . '%');
            })
            ->when($state, function ($query, $state) {
                return $query->where('state', $state);
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
            Response::HTTP_OK
        ]);
    }
}
