@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<div class="container">

    <!-- Welcome Bar -->
    <div class="welcome-bar">
        <h1>Welcome to your dashboard, {{ Auth::user()->full_name }}! 👋</h1>
        <p id="currentDate"></p>
    </div>

    <!-- Date Filter -->
    <div class="date-filter-bar">
        <label for="dateFilter">📅 Filter by date:</label>
        <input type="date" id="dateFilter" value="{{ $filterDate ?? '' }}" onchange="filterByDate()">
        <button class="btn-clear-filter" onclick="clearFilter()">Show All</button>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="summary-card-info">
                <h4>Total Income</h4>
                <div class="amount" id="dashIncome">{{ number_format($totalIncome, 2) }} TND</div>
                <div class="trend up">💼 Salary & others</div>
            </div>
            <div class="summary-card-icon icon-blue">💼</div>
        </div>
        <div class="summary-card">
            <div class="summary-card-info">
                <h4>Total Spent</h4>
                <div class="amount" id="dashSpent">{{ number_format($totalExpenses, 2) }} TND</div>
                <div class="trend down">💸 All expenses</div>
            </div>
            <div class="summary-card-icon icon-red">💸</div>
        </div>
        <div class="summary-card">
            <div class="summary-card-info">
                <h4>Remaining</h4>
                <div class="amount" id="dashRemaining">{{ number_format($remaining, 2) }} TND</div>
                <div class="trend {{ $remaining >= 0 ? 'up' : 'down' }}" id="remainingTrend">Income − (Savings + Expenses)</div>
            </div>
            <div class="summary-card-icon icon-green">📊</div>
        </div>
        <div class="summary-card">
            <div class="summary-card-info">
                <h4>Savings</h4>
                <div class="amount" id="dashSavings">{{ number_format($totalSavings, 2) }} TND</div>
                <div class="trend up">🏦 Total saved</div>
            </div>
            <div class="summary-card-icon icon-orange">🏦</div>
        </div>
    </div>

    <!-- Remaining Block -->
    <div class="remaining-block">
        <div>
            <h3>Current Balance</h3>
            <div class="remaining-amount" id="remainingBig">{{ number_format($remaining, 2) }} TND</div>
            <div class="remaining-formula">Income − (Savings + Expenses) = Remaining</div>
        </div>
        <div class="remaining-block-icon">💰</div>
    </div>

    <!-- Dashboard Grid -->
    <div class="dashboard-grid">

        <!-- Pie Chart + Bar Chart -->
        <div class="dashboard-card">
            <h3>Budget Distribution</h3>
            <div class="pie-container">
                <canvas id="budgetPieChart" width="380" height="300"></canvas>
                <div class="pie-tooltip" id="pieTooltip"></div>
            </div>
            <hr style="border:none;border-top:1px solid #f0f0f0;margin:20px 0;">
            <h3>Monthly Trends</h3>
            <div class="bar-chart-wrapper">
                <canvas id="monthlyBarChart" width="500" height="180"></canvas>
                <div class="bar-tooltip" id="barTooltip"></div>
            </div>
            <div class="bar-legend">
                <span><span class="bar-dot" style="background:#2B5CE6;"></span>Income</span>
                <span><span class="bar-dot" style="background:#4fc3f7;"></span>Spent</span>
            </div>
        </div>

        <!-- Expenses List -->
        <div class="dashboard-card">
            <h3>Expenses List</h3>
            <div id="dashExpensesList">
                @if($expenses->count() > 0)
                    @foreach($expenses as $exp)
                        <div class="expense-entry">
                            <div class="expense-entry-icon">
                                @php
                                    $icons = [
                                        'Food & Groceries'=>'🛒','Housing'=>'🏠','Transportation'=>'🚗',
                                        'Utilities'=>'⚡','Healthcare'=>'🏥','Entertainment'=>'🎬',
                                        'Other'=>'📦','Salary'=>'💼','Others'=>'💰'
                                    ];
                                @endphp
                                {{ $icons[$exp->category] ?? '📦' }}
                            </div>
                            <div class="expense-entry-info">
                                <h4>{{ $exp->name }}</h4>
                                <span>{{ $exp->category }}</span>
                            </div>
                            <div class="expense-entry-right">
                                <div class="entry-amount">-{{ number_format($exp->amount, 2) }} TND</div>
                                <div class="entry-date">{{ $exp->entry_date->format('Y-m-d') }}</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-dashboard">No expenses found.<br>Go to the Calculator to add expenses.</div>
                @endif
            </div>
            <a href="{{ route('calculator') }}" class="view-all-link">+ Add more in Calculator →</a>
        </div>

    </div>

    <hr class="section-divider">

    <!-- Visitor Sections -->
    <section class="hero">
        <div class="warning-tag">&#9888; Understanding Inflation in Tunisia</div>
        <h1>Stay Informed About <br><span class="blue-text">Price Changes</span></h1>
        <p>BMANAGER helps you understand inflation's impact on your daily life.</p>
        <a href="{{ route('calculator') }}" class="btn-blue">Try Budget Calculator</a>
        <a href="#prices" class="btn-white">View Current Prices</a>
    </section>

    <section class="features">
        <div class="col-3">
            <div class="icon-box blue-bg">&#x1F4C8;</div>
            <h3>What is Inflation?</h3>
            <p>Inflation is the rate at which prices for goods and services increase over time, affecting your purchasing power and daily expenses.</p>
        </div>
        <div class="col-3">
            <div class="icon-box green-bg">&#x1F4B2;</div>
            <h3>Why Track Prices?</h3>
            <p>Understanding current prices helps you plan your budget, make informed purchasing decisions, and manage your finances better.</p>
        </div>
        <div class="col-3">
            <div class="icon-box orange-bg">&#x1F4D6;</div>
            <h3>Learn to Save</h3>
            <p>Access practical budget tips and money management strategies tailored for Tunisian households and families.</p>
        </div>
        <div class="clear"></div>
    </section>

    <section class="prices-section" id="prices">
        <h2>Current Price Examples</h2>
        <p class="subtitle">View examples of current product prices in Tunisia. Prices are updated weekly from reliable sources to ensure accuracy.</p>
        <div class="legend">
            <span class="dot green"></span> Official/Regulated Price
            <span class="dot orange"></span> Estimated Market Price
        </div>
        <div class="price-cards-container">
            @foreach($prices as $category => $items)
            <div class="col-3 card">
                <div class="card-header">
                    @php
                        $icons = ['Food' => '🍎', 'Fuel' => '⛽', 'Electricity' => '⚡', 'Other' => '📦'];
                    @endphp
                    <span>{{ $icons[$category] ?? '📦' }}</span> <b>{{ $category }}</b>
                </div>
                @foreach($items as $item)
                <div class="price-row">
                    <div class="price-label"><span class="dot {{ $item->source == 'Official' ? 'green' : 'orange' }}"></span>{{ $item->item_name }}</div>
                    <div class="price-value">{{ number_format($item->price, 3) }} TND</div>
                </div>
                @endforeach
            </div>
            @endforeach
            <div class="clear"></div>
        </div>
        <div class="info-box">
            <p><b>&#9432; Data Accuracy & Updates</b><br>All prices are verified from reliable Tunisian sources. Prices are updated weekly.</p>
        </div>
    </section>

