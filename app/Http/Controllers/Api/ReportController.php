<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Http\Traits\RelationshipTrait;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    use RelationshipTrait;
    private $relations = ['user'];
    public function transaction()
    {
        try {
            $transactions = $this->loadRelationships(Transaction::query());
            $data = TransactionResource::collection($transactions->latest()->get());
            return response()->json(['data' => $data], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
