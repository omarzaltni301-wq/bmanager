@extends('layouts.guest')

@section('title', 'Budget Tips & Money Management')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/budget_tips.css') }}">
@endsection

@section('content')
    <section class="page-header">
        <div class="header-icon">💡</div>
        <h1>Budget Tips & Money Management</h1>
        <p>Practical advice for Tunisian households to save money and manage your budget better</p>
    </section>

    <main class="main-content">
        <article class="tip-card">
            <div class="tip-header">
                <div class="tip-icon">💰</div>
                <div class="tip-title-section">
                    <h2>The 50/30/20 Rule</h2>
                    <span class="tip-category">Saving Strategies</span>
                </div>
            </div>
            <p class="tip-description">Organize your monthly income effectively:</p>
            <ul class="tip-list">
                <li>50% for essential needs (rent, food, utilities, transportation)</li>
                <li>30% for leisure and non-essential spending</li>
                <li>20% for saving and debt repayment</li>
            </ul>
            <p class="tip-description">This method makes you maintain a balanced budget while building savings for the future.</p>
            <div class="quick-tips">
                <h4>Quick Tips:</h4>
                <ul>
                    <li>Track your monthly income and expenses</li>
                    <li>Adjust percentages based on your personal situation</li>
                    <li>Start with saving even 10% if 20% feels too much</li>
                </ul>
            </div>
        </article>

        <article class="tip-card">
            <div class="tip-header">
                <div class="tip-icon">🛒</div>
                <div class="tip-title-section">
                    <h2>Grocery Shopping Tips</h2>
                    <span class="tip-category">Smart Shopping</span>
                </div>
            </div>
            <p class="tip-description">Reduce your food expenses without sacrificing quality</p>
            <ul class="tip-list">
                <li>Make a shopping list before going to the market and stick to it</li>
                <li>Compare prices between different stores or markets</li>
                <li>Buy seasonal and local products—they're cheaper</li>
                <li>Consider buying in bulk for non-perishable items</li>
                <li>Avoid shopping when hungry to prevent impulse purchases</li>
            </ul>
            <div class="quick-tips">
                <h4>Quick Tips:</h4>
                <ul>
                    <li>Visit local markets for better deals</li>
                    <li>Shop later in the day for fresh produce discounts</li>
                    <li>Meal plan before you shop to avoid waste</li>
                </ul>
            </div>
        </article>

        <article class="tip-card">
            <div class="tip-header">
                <div class="tip-icon">💡</div>
                <div class="tip-title-section">
                    <h2>Reduce Electricity Costs</h2>
                    <span class="tip-category">Utilities Management</span>
                </div>
            </div>
            <p class="tip-description">Save on electricity bills with these simple tips:</p>
            <ul class="tip-list">
                <li>Use energy-efficient LED bulbs</li>
                <li>Unplug devices when not in use (TVs, chargers, computers)</li>
                <li>Use air conditioning wisely—set at 25-26°C instead of very cold</li>
                <li>Take advantage of natural light during the day</li>
                <li>Maintain your refrigerator—don't overload and clean coils often</li>
            </ul>
            <div class="quick-tips">
                <h4>Quick Tips:</h4>
                <ul>
                    <li>Use ceiling fans along with AC to circulate air better</li>
                    <li>Iron clothes in batches to save energy</li>
                    <li>Use natural light and avoid switching on lights in the day</li>
                </ul>
            </div>
        </article>

        <article class="tip-card">
            <div class="tip-header">
                <div class="tip-icon">📋</div>
                <div class="tip-title-section">
                    <h2>Budget Planning System</h2>
                    <span class="tip-category">Monthly Planning</span>
                </div>
            </div>
            <p class="tip-description">Create a monthly budget that works!</p>
            <ul class="tip-list">
                <li>List all income sources at the start of the month</li>
                <li>Write down all fixed expenses (rent, loans, subscriptions, insurance)</li>
                <li>Estimate variable expenses (food, transportation, utilities)</li>
                <li>Set aside emergency funds</li>
                <li>Review and adjust at the end of the month</li>
            </ul>
            <div class="quick-tips">
                <h4>Quick Tips:</h4>
                <ul>
                    <li>Include approximately 5% extra for unexpected expenses</li>
                    <li>Set monthly goals—don't just track and forget</li>
                    <li>Use weekly check-ins to see how you're doing</li>
                </ul>
            </div>
        </article>

        <article class="tip-card">
            <div class="tip-header">
                <div class="tip-icon">🚗</div>
                <div class="tip-title-section">
                    <h2>Transportation Savings</h2>
                    <span class="tip-category">Public & Personal</span>
                </div>
            </div>
            <p class="tip-description">Reduce transportation costs:</p>
            <ul class="tip-list">
                <li>Carpool with colleagues or neighbors when possible</li>
                <li>Plan your rides to combine multiple errands</li>
                <li>Consider public transportation—cheaper than fuel</li>
                <li>Maintain your car regularly to prevent fuel efficiency</li>
                <li>Walk or bike for short distances</li>
            </ul>
            <div class="quick-tips">
                <h4>Quick Tips:</h4>
                <ul>
                    <li>Keep tires properly inflated to save fuel</li>
                    <li>Avoid aggressive driving—smooth acceleration saves gas</li>
                    <li>Compare fuel prices at different stations</li>
                </ul>
            </div>
        </article>
    </main>
@endsection