<<<<<<< HEAD
</div>

<script>
=======
    <!-- Chatbot UI -->
    <div id="chatbot-container">
        <div id="chatbot-button" onclick="toggleChat()">💬</div>
        <div id="chatbot-window">
            <div id="chatbot-header">
                <span>BM Assistant</span>
                <button onclick="toggleChat()" style="background:none;border:none;color:white;cursor:pointer;font-size:18px;">&times;</button>
            </div>
            <div id="chatbot-messages">
                <div class="bot-msg">Hello! I'm your BMANAGER assistant. How can I help you save or track your income today?</div>
            </div>
            <div id="chatbot-input-container">
                <input type="text" id="chatbot-input" placeholder="Type a message..." onkeypress="handleKey(event)">
                <button id="chatbot-send" onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>

</div>

<script>
// ── Chatbot Logic ──
function toggleChat() {
    var win = document.getElementById('chatbot-window');
    win.style.display = (win.style.display === 'flex') ? 'none' : 'flex';
}

function handleKey(e) {
    if (e.key === 'Enter') sendMessage();
}

function sendMessage() {
    var input = document.getElementById('chatbot-input');
    var text = input.value.trim();
    if (!text) return;

    appendMessage('user', text);
    input.value = '';

    fetch('{{ route("chatbot.message") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message: text })
    })
    .then(res => res.json())
    .then(data => {
        appendMessage('bot', data.reply);
        // If income/expense/saving was added/deleted, reload dashboard data in 2 seconds
        var msg = text.toLowerCase();
        if (msg.includes('income') || msg.includes('expense') || msg.includes('saving')) {
            setTimeout(() => { window.location.reload(); }, 2000);
        }
    })
    .catch(err => {
        appendMessage('bot', "Sorry, I'm having trouble connecting right now.");
    });
}

