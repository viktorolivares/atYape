<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionController extends Controller
{

    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

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
        $registerDate = $request->register_date;
        $transaction = Str::uuid()->toString();
        $description = $request->description;
        $person = $request->person;
        $amount = $request->amount;
        $message = 'Yape!' . " " . $person . " " . 'te envió un pago por S/' . " " . $amount;

        $data = [
            'register_date' => $registerDate,
            'description' => $description,
            'transaction' => $transaction,
            'message' => $message,
            'person' => $person,
            'amount' => $amount,
            'state' => 'validated',
            'system' => 'Web',
            'created_by' => Auth::id(),
            'updated_by' => Auth::id()
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


        $new_transaction = [
            'id' => $transactions->id,
            'description' => $transactions->description,
            'person' => $transactions->person,
            'amount' => $transactions->amount,
            'register_date' => $transactions->register_date,

        ];

        $logData = [
            'user_id' => Auth::id(),
            'model' => 'Transacciones',
            'action' => 'Crear',
            'ip' => $request->ip(),
            'data' => [
                'new_transaction' => $new_transaction
            ],
        ];

        $this->activityLogService->createLog(
            $logData['user_id'],
            $logData['model'],
            $logData['action'],
            $logData['ip'],
            $logData['data']
        );

        return response()->json([
            'success' => true,
            'transaction' => $transactions,
        ], Response::HTTP_CREATED);
    }

    public function updateState(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $previousState = $transaction->state;

        $transaction->state = $request->state;
        $transaction->updated_by = Auth::id();

        $transaction->save();

        $logData = [
            'user_id' => Auth::id(),
            'model' => 'Transacciones',
            'action' => 'Actualizar',
            'ip' => $request->ip(),
            'data' => [
                'update_transaction' => [
                    'previous_state' => $previousState,
                    'new_state' => $request->state,
                ]
            ],
        ];

        $this->activityLogService->createLog(
            $logData['user_id'],
            $logData['model'],
            $logData['action'],
            $logData['ip'],
            $logData['data']
        );

        return response()->json([
            'success' => true,
            Response::HTTP_CREATED
        ]);
    }

    public function updateDetails(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $oldTransaction = $transaction->toArray();

        if (!empty($request->details)) {

            $transaction->details = $request->details;
            $transaction->updated_by = Auth::id();
            $transaction->save();

            $newTransaction = $transaction->toArray();

            $changes = $this->compareTransactionDetails($oldTransaction, $newTransaction);

            if (!empty($changes)) {
                $logData = [
                    'user_id' => Auth::id(),
                    'model' => 'Transacciones',
                    'action' => 'Actualizar',
                    'ip' => $request->ip(),
                    'data' => [
                        'update_transaction' => [
                            'details' => $request->details,
                        ]
                    ],
                ];

                $this->activityLogService->createLog(
                    $logData['user_id'],
                    $logData['model'],
                    $logData['action'],
                    $logData['ip'],
                    $logData['data']
                );
            }

            return response()->json([
                'success' => true,
                "old" => $oldTransaction,
                "new" => $newTransaction

            ], Response::HTTP_CREATED);
        }
    }

    public function listByDescription($description, Request $request)
    {
        $person = $request->person;
        $state = $request->state;
        $perPage = $request->perPage;
        $sortField = $request->sort_field;
        $sortDirection = $request->sort_direction;

        $startDate = Carbon::now()->subDays(2)->format('Y-m-d H:i:s');
        $endDate = Carbon::now()->format('Y-m-d H:i:s');

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

        dd($transactions);

        return response()->json([
            'success' => true,
            'data' => $transactions,
            Response::HTTP_OK
        ]);
    }

    public function updateTransaction(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $oldTransaction = $transaction->toArray();

        if ($transaction->system === 'APK') {
            return response()->json([
                'success' => false,
                'message' => 'No se puede editar esta transacción',
            ], Response::HTTP_BAD_REQUEST);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'person' => 'required',
            'amount' => 'required|numeric',
            'register_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->messages(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $transaction->description = $request->description;
        $transaction->person = $request->person;
        $transaction->amount = $request->amount;
        $transaction->register_date = $request->register_date;
        $transaction->updated_by = Auth::id();
        $transaction->save();

        $newTransaction = $transaction->toArray();

        $changes = $this->compareTransactionChanges($oldTransaction, $newTransaction);

        if (!empty($changes)) {

            $updateFields = [
                'id' => $transaction->id,
                'description' => $transaction->description,
                'person' => $transaction->person,
                'amount' => $transaction->amount,
                'register_date' => $transaction->register_date,
            ];

            $logData = [
                'user_id' => Auth::id(),
                'model' => 'Transacciones',
                'action' => 'Actualizar',
                'ip' => $request->ip(),
                'data' => [
                    'update_transaction' => [
                        'transaction' => $updateFields
                    ]
                ],
            ];

            $this->activityLogService->createLog(
                $logData['user_id'],
                $logData['model'],
                $logData['action'],
                $logData['ip'],
                $logData['data']
            );
        }

        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ], Response::HTTP_OK);
    }

    public function deleteTransaction(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->system === 'APK') {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar esta transacción',
            ], Response::HTTP_BAD_REQUEST);
        }

        $transaction->delete();

        $logData = [
            'user_id' => Auth::id(),
            'model' => 'Transacciones',
            'action' => 'Eliminar',
            'ip' => $request->ip(),
            'data' => [
                'delete_transaction' => [
                    'transaction' => $id,
                ]
            ],
        ];

        $this->activityLogService->createLog(
            $logData['user_id'],
            $logData['model'],
            $logData['action'],
            $logData['ip'],
            $logData['data']
        );

        return response()->json([
            'success' => true,
            'message' => 'Transacción eliminada correctamente.',
        ], Response::HTTP_OK);
    }

    public function searchPending(Request $request)
    {
        sleep(2);

        try {
            $request->validate([
                'person' => 'required',
                'amount' => 'required|numeric',
                'register_date' => 'required|date',
            ]);

            $date = Carbon::parse($request->register_date);

            $transactions = Transaction::where('state', 'pending')
                ->where('description', $request->description)
                ->where('person', $request->person)
                ->where('amount', $request->amount)
                ->whereDate('register_date', $date)
                ->get();

            return response()->json($transactions);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }
    }

    private function compareTransactionChanges($oldTransaction, $newTransaction)
    {
        $changes = [];

        $updatableFields = ['description', 'person', 'amount', 'register_date'];

        foreach ($newTransaction as $key => $value) {
            if (in_array($key, $updatableFields)) {
                if ($key == 'register_date') {
                    $value = date('Y-m-d H:i:s', strtotime($value));
                    $oldTransaction[$key] = date('Y-m-d H:i:s', strtotime($oldTransaction[$key]));
                }
                if (isset($oldTransaction[$key]) && strval($oldTransaction[$key]) !== strval($value)) {
                    $changes[$key] = [
                        'old' => $oldTransaction[$key],
                        'new' => $value,
                    ];
                }
            }
        }

        return $changes;
    }

    private function compareTransactionDetails($oldTransaction, $newTransaction)
    {
        $changes = [];

        $updatableFields = ['details'];

        foreach ($updatableFields as $field) {
            $oldValue = isset($oldTransaction[$field]) ? strval($oldTransaction[$field]) : null;
            $newValue = isset($newTransaction[$field]) ? strval($newTransaction[$field]) : null;

            if ($oldValue !== $newValue) {
                $changes[$field] = [
                    'old' => $oldValue,
                    'new' => $newValue,
                ];
            }
        }

        return $changes;
    }
}
