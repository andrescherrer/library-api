<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loan\IndexLoanRequest;
use App\Http\Requests\Loan\StoreLoanRequest;
use App\Http\Requests\Loan\UpdateLoanRequest;
use App\Http\Resources\LoanCollection;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class LoanController extends Controller
{
    public function index(IndexLoanRequest $request)
    {
        $loans = $this->filter($request);

        return new LoanCollection($loans);
    }

    public function store(StoreLoanRequest $request): JsonResponse
    {
        Loan::create([
            'user_id' => $request->get('user_id'),
            'book_id' => $request->get('book_id'),
            'loan_date' => $request->get('loan_date'),
            'return_date' => $request->get('return_date'),
        ]);

        return response()->json(status: JsonResponse::HTTP_CREATED);
    }

    public function show(Loan $loan)
    {
        $loan = $loan->load(['user', 'book']);

        return new LoanResource($loan);
    }

    private function filter($request)
    {
        return Loan::whereHas('book', function(Builder $query) use ($request) {
            if ($request->title)
                $query->where('title', 'LIKE', "%" . $request->title . "%");

        })->whereHas('user', function(Builder $query) use ($request) {
            if ($request->name)
                $query->where('name', 'LIKE', "%" . $request->name . "%");
            
        })
        ->orderBy('loan_date', 'DESC')
        ->paginate();
    }
}
