# Quick Reference: Loan Eligibility Transformation

## 🎯 One-Line Summary

Members now see **3 figures** (Total Eligibility, Current Loans, Available to Borrow) instead of just 1, making it clear how much they can actually apply for.

---

## 📍 Where Changes Appear

### 1. Dashboard (member.loans.index)

**Location**: Member → My Loans page

**What members see**:

-   **Card 1 (Blue)**: Total Eligibility = Savings × 1.5
-   **Card 2 (Amber)**: Current Loan Balance = Active loans remaining
-   **Card 3 (Green)**: Available to Borrow = Total - Current
-   **New Card**: Breakdown showing the calculation

**Example**:

```
Total Eligibility: KES 150,000
Current Loans:     KES 80,000
─────────────────────────────
Available:         KES 70,000
```

### 2. Application Form (member.loans.apply)

**Location**: Member → Apply New Loan page

**Header shows**:

-   "You can borrow now: KES 70,000 of KES 150,000 total eligibility"

**Sidebar shows**:

-   Eligibility breakdown card with calculation
-   Visual breakdown of the three figures

**Form shows**:

-   Max loan amount = Available amount (KES 70,000)

---

## 🔧 Backend Implementation

### Helper Method

```php
calculateAvailableEligibility($user)
```

**Returns**:

```php
[
    'total_eligibility' => 150000,      // Savings × 1.5
    'current_loan_balance' => 80000,    // Sum of active loans
    'available_eligibility' => 70000    // Total - Current
]
```

**Used in**:

-   `index()` - Dashboard
-   `create()` - Apply form
-   `store()` - Validation
-   `topup()` - Top-up form
-   `storeTopup()` - Top-up validation

---

## 📊 The Math

### Formula

```
Available Eligibility = Total Eligibility - Current Loan Balance
Available Eligibility = (Savings × 1.5) - Active Loan Remaining
```

### Example Calculations

**Case 1: No Loans**

```
Savings: 100,000
Total: 100,000 × 1.5 = 150,000
Current: 0
Available: 150,000 - 0 = 150,000 ✓
```

**Case 2: With First Loan**

```
Savings: 100,000
Total: 100,000 × 1.5 = 150,000
Current: 80,000 (first loan balance)
Available: 150,000 - 80,000 = 70,000 ✓
```

**Case 3: Two Loans**

```
Savings: 100,000
Total: 100,000 × 1.5 = 150,000
Current: 30,000 (first) + 20,000 (second) = 50,000
Available: 150,000 - 50,000 = 100,000 ✓
```

---

## 🎨 Visual Display

### Dashboard Cards (3 columns)

```
┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐
│      💰         │  │      📊         │  │      ✅         │
│ Total Eligib... │  │ Current Loan... │  │ Available to... │
│ KES 150,000    │  │ KES 80,000     │  │ KES 70,000     │
│                │  │                │  │                │
│ Based on your  │  │ Active loans   │  │ Total          │
│ savings × 1.5  │  │ remaining bal..│  │ eligibility    │
│                │  │                │  │ minus current  │
└─────────────────┘  └─────────────────┘  └─────────────────┘
```

### Breakdown Card

```
┌──────────────────────────────────────────┐
│ Savings Balance × 1.5 = Total Eligibility│
│ KES 100,000     ×     KES 150,000       │
├──────────────────────────────────────────┤
│ Total Eligibility - Current = Available  │
│ KES 150,000       - KES 80,000 = 70,000 │
└──────────────────────────────────────────┘
```

---

## ✅ User Journey

### Scenario: Member with Active Loan Wants to Apply for Second

**Before**:

1. View dashboard → See "Eligible Amount: KES 150,000"
2. Click Apply → Confused why can't apply for full amount
3. Form shows max: KES 150,000 (but actual available less)
4. Apply for KES 100,000
5. Rejected: "You can't borrow that much"
6. Support ticket: "Why did you reject me?"

**After**:

1. View dashboard → See three cards clearly
2. Understand: "Total is 150,000 but current loan is 80,000"
3. Do math: 150,000 - 80,000 = 70,000 available
4. Click Apply → See "You can borrow now: 70,000"
5. Form max shows: 70,000
6. Apply for 70,000
7. ✓ Approved immediately

---

## 🔑 Key Takeaways

### What Changed

| Aspect                | Before     | After                       |
| --------------------- | ---------- | --------------------------- |
| Cards shown           | 1          | 3                           |
| Information           | Total only | Total + Current + Available |
| Calculation visible   | No         | Yes                         |
| Member clarity        | Low        | High                        |
| Support tickets       | Many       | Few                         |
| Rejected applications | Many       | Few                         |

### Benefits

-   ✓ Transparent eligibility calculation
-   ✓ Clear indication of available funds
-   ✓ Prevents application rejections
-   ✓ Builds member trust
-   ✓ Reduces support burden
-   ✓ Better financial planning

---

## 📱 Responsive Design

### Desktop (3 columns)

```
[Card 1] [Card 2] [Card 3]
[Breakdown Card spanning all]
```

### Tablet (2-3 columns)

```
[Card 1] [Card 2]
[Card 3]
[Breakdown Card]
```

### Mobile (1 column)

```
[Card 1]
[Card 2]
[Card 3]
[Breakdown Card]
```

---

## 🧪 Quick Test

**To verify implementation working**:

1. **Login as member with no loans**

    - Dashboard should show: Available = Total
    - Example: All cards show same amount

2. **Login as member with active loan**

    - Available < Total
    - Math: Total - Current = Available
    - Example: 150,000 - 80,000 = 70,000

3. **Try to apply for loan**

    - Form max = Available amount
    - Header shows: "You can borrow now: [Available]"
    - Sidebar shows breakdown

4. **Try to apply for more than available**
    - Should show error: "Cannot exceed available limit"

---

## 📚 Files to Reference

| File                          | Purpose                         |
| ----------------------------- | ------------------------------- |
| `MemberLoanController.php`    | Backend calculation logic       |
| `member.loans.index`          | Dashboard display               |
| `member.loans.apply`          | Application form display        |
| `LOAN_ELIGIBILITY_CHANGES.md` | Detailed technical changes      |
| `ELIGIBILITY_VISUAL_GUIDE.md` | Visual explanations & scenarios |
| `TESTING_GUIDE.md`            | Comprehensive testing checklist |

---

## 🎓 Member Explanation

When explaining to members:

> "Your borrowing capacity is based on your savings. We calculate your maximum eligibility as your savings times 1.5. However, if you already have loans, we reduce that amount by what you're currently borrowing. This ensures you never borrow more than your eligibility allows. The green 'Available to Borrow' shows what you can apply for right now."

---

## ❓ Common Questions

**Q: Why did my available amount go down?**
A: Your available amount decreases when you take loans. Each loan reduces your available borrowing capacity by the loan amount.

**Q: How do I increase my available amount?**
A:

1. Increase your savings (raises total eligibility)
2. Pay down existing loans (reduces current balance)

**Q: Can I borrow more than the available amount?**
A: No. The available amount is the maximum the system allows. This protects both you and the organization.

**Q: What if my available amount is too small?**
A: You have two options:

1. Wait to complete your current loan
2. Increase your savings to raise total eligibility

---

## 🚀 Deployment Notes

-   **No database migration required**
-   **Backward compatible** - existing data unchanged
-   **Zero downtime** - safe to deploy anytime
-   **No configuration changes** - works with existing settings
-   **Member-facing only** - no admin changes

---

**Last Updated**: December 22, 2025
**Version**: 1.0 - Initial Implementation
**Status**: ✅ Complete and Ready for Testing