function appendMessage(type, text) {
    var msgDiv = document.createElement('div');
    msgDiv.className = type + '-msg';
    msgDiv.innerText = text;
    document.getElementById('chatbot-messages').appendChild(msgDiv);
    var chatBox = document.getElementById('chatbot-messages');
    chatBox.scrollTop = chatBox.scrollHeight;
}

>>>>>>> origin/main
// ── Current Date ──
var days   = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
var now    = new Date();
document.getElementById('currentDate').textContent =
    days[now.getDay()] + ', ' + months[now.getMonth()] + ' ' + now.getDate() + ', ' + now.getFullYear();

// ── Date Filter ──
function filterByDate() {
    var date = document.getElementById('dateFilter').value;
    if (date) {
        window.location.href = '{{ route("dashboard") }}?date=' + date;
    }
}
function clearFilter() {
    window.location.href = '{{ route("dashboard") }}';
}

// ── Chart Data from Server ──
var chartExpenses = {{ $totalExpenses }};
var chartSavings  = {{ $totalSavings }};
var chartRemaining = {{ $remaining > 0 ? $remaining : 0 }};
var allIncomesData = @json($allIncomes);
var allExpensesData = @json($allExpenses);

// ── Pie Chart ──
var pieSlices  = [];
var hoveredIdx = -1;
var CX = 190, CY = 150, R = 110;

function drawPieChart(expenses, savings, remaining) {
    var canvas = document.getElementById('budgetPieChart');
    var ctx    = canvas.getContext('2d');
    var total  = expenses + savings + remaining;
<<<<<<< HEAD

    ctx.clearRect(0, 0, canvas.width, canvas.height);
    pieSlices = [];

=======
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    pieSlices = [];
>>>>>>> origin/main
    if (total === 0) {
        ctx.beginPath();
        ctx.arc(CX, CY, R, 0, 2*Math.PI);
        ctx.fillStyle = '#eef0f5';
        ctx.fill();
        ctx.fillStyle = '#bbb';
        ctx.font = '13px Arial';
        ctx.textAlign = 'center';
        ctx.fillText('No data yet', CX, CY + 5);
        return;
    }
<<<<<<< HEAD

=======
>>>>>>> origin/main
    var sliceData = [
        { label: 'Expenses',  value: expenses,  color: '#f87171' },
        { label: 'Savings',   value: savings,   color: '#60a5fa' },
        { label: 'Remaining', value: remaining, color: '#34d399' },
    ];
<<<<<<< HEAD

=======
>>>>>>> origin/main
    var startAngle = -Math.PI / 2;
    sliceData.forEach(function(slice) {
        if (slice.value <= 0) return;
        var sliceAngle = (slice.value / total) * 2 * Math.PI;
        pieSlices.push({
            label: slice.label, value: slice.value, color: slice.color,
            startAngle: startAngle, endAngle: startAngle + sliceAngle,
            pct: ((slice.value / total) * 100).toFixed(1)
        });
        startAngle += sliceAngle;
    });
<<<<<<< HEAD

=======
>>>>>>> origin/main
    renderPieChart(ctx);
}

