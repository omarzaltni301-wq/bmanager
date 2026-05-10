@extends('layouts.app')

@section('title', 'Budget Calculator')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/calculator.css') }}">
@endsection

@section('content')
    <section class="page-header">
        <div class="header-icon">🧮</div>
        <h1>Budget Calculator</h1>
        <p>Track your income, expenses and savings to manage your monthly budget in TND</p>
    </section>

    <!-- Single Date Field -->
    <div class="date-bar">
        <div class="date-bar-inner">
            <label for="entryDate">📅 Select Entry Date</label>
            <input type="date" id="entryDate">
            <p class="date-help">You can choose any past or future date for your entries.</p>
        </div>
    </div>

    <!-- Remaining Banner -->
    <div class="remaining-banner">
        <div class="remaining-banner-item">
            <span class="rb-label">Total Income</span>
            <span class="rb-value income-color" id="bannerIncome">0.00 TND</span>
        </div>
        <div class="rb-minus">−</div>
        <div class="remaining-banner-item">
            <span class="rb-label">Savings + Expenses</span>
            <span class="rb-value expense-color" id="bannerDeductions">0.00 TND</span>
        </div>
        <div class="rb-equals">=</div>
        <div class="remaining-banner-item">
            <span class="rb-label">Remaining</span>
            <span class="rb-value" id="bannerRemaining">0.00 TND</span>
        </div>
    </div>

    <!-- Three Forms -->
    <div class="calculator-container">

        <!-- Income Form -->
        <div class="input-section">
            <h2>💼 Add Income</h2>
            <div class="form-group">
                <label>Category</label>
                <select id="incomeCategory">
                    <option value="Salary">Salary</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            <div class="form-group">
                <label>Amount (TND)</label>
                <input type="number" id="incomeAmount" placeholder="0.00" step="0.01">
            </div>
            <button class="btn-add btn-income" onclick="addIncome()">+ Add Income</button>
            <div class="entries-list" id="incomeList">
                <div class="empty-state">No income added yet</div>
            </div>
        </div>

        <!-- Expense Form -->
        <div class="input-section">
            <h2>💸 Add Expense</h2>
            <div class="form-group">
                <label>Category</label>
                <select id="category">
                    <option value="Food & Groceries">Food & Groceries</option>
                    <option value="Housing">Housing</option>
                    <option value="Transportation">Transportation</option>
                    <option value="Utilities">Utilities</option>
                    <option value="Healthcare">Healthcare</option>
                    <option value="Entertainment">Entertainment</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Expense Name</label>
                <input type="text" id="expenseName" placeholder="e.g., Monthly groceries">
            </div>
            <div class="form-group">
                <label>Amount (TND)</label>
                <input type="number" id="amount" placeholder="0.00" step="0.01">
            </div>
            <button class="btn-add" onclick="addExpense()">+ Add Expense</button>
            <div class="entries-list" id="expenseList">
                <div class="empty-state">Add expenses to see your budget summary</div>
            </div>
        </div>

        <!-- Savings Form -->
        <div class="input-section">
            <h2>🏦 Add Savings</h2>
            <div class="form-group">
                <label>Saving Name</label>
                <input type="text" id="savingName" placeholder="e.g., Emergency fund">
            </div>
            <div class="form-group">
                <label>Amount (TND)</label>
                <input type="number" id="savingAmount" placeholder="0.00" step="0.01">
            </div>
            <button class="btn-add btn-savings" onclick="addSaving()">+ Add Saving</button>
            <div class="entries-list" id="savingList">
                <div class="empty-state">No savings added yet</div>
            </div>
        </div>

    </div>

    <!-- Totals Summary -->
    <div class="totals-summary">
        <div class="total-card total-income-card">
            <h2>Total Income</h2>
            <div class="total-label">Session Total</div>
            <div class="total-amount" id="totalIncome">0.00</div>
            <div class="total-currency">TND</div>
        </div>
        <div class="total-card">
            <h2>Total Expenses</h2>
            <div class="total-label">Session Total</div>
            <div class="total-amount" id="totalAmount">0.00</div>
            <div class="total-currency">TND</div>
        </div>
        <div class="total-card total-savings-card">
            <h2>Total Savings</h2>
            <div class="total-label">Session Total</div>
            <div class="total-amount" id="totalSavings">0.00</div>
            <div class="total-currency">TND</div>
        </div>
    </div>

<script>
var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
var expenses = [];
var incomes  = [];
var savings  = [];
var editState = { type: null, index: null };

// Set default date
window.addEventListener('DOMContentLoaded', function() {
    var today = new Date();
    var yyyy = today.getFullYear();
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var dd = String(today.getDate()).padStart(2, '0');
    document.getElementById('entryDate').value = yyyy + '-' + mm + '-' + dd;

    // Load existing data from DB
    loadExistingData();
});

