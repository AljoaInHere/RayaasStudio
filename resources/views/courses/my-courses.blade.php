@extends('layouts.premium')

@section('title', 'My Courses - Raya Studio')

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

        .course-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        .course-item {
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }

        .course-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
        }

        .course-header h3 {
            font-size: 22px;
            font-weight: 700;
            margin-top: 10px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .course-body {
            padding: 25px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .course-body p {
            color: var(--text-secondary);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .progress-section {
            margin-top: auto;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary) 0%, var(--accent-cyan) 100%);
            width: 45%;
            border-radius: inherit;
            box-shadow: 0 0 10px rgba(0, 240, 255, 0.3);
            animation: fillAnim 1.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        @keyframes fillAnim {
            from { width: 0; }
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-state h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .empty-state a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .empty-state a:hover {
            color: #b372f9;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }
            .page-header .btn {
                width: 100%;
            }
            .course-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1>Course Saya</h1>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">← Lihat Semua Course</a>
    </div>

    @if($myCourses->count() > 0)
        <div class="course-list">
            @foreach($myCourses as $course)
                <div class="course-item glass-card">
                    <div class="course-header">
                        <div style="font-size: 40px;">🎓</div>
                        <h3>{{ $course->name }}</h3>
                    </div>
                    <div class="course-body">
                        <p>{{ Str::limit($course->description, 100) }}</p>
                        
                        <div class="progress-section">
                            <div class="progress-label">
                                <span>Progress Belajar</span>
                                <span>45% Complete</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state glass-card">
            <h2>📭 Belum Ada Course</h2>
            <p style="color: var(--text-secondary); margin-bottom: 20px; font-size: 15px;">Anda belum terdaftar di kelas manapun.</p>
            <a href="{{ route('courses.index') }}">Lihat kelas yang tersedia sekarang →</a>
        </div>
    @endif
@endsection
