<div class="header">
    <h1>LOAN REPAYMENT SCHEDULE</h1>
    <h3>{{ config('app.name', 'SACCO Management System') }}</h3>
    <p>Generated on: {{ now()->format('d M Y H:i') }}</p>
</div>

<!-- Loan Information with role-specific notes -->
<div class="loan-info">
    <!-- ... same loan info as before ... -->
    
    @if(auth()->user()->hasRole(['treasurer', 'chairman', 'secretary']))
    <div class="info-item" style="grid-column: span 2; background: #e8f4fd; padding: 8px; border-radius: 4px;">
        <span class="info-label">Official View:</span>
        <span class="info-value">{{ auth()->user()->name }} ({{ strtoupper(auth()->user()->role) }})</span>
    </div>
    @endif
</div>

<!-- ... rest of the schedule table ... -->