function loadExistingData() {
    var existingIncomes = @json($incomes);
    var existingExpenses = @json($expenses);
    var existingSavings = @json($savings);

    existingIncomes.forEach(function(item) {
        incomes.push({ id: item.income_id, category: item.category, amount: parseFloat(item.amount), date: item.entry_date });
    });
    existingExpenses.forEach(function(item) {
        expenses.push({ id: item.expense_id, category: item.category, name: item.name, amount: parseFloat(item.amount), date: item.entry_date });
    });
    existingSavings.forEach(function(item) {
        savings.push({ id: item.saving_id, name: item.name, amount: parseFloat(item.amount), date: item.entry_date });
    });

    updateDisplay();
}

function getDate() {
    var d = document.getElementById('entryDate').value;
    if (!d) { alert('Please select a date first'); return null; }
    return d;
}

function apiRequest(method, url, data, callback) {
    var options = {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    };
    if (data) options.body = JSON.stringify(data);

    fetch(url, options)
        .then(function(res) { return res.json(); })
        .then(function(json) {
            if (json.success) {
                if (callback) callback(json);
            } else {
                alert('Error: ' + (json.message || 'Something went wrong'));
            }
        })
        .catch(function(err) {
            alert('Error: ' + err.message);
        });
}

// ── Add Income ──
function addIncome() {
    var date = getDate(); if (!date) return;
    var category = document.getElementById('incomeCategory').value;
    var amount = parseFloat(document.getElementById('incomeAmount').value);
    if (!amount || amount <= 0) { alert('Please enter a valid amount'); return; }

    if (editState.type === 'income') {
        var item = incomes[editState.index];
        apiRequest('PUT', '/incomes/' + item.id, { category: category, amount: amount, entry_date: date }, function(json) {
            incomes[editState.index] = { id: item.id, category: category, amount: amount, date: date };
            resetEdit('income');
            updateDisplay();
        });
    } else {
        apiRequest('POST', '/incomes', { category: category, amount: amount, entry_date: date }, function(json) {
            incomes.push({ id: json.income.income_id, category: category, amount: amount, date: date });
            updateDisplay();
        });
    }
    document.getElementById('incomeAmount').value = '';
}

// ── Add Expense ──
function addExpense() {
    var date = getDate(); if (!date) return;
    var category = document.getElementById('category').value;
    var expenseName = document.getElementById('expenseName').value;
    var amount = parseFloat(document.getElementById('amount').value);
    if (!expenseName || !amount || amount <= 0) { alert('Please fill all fields with valid data'); return; }

    if (editState.type === 'expense') {
        var item = expenses[editState.index];
        apiRequest('PUT', '/expenses/' + item.id, { name: expenseName, category: category, amount: amount, entry_date: date }, function(json) {
            expenses[editState.index] = { id: item.id, category: category, name: expenseName, amount: amount, date: date };
            resetEdit('expense');
            updateDisplay();
        });
    } else {
        apiRequest('POST', '/expenses', { name: expenseName, category: category, amount: amount, entry_date: date }, function(json) {
            expenses.push({ id: json.expense.expense_id, category: category, name: expenseName, amount: amount, date: date });
            updateDisplay();
        });
    }
    document.getElementById('expenseName').value = '';
    document.getElementById('amount').value = '';
}

// ── Add Saving ──
function addSaving() {
    var date = getDate(); if (!date) return;
    var name = document.getElementById('savingName').value;
    var amount = parseFloat(document.getElementById('savingAmount').value);
    if (!name || !amount || amount <= 0) { alert('Please fill all fields with valid data'); return; }

    if (editState.type === 'saving') {
        var item = savings[editState.index];
        apiRequest('PUT', '/savings/' + item.id, { name: name, amount: amount, entry_date: date }, function(json) {
            savings[editState.index] = { id: item.id, name: name, amount: amount, date: date };
            resetEdit('saving');
            updateDisplay();
        });
    } else {
        apiRequest('POST', '/savings', { name: name, amount: amount, entry_date: date }, function(json) {
            savings.push({ id: json.saving.saving_id, name: name, amount: amount, date: date });
            updateDisplay();
        });
    }
    document.getElementById('savingName').value = '';
    document.getElementById('savingAmount').value = '';
}

// ── Delete ──
function deleteExpense(i) {
    apiRequest('DELETE', '/expenses/' + expenses[i].id, null, function() {
        expenses.splice(i, 1); updateDisplay();
    });
}
function deleteIncome(i) {
    apiRequest('DELETE', '/incomes/' + incomes[i].id, null, function() {
        incomes.splice(i, 1); updateDisplay();
    });
}
function deleteSaving(i) {
    apiRequest('DELETE', '/savings/' + savings[i].id, null, function() {
        savings.splice(i, 1); updateDisplay();
    });
}

