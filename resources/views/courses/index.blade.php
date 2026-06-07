@extends('layouts.premium')

@section('title', 'Courses - Raya Studio')

@section('styles')
    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 20px;
        }

        .page-header h1 {
            margin-bottom: 0;
            background: linear-gradient(135deg, #fff 30%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header-actions {
            display: flex;
            gap: 15px;
        }

        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        .course-card {
            padding: 30px 25px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .course-icon {
            font-size: 44px;
            margin-bottom: 20px;
            color: var(--primary);
            filter: drop-shadow(0 0 10px var(--primary-soft));
        }

        .course-card h3 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--text-primary);
        }

        .course-card p {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .course-price {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
            margin: auto 0 20px 0;
            font-family: var(--font-heading);
        }

        .course-card .btn {
            width: 100%;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }
            .header-actions {
                width: 100%;
            }
            .header-actions .btn {
                flex: 1;
            }
            .course-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1>All Available Courses</h1>
        <div class="header-actions">
            <a href="{{ route('dashboard.customer') }}" class="btn btn-secondary">← Dashboard</a>
            <a href="{{ route('courses.my') }}" class="btn btn-primary">My Class</a>
        </div>
    </div>

    @if($courses->count() > 0)
        <div class="course-grid">
            @foreach($courses as $course)
                <div class="course-card glass-card">
                    <div class="course-icon">🎓</div>
                    <h3>{{ $course->name }}</h3>
                    <p>{{ Str::limit($course->description, 120) }}</p>
                    <div class="course-price">
                        <span class="price-premium">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('payment.product', $course->id) }}" class="btn btn-primary">Enroll Now</a>
                </div>
            @endforeach
        </div>
    @else
        <div class="glass-card" style="text-align: center; padding: 60px; color: var(--text-secondary);">
            <p>Belum ada course yang tersedia</p>
        </div>
    @endif
@endsection