function renderPieChart(ctx) {
    ctx.clearRect(0, 0, 380, 320);
    pieSlices.forEach(function(slice, i) {
        var isHovered = (i === hoveredIdx);
        var offset = isHovered ? 10 : 0;
        var midAngle = (slice.startAngle + slice.endAngle) / 2;
        var ox = Math.cos(midAngle) * offset;
        var oy = Math.sin(midAngle) * offset;
<<<<<<< HEAD

=======
>>>>>>> origin/main
        ctx.beginPath();
        ctx.moveTo(CX + ox, CY + oy);
        ctx.arc(CX + ox, CY + oy, R, slice.startAngle, slice.endAngle);
        ctx.closePath();
        ctx.fillStyle = slice.color;
        ctx.shadowColor = isHovered ? 'rgba(0,0,0,0.18)' : 'transparent';
        ctx.shadowBlur = isHovered ? 12 : 0;
        ctx.fill();
        ctx.shadowBlur = 0;
        ctx.strokeStyle = 'white';
        ctx.lineWidth = 3;
        ctx.stroke();
    });
<<<<<<< HEAD

=======
>>>>>>> origin/main
    ctx.font = '12px Arial';
    ctx.textAlign = 'center';
    pieSlices.forEach(function(slice) {
        var midAngle = (slice.startAngle + slice.endAngle) / 2;
        var labelR = R + 28;
        var lineR1 = R + 5;
        var lineR2 = R + 20;
        var lx = CX + Math.cos(midAngle) * labelR;
        var ly = CY + Math.sin(midAngle) * labelR;
<<<<<<< HEAD

=======
>>>>>>> origin/main
        ctx.beginPath();
        ctx.moveTo(CX + Math.cos(midAngle) * lineR1, CY + Math.sin(midAngle) * lineR1);
        ctx.lineTo(CX + Math.cos(midAngle) * lineR2, CY + Math.sin(midAngle) * lineR2);
        ctx.strokeStyle = slice.color;
        ctx.lineWidth = 1.5;
        ctx.stroke();
<<<<<<< HEAD

=======
>>>>>>> origin/main
        ctx.fillStyle = '#444';
        ctx.font = 'bold 12px Arial';
        ctx.fillText(slice.label + ' ' + slice.pct + '%', lx, ly - 3);
    });
}

<<<<<<< HEAD
// Pie hover
=======
>>>>>>> origin/main
document.getElementById('budgetPieChart').addEventListener('mousemove', function(e) {
    var canvas = this, rect = canvas.getBoundingClientRect();
    var scaleX = canvas.width / rect.width, scaleY = canvas.height / rect.height;
    var mx = (e.clientX - rect.left) * scaleX, my = (e.clientY - rect.top) * scaleY;
    var dx = mx - CX, dy = my - CY;
    var dist = Math.sqrt(dx*dx + dy*dy);
    var tooltip = document.getElementById('pieTooltip');
<<<<<<< HEAD

=======
>>>>>>> origin/main
    if (dist > R + 12 || pieSlices.length === 0) {
        hoveredIdx = -1; tooltip.style.display = 'none';
        renderPieChart(canvas.getContext('2d')); return;
    }
<<<<<<< HEAD

=======
>>>>>>> origin/main
    var angle = Math.atan2(dy, dx);
    var newHover = -1;
    pieSlices.forEach(function(s, i) {
        var a = angle;
        if (a < s.startAngle && s.startAngle > Math.PI/2) a += 2*Math.PI;
        if (a >= s.startAngle && a <= s.endAngle) newHover = i;
    });
<<<<<<< HEAD

=======
>>>>>>> origin/main
    if (newHover !== hoveredIdx) { hoveredIdx = newHover; renderPieChart(canvas.getContext('2d')); }
    if (newHover !== -1) {
        var s = pieSlices[newHover];
        tooltip.innerHTML = '<span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:'+s.color+';margin-right:6px;vertical-align:middle;"></span><strong>'+s.label+'</strong><br>'+s.value.toFixed(2)+' TND &nbsp;('+s.pct+'%)';
        tooltip.style.display = 'block';
        tooltip.style.left = (e.clientX - rect.left + 14) + 'px';
        tooltip.style.top = (e.clientY - rect.top - 14) + 'px';
    } else { tooltip.style.display = 'none'; }
});

document.getElementById('budgetPieChart').addEventListener('mouseleave', function() {
    hoveredIdx = -1; renderPieChart(this.getContext('2d'));
    document.getElementById('pieTooltip').style.display = 'none';
});

// ── Bar Chart ──
var barChartData = { activeMonths: [], monthData: {}, padL: 55, padR: 15, padT: 15, padB: 40, maxVal: 1000 };

