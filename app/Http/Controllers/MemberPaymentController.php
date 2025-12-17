<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:member');
    }

    public function create(Loan $loan)
    {
        $this->authorize('view', $loan);
        
        if (!in_array($loan->status, ['active', 'disbursed'])) {
            return redirect()->route('member.loans.show', $loan)
                ->with('error', 'You can only make payments for active loans.');
        }

        return view('member.payments.create', compact('loan'));
    }

    public function store(Request $request, Loan $loan)
    {
        $this->authorize('view', $loan);
        
        // Add payment logic here
        return redirect()->route('member.loans.show', $loan)
            ->with('success', 'Payment recorded successfully!');
    }
}