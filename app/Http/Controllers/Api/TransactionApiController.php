<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Events\NewTransactionSaved;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Transaction;

class TransactionApiController extends Controller
{
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
        // event(new NewTransactionSaved($transactions));

        return response()->json([
            'success' => true,
            'transaction' => $transactions,
        ], Response::HTTP_CREATED);
    }
}