function drawBarChart(allIncomes, allExpenses) {
    var canvas = document.getElementById('monthlyBarChart');
    var ctx = canvas.getContext('2d');
    var W = canvas.width, H = canvas.height;
    ctx.clearRect(0, 0, W, H);
<<<<<<< HEAD

    var monthNames = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    var monthData = {};
    monthNames.forEach(function(m) { monthData[m] = { income: 0, spent: 0 }; });

=======
    var monthNames = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    var monthData = {};
    monthNames.forEach(function(m) { monthData[m] = { income: 0, spent: 0 }; });
>>>>>>> origin/main
    allIncomes.forEach(function(e) {
        if (!e.entry_date) return;
        var mIdx = parseInt(e.entry_date.split('-')[1]) - 1;
        monthData[monthNames[mIdx]].income += parseFloat(e.amount);
    });
    allExpenses.forEach(function(e) {
        if (!e.entry_date) return;
        var mIdx = parseInt(e.entry_date.split('-')[1]) - 1;
        monthData[monthNames[mIdx]].spent += parseFloat(e.amount);
    });
<<<<<<< HEAD

    var activeMonths = monthNames.filter(function(m) { return monthData[m].income > 0 || monthData[m].spent > 0; });
    if (activeMonths.length === 0) activeMonths = monthNames.slice(0, 6);

=======
    var activeMonths = monthNames.filter(function(m) { return monthData[m].income > 0 || monthData[m].spent > 0; });
    if (activeMonths.length === 0) activeMonths = monthNames.slice(0, 6);
>>>>>>> origin/main
    var maxVal = 0;
    activeMonths.forEach(function(m) { maxVal = Math.max(maxVal, monthData[m].income, monthData[m].spent); });
    if (maxVal === 0) maxVal = 1000;
    maxVal = Math.ceil(maxVal / 1000) * 1000 + 1000;
<<<<<<< HEAD

    barChartData.activeMonths = activeMonths;
    barChartData.monthData = monthData;
    barChartData.maxVal = maxVal;

=======
    barChartData.activeMonths = activeMonths;
    barChartData.monthData = monthData;
    barChartData.maxVal = maxVal;
>>>>>>> origin/main
    renderBarChart(ctx, W, H, -1, -1);
}

function renderBarChart(ctx, W, H, hoverMonth, hoverBar) {
    ctx.clearRect(0, 0, W, H);
    var padL = barChartData.padL, padR = barChartData.padR;
    var padT = barChartData.padT, padB = barChartData.padB;
    var activeMonths = barChartData.activeMonths;
    var monthData = barChartData.monthData;
    var maxVal = barChartData.maxVal;
    var chartW = W - padL - padR, chartH = H - padT - padB;
    var numMonths = activeMonths.length;
    var groupW = chartW / numMonths;
    var barW = Math.min(groupW * 0.28, 22);
    var gap = 5;
<<<<<<< HEAD

=======
>>>>>>> origin/main
    ctx.strokeStyle = '#eef0f5'; ctx.lineWidth = 1;
    for (var g = 0; g <= 3; g++) {
        var gy = padT + chartH - (g / 3) * chartH;
        ctx.beginPath(); ctx.moveTo(padL, gy); ctx.lineTo(W - padR, gy); ctx.stroke();
        ctx.fillStyle = '#bbb'; ctx.font = '10px Arial'; ctx.textAlign = 'right';
        ctx.fillText(Math.round((g / 3) * maxVal), padL - 5, gy + 3);
    }
<<<<<<< HEAD

=======
>>>>>>> origin/main
    activeMonths.forEach(function(month, idx) {
        var d = monthData[month];
        var cx = padL + idx * groupW + groupW / 2;
        var incH = (d.income / maxVal) * chartH;
        var sptH = (d.spent / maxVal) * chartH;
<<<<<<< HEAD
        var bx1 = cx - barW - gap / 2;
        var bx2 = cx + gap / 2;

        ctx.globalAlpha = (hoverMonth === idx && hoverBar === 0) ? 1 : (hoverMonth === -1 ? 1 : 0.4);
        ctx.fillStyle = '#2B5CE6';
        roundRect(ctx, bx1, padT + chartH - incH, barW, incH, 3); ctx.fill();

        ctx.globalAlpha = (hoverMonth === idx && hoverBar === 1) ? 1 : (hoverMonth === -1 ? 1 : 0.4);
        ctx.fillStyle = '#4fc3f7';
        roundRect(ctx, bx2, padT + chartH - sptH, barW, sptH, 3); ctx.fill();

=======
        var bx1 = cx - barW - gap / 2, bx2 = cx + gap / 2;
        ctx.globalAlpha = (hoverMonth === idx && hoverBar === 0) ? 1 : (hoverMonth === -1 ? 1 : 0.4);
        ctx.fillStyle = '#2B5CE6';
        roundRect(ctx, bx1, padT + chartH - incH, barW, incH, 3); ctx.fill();
        ctx.globalAlpha = (hoverMonth === idx && hoverBar === 1) ? 1 : (hoverMonth === -1 ? 1 : 0.4);
        ctx.fillStyle = '#4fc3f7';
        roundRect(ctx, bx2, padT + chartH - sptH, barW, sptH, 3); ctx.fill();
>>>>>>> origin/main
        ctx.globalAlpha = 1;
        ctx.fillStyle = '#888'; ctx.font = '10px Arial'; ctx.textAlign = 'center';
        ctx.fillText(month, cx, H - padB + 14);
    });
<<<<<<< HEAD

=======
>>>>>>> origin/main
    ctx.strokeStyle = '#ddd'; ctx.lineWidth = 1;
    ctx.beginPath(); ctx.moveTo(padL, padT + chartH); ctx.lineTo(W - padR, padT + chartH); ctx.stroke();
}

