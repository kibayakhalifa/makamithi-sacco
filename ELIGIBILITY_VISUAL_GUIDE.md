# Loan Eligibility Display - Visual Guide

## Member Dashboard View (member.loans.index)

### Before

Single card showing:

-   **Eligible Amount: KES 150,000**
-   Status message

### After

Three cards with clear breakdown:

```
┌──────────────────────────────────────────────────────────┐
│                       LOAN STATS                         │
├─────────────────────┬─────────────────────┬─────────────┤
│   Total Eligibility │ Current Loan Balance│ Available   │
│   💰                │ 📊                  │ ✅          │
│ KES 150,000        │ KES 80,000          │KES 70,000   │
│                    │                     │             │
│ Based on your      │ Active loans        │ Total       │
│ savings × 1.5      │ remaining balance   │ eligibility │
│                    │                     │ minus       │
│                    │                     │ current     │
└─────────────────────┴─────────────────────┴─────────────┘
```

### Borrowing Capacity Breakdown Card

```
┌────────────────────────────────────────────────────────┐
│         BORROWING CAPACITY BREAKDOWN                   │
├────────────────────────────────────────────────────────┤
│ Savings Balance        × 1.5 =    Total Eligibility  │
│ KES 100,000           ×          KES 150,000        │
├────────────────────────────────────────────────────────┤
│ Total Eligibility -    Current    Available to       │
│ KES 150,000       -    Loans   =  Borrow            │
│                                    KES 70,000       │
└────────────────────────────────────────────────────────┘
```

---

## Loan Application View (member.loans.apply)

### Before

Header showed:

-   Title: "Apply for a Loan"
-   Box: "Your Loan Eligibility: KES 150,000"

### After

Header now shows:

```
┌────────────────────────────────────────────────────────┐
│ Apply for a Loan                                       │
│ Get quick access to funds based on your savings       │
│                                                        │
│                ┌──────────────────────────────────┐  │
│                │ You can borrow now               │  │
│                │ KES 70,000                       │  │
│                │ of KES 150,000 total eligibility │  │
│                └──────────────────────────────────┘  │
└────────────────────────────────────────────────────────┘
```

### Sidebar Eligibility Breakdown Card

```
┌────────────────────────────────────────┐
│  📊 YOUR BORROWING CAPACITY            │
├────────────────────────────────────────┤
│  Total Eligibility      KES 150,000   │
│                 –                       │
│  Current Loans          KES 80,000    │
│  ────────────────────────────────────  │
│  Available Now          KES 70,000    │
│                                        │
│  ✓ Your available funds =              │
│  (Savings × 1.5) − Current loan balance│
└────────────────────────────────────────┘
```

---

## Loan Amount Input

### Before

-   Max amount in form: Total eligibility (KES 150,000)
-   Members could attempt to borrow more than available

### After

-   Max amount in form: Available eligibility (KES 70,000)
-   Display: "Max: KES 70,000"
-   Members can only apply for realistic amounts

---

## Real-World Scenarios

### Scenario 1: First-Time Loan Applicant

```
Savings:              KES 100,000
Total Eligibility:    KES 150,000  (100,000 × 1.5)
Current Loans:        KES 0        (None)
────────────────────────────────
Available to Borrow:  KES 150,000  ✓ Can apply for up to KES 150,000
```

### Scenario 2: Member with Active First Loan (25% Paid)

```
Savings:              KES 100,000
Total Eligibility:    KES 150,000  (100,000 × 1.5)
Current Loans:        KES 75,000   (First loan balance)
────────────────────────────────
Available to Borrow:  KES 75,000   ✓ Can apply for second loan (after 50% of first)
```

### Scenario 3: Member with Active First Loan (60% Paid)

```
Savings:              KES 100,000
Total Eligibility:    KES 150,000  (100,000 × 1.5)
Current Loans:        KES 60,000   (First loan remaining)
────────────────────────────────
Available to Borrow:  KES 90,000   ✓ Can apply for second loan up to KES 90,000
```

### Scenario 4: Member at Borrowing Limit

```
Savings:              KES 100,000
Total Eligibility:    KES 150,000  (100,000 × 1.5)
Current Loans:        KES 145,000  (First + Second loans)
────────────────────────────────
Available to Borrow:  KES 5,000    ⚠️ Only KES 5,000 available (minimum loan)
```

### Scenario 5: Member Over Limit (Cannot Borrow)

```
Savings:              KES 100,000
Total Eligibility:    KES 150,000  (100,000 × 1.5)
Current Loans:        KES 150,000  (First + Second loans)
────────────────────────────────
Available to Borrow:  KES 0        ❌ Cannot apply for more loans
```

---

## Key Messaging

### Card Labels & Colors

| Card                     | Color | Message                             | Icon |
| ------------------------ | ----- | ----------------------------------- | ---- |
| **Total Eligibility**    | Blue  | Your maximum borrowing potential    | 💰   |
| **Current Loan Balance** | Amber | What you're currently borrowing     | 📊   |
| **Available to Borrow**  | Green | What you can actually apply for now | ✅   |

### Sidebar Help Text

"Your available funds = (Savings × 1.5) − Current loan balance"

### Form Validation

-   Loan amount max is always `available_eligibility`
-   Error message: "Loan amount cannot exceed your available eligibility of KES [amount]"

---

## Implementation Benefits

✅ **Immediate Understanding**: Members understand the math at a glance
✅ **Prevents Confusion**: Shows existing loans reduce borrowing power
✅ **Reduces Rejections**: Members won't apply for impossible amounts
✅ **Transparent Process**: Full visibility into eligibility calculation
✅ **Better Compliance**: System rule clearly demonstrated
✅ **Improved Trust**: Members see fair, calculated limits
