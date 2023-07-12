<?php

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionApiController extends Controller
{
    public function saveTransaction(Request $request)
    {
        $key = $request->key;
        $message = $request->message;
        $description = $request->description;

        if (strpos($message, "Yape!") === false || strpos($message, "te envió un pago") === false) {
            return response()->json([
                'success' => false,
                'message' => 'No es un depósito',
            ], Response::HTTP_BAD_REQUEST);
        }

        $person = explode("te", $message)[0];
        $person = trim(str_replace("Yape! ", "", $person));
        $amount_array = explode(" ", $message);
        $amount = end($amount_array);
        $transaction = substr((string) $key, 36) . '|' . $description;

        $person = str_replace('-', ' ', $person);
        $person = preg_replace('/\s+/', ' ', $person);
        $person = trim($person);

        $data = [
            'description' => $description,
            'transaction' => $transaction,
            'message' => $message,
            'person' => $person,
            'amount' => $amount,
            'system' => 'APK',
            'register_date' => now(),
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
            ], Response::HTTP_BAD_REQUEST);
        }

        $transactions = new Transaction();
        $transactions->fill($data);
        $transactions->save();

        return response()->json([
            'success' => true,
            'transaction' => $transactions,
        ], Response::HTTP_CREATED);
    }

    public function listTransactions(Request $request)
    {
        $description = $request->description;

        $transactions = Transaction::orderBy('id', 'desc')
            ->when($description, function ($query, $description) {
                return $query->where('description', $description);
            })
            ->limit(50)
            ->get(['id', 'description', 'person', 'amount', 'state', 'register_date']);

        return response()->json($transactions, Response::HTTP_OK);

    }
}