// ── Edit ──
function editIncome(i) {
    var item = incomes[i];
    document.getElementById('incomeCategory').value = item.category;
    document.getElementById('incomeAmount').value = item.amount;
    document.getElementById('entryDate').value = item.date;
    setEditState('income', i);
    document.querySelector('.btn-income').textContent = '✏️ Update Income';
}

function editExpense(i) {
    var item = expenses[i];
    document.getElementById('category').value = item.category;
    document.getElementById('expenseName').value = item.name;
    document.getElementById('amount').value = item.amount;
    document.getElementById('entryDate').value = item.date;
    setEditState('expense', i);
    document.querySelector('.btn-add:not(.btn-income):not(.btn-savings)').textContent = '✏️ Update Expense';
}

function editSaving(i) {
    var item = savings[i];
    document.getElementById('savingName').value = item.name;
    document.getElementById('savingAmount').value = item.amount;
    document.getElementById('entryDate').value = item.date;
    setEditState('saving', i);
    document.querySelector('.btn-savings').textContent = '✏️ Update Saving';
}

function setEditState(type, index) { editState = { type: type, index: index }; }

function resetEdit(type) {
    editState = { type: null, index: null };
    if (type === 'income') document.querySelector('.btn-income').textContent = '+ Add Income';
    if (type === 'expense') document.querySelector('.btn-add:not(.btn-income):not(.btn-savings)').textContent = '+ Add Expense';
    if (type === 'saving') document.querySelector('.btn-savings').textContent = '+ Add Saving';
}

// ── Update Display ──
function updateDisplay() {
    var totalExp = expenses.reduce(function(s,e){ return s+e.amount; }, 0);
    var totalInc = incomes.reduce(function(s,e){ return s+e.amount; }, 0);
    var totalSav = savings.reduce(function(s,e){ return s+e.amount; }, 0);
    var remaining = totalInc - (totalSav + totalExp);

    document.getElementById('totalAmount').textContent = totalExp.toFixed(2);
    document.getElementById('totalIncome').textContent = totalInc.toFixed(2);
    document.getElementById('totalSavings').textContent = totalSav.toFixed(2);

    document.getElementById('bannerIncome').textContent = totalInc.toFixed(2) + ' TND';
    document.getElementById('bannerDeductions').textContent = (totalSav + totalExp).toFixed(2) + ' TND';
    var remEl = document.getElementById('bannerRemaining');
    remEl.textContent = remaining.toFixed(2) + ' TND';
    remEl.style.color = remaining >= 0 ? '#a5f3c0' : '#fca5a5';

    renderList('incomeList', incomes, function(item, i) {
        return '<div class="expense-item">' +
            '<div class="expense-info"><h4>' + item.category + '</h4><span class="expense-category">' + item.date + '</span></div>' +
            '<div style="display:flex;align-items:center;gap:6px;">' +
            '<span class="expense-amount" style="color:#4caf50;">+' + item.amount.toFixed(2) + ' TND</span>' +
            '<button class="btn-edit" onclick="editIncome(' + i + ')">✏️</button>' +
            '<button class="btn-delete" onclick="deleteIncome(' + i + ')">🗑️</button>' +
            '</div></div>';
    }, 'No income added yet');

    renderList('expenseList', expenses, function(item, i) {
        return '<div class="expense-item">' +
            '<div class="expense-info"><h4>' + item.name + '</h4><span class="expense-category">' + item.category + '</span></div>' +
            '<div style="display:flex;align-items:center;gap:6px;">' +
            '<span class="expense-amount">-' + item.amount.toFixed(2) + ' TND</span>' +
            '<button class="btn-edit" onclick="editExpense(' + i + ')">✏️</button>' +
            '<button class="btn-delete" onclick="deleteExpense(' + i + ')">🗑️</button>' +
            '</div></div>';
    }, 'Add expenses to see your budget summary');

    renderList('savingList', savings, function(item, i) {
        return '<div class="expense-item">' +
            '<div class="expense-info"><h4>' + item.name + '</h4><span class="expense-category">' + item.date + '</span></div>' +
            '<div style="display:flex;align-items:center;gap:6px;">' +
            '<span class="expense-amount" style="color:#ff9800;">+' + item.amount.toFixed(2) + ' TND</span>' +
            '<button class="btn-edit" onclick="editSaving(' + i + ')">✏️</button>' +
            '<button class="btn-delete" onclick="deleteSaving(' + i + ')">🗑️</button>' +
            '</div></div>';
    }, 'No savings added yet');
}

function renderList(elId, arr, rowFn, emptyMsg) {
    var el = document.getElementById(elId);
    if (arr.length === 0) {
        el.innerHTML = '<div class="empty-state">' + emptyMsg + '</div>';
    } else {
        var html = '';
        arr.forEach(function(item, i) { html += rowFn(item, i); });
        el.innerHTML = html;
    }
}
</script>
@endsection
