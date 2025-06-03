@extends('layouts.app')

@section('content')
<div class="title-wrapper pt-30">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="title mb-30 d-flex align-items-center gap-2">
                <i class="bi bi-house-door-fill fs-3 text-primary"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Greeting -->
    <div class="col-md-6 mb-4">
        <div class="card bg-light border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <i id="greeting-icon" class="bi bi-sun-fill fs-1 text-warning"></i>
                </div>
                <div>
                    <h4 class="mb-1" id="greeting">Good Day</h4>
                    <p class="mb-0">Welcome back, <strong>{{ Auth::user()->name }}</strong>!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Analog Clock -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm text-center">
            <div class="card-header bg-white fw-bold">Current Time</div>
            <div class="card-body">
                <canvas id="clock" width="200" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    #clock {
        background: #f8f9fa;
        border: 4px solid #ced4da;
        border-radius: 50%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        display: block;
        margin: 0 auto;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const greetingEl = document.getElementById('greeting');
        const iconEl = document.getElementById('greeting-icon');
        const hour = new Date().getHours();

        let message = 'Good Day';
        let icon = 'bi-sun-fill';
        let color = 'text-warning';

        if (hour >= 5 && hour < 12) {
            message = 'Good Morning';
            icon = 'bi-sun-fill';
            color = 'text-warning';
        } else if (hour >= 12 && hour < 17) {
            message = 'Good Afternoon';
            icon = 'bi-cloud-sun-fill';
            color = 'text-primary';
        } else if (hour >= 17 && hour < 20) {
            message = 'Good Evening';
            icon = 'bi-cloud-moon-fill';
            color = 'text-secondary';
        } else {
            message = 'Good Night';
            icon = 'bi-moon-stars-fill';
            color = 'text-dark';
        }

        greetingEl.textContent = `${message}, {{ Auth::user()->name }}`;
        iconEl.className = `bi ${icon} fs-1 ${color}`;
    });

    // Analog Clock
    const canvas = document.getElementById("clock");
    const ctx = canvas.getContext("2d");
    const radius = canvas.height / 2;
    ctx.translate(radius, radius);
    setInterval(drawClock, 1000);

    function drawClock() {
        drawFace(ctx, radius);
        drawNumbers(ctx, radius);
        drawTime(ctx, radius);
    }

    function drawFace(ctx, radius) {
        ctx.beginPath();
        ctx.arc(0, 0, radius, 0, 2 * Math.PI);
        ctx.fillStyle = "#fff";
        ctx.fill();

        const grad = ctx.createRadialGradient(0, 0, radius * 0.95, 0, 0, radius * 1.05);
        grad.addColorStop(0, "#ddd");
        grad.addColorStop(0.5, "#fff");
        grad.addColorStop(1, "#ddd");

        ctx.strokeStyle = grad;
        ctx.lineWidth = radius * 0.1;
        ctx.stroke();

        ctx.beginPath();
        ctx.arc(0, 0, radius * 0.05, 0, 2 * Math.PI);
        ctx.fillStyle = "#000";
        ctx.fill();
    }

    function drawNumbers(ctx, radius) {
        ctx.font = radius * 0.15 + "px Arial";
        ctx.textBaseline = "middle";
        ctx.textAlign = "center";
        for (let num = 1; num <= 12; num++) {
            const ang = num * Math.PI / 6;
            ctx.rotate(ang);
            ctx.translate(0, -radius * 0.85);
            ctx.rotate(-ang);
            ctx.fillText(num.toString(), 0, 0);
            ctx.rotate(ang);
            ctx.translate(0, radius * 0.85);
            ctx.rotate(-ang);
        }
    }

    function drawTime(ctx, radius) {
        const now = new Date();
        let hour = now.getHours();
        let minute = now.getMinutes();
        let second = now.getSeconds();

        hour = hour % 12;
        hour = (hour * Math.PI / 6) +
               (minute * Math.PI / (6 * 60)) +
               (second * Math.PI / (360 * 60));
        drawHand(ctx, hour, radius * 0.5, radius * 0.07);

        minute = (minute * Math.PI / 30) + (second * Math.PI / (30 * 60));
        drawHand(ctx, minute, radius * 0.8, radius * 0.07);

        second = (second * Math.PI / 30);
        drawHand(ctx, second, radius * 0.9, radius * 0.02, "#dc3545");
    }

    function drawHand(ctx, pos, length, width, color = "#333") {
        ctx.beginPath();
        ctx.lineWidth = width;
        ctx.lineCap = "round";
        ctx.strokeStyle = color;
        ctx.moveTo(0, 0);
        ctx.rotate(pos);
        ctx.lineTo(0, -length);
        ctx.stroke();
        ctx.rotate(-pos);
    }
</script>
@endsection
