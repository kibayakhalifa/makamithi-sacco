# Loan Eligibility Display Transformation

## Overview

Transformed the loan eligibility display from showing just the theoretical maximum (savings × 1.5) to showing three clear figures that demonstrate the actual available borrowing amount after accounting for existing loans.

## Key Changes

### 1. Backend - MemberLoanController.php

#### New Helper Method: `calculateAvailableEligibility()`

```php
private function calculateAvailableEligibility($user)
{
    $totalEligibility = $user->loan_eligibility;

    // Calculate current active loan balance
    $currentLoanBalance = $user->loans()
        ->whereIn('status', ['active', 'disbursed', 'approved'])
        ->sum('remaining_balance');

    // Available eligibility = total eligibility minus current loans
    $availableEligibility = max(0, $totalEligibility - $currentLoanBalance);

    return [
        'total_eligibility' => $totalEligibility,
        'current_loan_balance' => $currentLoanBalance,
        'available_eligibility' => $availableEligibility,
    ];
}
```

This method returns three values:

-   **total_eligibility**: Calculated as savings × 1.5 (theoretical maximum)
-   **current_loan_balance**: Sum of all active loan remaining balances
-   **available_eligibility**: What members can actually borrow (total - current)

#### Updated Methods

All loan-related methods now use `calculateAvailableEligibility()`:

-   `index()` - Display loans dashboard
-   `create()` - Show loan application form
-   `store()` - Process loan application with validation using available amount
-   `topup()` - Show top-up form
-   `storeTopup()` - Process top-up application

### 2. Frontend - member.loans.index View

#### New Eligibility Cards (3 cards replacing 1)

1. **Total Eligibility Card** (Blue)

    - Shows: KES [total_eligibility]
    - Label: "Based on your savings × 1.5"

2. **Current Loan Balance Card** (Amber)

    - Shows: KES [current_loan_balance]
    - Label: "Active loans remaining balance"

3. **Available to Borrow Card** (Green)
    - Shows: KES [available_eligibility]
    - Label: "Total eligibility minus current loans"

#### New Eligibility Breakdown Card

Added a detailed breakdown showing the calculation:

```
Savings Balance × 1.5 = Total Eligibility
Total Eligibility - Current Loans = Available to Borrow
```

### 3. Frontend - member.loans.apply View

#### Updated Header Section

-   Changed from displaying only "Your Loan Eligibility" with total amount
-   Now displays: "You can borrow now: KES [available_eligibility] of KES [total_eligibility] total eligibility"

#### New Eligibility Breakdown Card in Sidebar

Added a prominent card showing:

-   Total Eligibility
-   Current Loans (as deduction)
-   Available Now (result)

With explanation: "Your available funds = (Savings × 1.5) − Current loan balance"

#### Updated Form Validation

-   Loan amount input `max` attribute now uses `$available_eligibility`
-   Maximum allowed amount displayed to user reflects what they can actually borrow
-   Error messages reference available amount instead of total eligibility

## Business Logic Impact

### Before

-   Members saw only total eligibility (savings × 1.5)
-   Could be confused about real borrowing capacity if they had existing loans
-   System still enforced the rule but wasn't transparent in UI

### After

-   Members see three clear figures showing the math
-   Visual demonstration that existing loans reduce borrowing capacity
-   Transparency prevents application rejections due to misunderstanding
-   Available amount is the actual maximum they can apply for

## Examples

### Scenario 1: New Member (No Loans)

-   Savings: KES 100,000
-   Total Eligibility: KES 150,000
-   Current Loans: KES 0
-   **Available to Borrow: KES 150,000** ✓

### Scenario 2: Member with Active Loan

-   Savings: KES 100,000
-   Total Eligibility: KES 150,000
-   Current Loan Balance: KES 80,000
-   **Available to Borrow: KES 70,000** (can apply for max KES 70,000)

### Scenario 3: Member Near Limit

-   Savings: KES 100,000
-   Total Eligibility: KES 150,000
-   Current Loan Balance: KES 145,000
-   **Available to Borrow: KES 5,000** (can only apply for small top-up)

## Files Modified

1. **app/Http/Controllers/MemberLoanController.php**

    - Added `calculateAvailableEligibility()` helper method
    - Updated `index()` method
    - Updated `create()` method
    - Updated `store()` method
    - Updated `topup()` method
    - Updated `storeTopup()` method

2. **resources/views/member/loans/index.blade.php**

    - Replaced single eligibility card with three cards
    - Added eligibility breakdown card showing calculation

3. **resources/views/member/loans/apply.blade.php**
    - Updated header to show "You can borrow now" amount
    - Added eligibility breakdown card to sidebar
    - Updated form max value to use available amount
    - Updated help text to reference available amount

## Benefits

✅ **Transparency**: Members understand exactly how their borrowing capacity is calculated
✅ **Clarity**: Three figures make the math visible (Total - Current = Available)
✅ **Prevents Confusion**: No surprises during loan approval process
✅ **Better UX**: Sidebar calculator now shows realistic maximum they can borrow
✅ **Compliance**: Ensures system rule (total loans ≤ eligibility) is understood before application
✅ **Reduces Rejections**: Members won't apply for more than available
