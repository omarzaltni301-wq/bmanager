@extends('layouts.guest')

@section('title', 'Home')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home_style.css') }}">
@endsection

@section('content')
    <div class="container">

        <section class="hero">
            <div class="warning-tag">&#9888; Understanding Inflation in Tunisia</div>
            <h1>Stay Informed About <br> <span class="blue-text">Price Changes</span></h1>
            <p>BMANAGER helps you understand inflation's impact on your daily life. Access current prices, compare costs, and plan your budget effectively with reliable information from official Tunisian sources.</p>

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
                        <span class="icon blue-icon">{{ $icons[$category] ?? '📦' }}</span> <b>{{ $category }}</b>
                    </div>
                    @foreach($items as $item)
                    <div class="price-row">
                        <div class="price-label"><span class="dot {{ $item->source == 'Official' ? 'green' : 'orange' }}"></span> {{ $item->item_name }}</div>
                        <div class="price-value">{{ number_format($item->price, 3) }} TND</div>
                    </div>
                    @endforeach
                </div>
                @endforeach
                <div class="clear"></div>
            </div>

            <div class="info-box">
                <p><b>&#9432; Data Accuracy & Updates</b><br>
                All prices are verified from reliable Tunisian sources. Prices are updated weekly.</p>
            </div>

        </section>

    </div>
@endsection