document.getElementById('monthlyBarChart').addEventListener('mousemove', function(e) {
    var canvas = this, rect = canvas.getBoundingClientRect();
    var scaleX = canvas.width / rect.width, scaleY = canvas.height / rect.height;
    var mx = (e.clientX - rect.left) * scaleX, my = (e.clientY - rect.top) * scaleY;
<<<<<<< HEAD
    var ctx = canvas.getContext('2d');
    var W = canvas.width, H = canvas.height;
=======
    var ctx = canvas.getContext('2d'), W = canvas.width, H = canvas.height;
>>>>>>> origin/main
    var padL = barChartData.padL, padR = barChartData.padR, padT = barChartData.padT, padB = barChartData.padB;
    var chartW = W - padL - padR, chartH = H - padT - padB;
    var groupW = chartW / barChartData.activeMonths.length;
    var barW = Math.min(groupW * 0.28, 22), gap = 5;
    var tooltip = document.getElementById('barTooltip');
    var foundM = -1, foundBar = -1, foundVal = 0, foundLabel = '';
<<<<<<< HEAD

=======
>>>>>>> origin/main
    barChartData.activeMonths.forEach(function(month, idx) {
        var d = barChartData.monthData[month];
        var cx = padL + idx * groupW + groupW / 2;
        var bx1 = cx - barW - gap / 2, bx2 = cx + gap / 2;
        var incH = (d.income / barChartData.maxVal) * chartH;
        var sptH = (d.spent / barChartData.maxVal) * chartH;
        if (mx >= bx1 && mx <= bx1 + barW && my >= padT + chartH - incH && my <= padT + chartH) { foundM = idx; foundBar = 0; foundVal = d.income; foundLabel = 'Income'; }
        if (mx >= bx2 && mx <= bx2 + barW && my >= padT + chartH - sptH && my <= padT + chartH) { foundM = idx; foundBar = 1; foundVal = d.spent; foundLabel = 'Spent'; }
    });
<<<<<<< HEAD

=======
>>>>>>> origin/main
    renderBarChart(ctx, W, H, foundM, foundBar);
    if (foundM !== -1) {
        var color = foundBar === 0 ? '#2B5CE6' : '#4fc3f7';
        tooltip.innerHTML = '<span style="display:inline-block;width:9px;height:9px;border-radius:2px;background:'+color+';margin-right:6px;vertical-align:middle;"></span><strong>'+barChartData.activeMonths[foundM]+' — '+foundLabel+'</strong><br>'+foundVal.toFixed(2)+' TND';
        tooltip.style.display = 'block';
        tooltip.style.left = (e.clientX - rect.left + 12) + 'px';
        tooltip.style.top = (e.clientY - rect.top - 10) + 'px';
    } else { tooltip.style.display = 'none'; }
});

document.getElementById('monthlyBarChart').addEventListener('mouseleave', function() {
    renderBarChart(this.getContext('2d'), this.width, this.height, -1, -1);
    document.getElementById('barTooltip').style.display = 'none';
});

function roundRect(ctx, x, y, w, h, r) {
    if (h <= 0) h = 1;
    if (h < r*2) r = h/2;
    ctx.beginPath();
    ctx.moveTo(x + r, y); ctx.lineTo(x + w - r, y);
    ctx.quadraticCurveTo(x + w, y, x + w, y + r);
    ctx.lineTo(x + w, y + h); ctx.lineTo(x, y + h);
    ctx.lineTo(x, y + r); ctx.quadraticCurveTo(x, y, x + r, y);
    ctx.closePath();
}

<<<<<<< HEAD
// ── Init Charts ──
=======
>>>>>>> origin/main
drawPieChart(chartExpenses, chartSavings, chartRemaining);
drawBarChart(allIncomesData, allExpensesData);
</script>
@endsection
