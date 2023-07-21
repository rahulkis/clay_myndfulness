@extends ('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                    <i class="mdi mdi-home"></i>
                </span> Dashboard
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                    <a href="{{ route('users.index') }}" class="text-white">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                                alt="circle-image" />
                            <h4 class="font-weight-normal mb-3">Total users <i
                                    class="mdi mdi-chart-line mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5">{{ \App\Models\User::all()->count() }}</h2>
                            {{-- <h6 class="card-text">Increased by 60%</h6> --}}
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <a href="{{ route('habbits.index') }}" class="text-white">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                                alt="circle-image" />
                            <h4 class="font-weight-normal mb-3">Habits <i
                                    class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5">{{ App\Models\Habbit::all()->count() }}</h2>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                            alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Visitors Online <i
                                class="mdi mdi-diamond mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5">{{ $online_users }}</h2>
                        {{-- <h6 class="card-text">Increased by 5%</h6> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-warning card-img-holder text-white">
                    <a href="{{ route('questions.index') }}" class="text-white">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                                alt="circle-image" />
                            <h4 class="font-weight-normal mb-3">Questions <i
                                    class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5">{{ App\Models\Question::all()->count() }}</h2>
                            {{-- <h6 class="card-text">Decreased by 10%</h6> --}}
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-primary card-img-holder text-white">
                    <a href="{{ route('daily-journal.index') }}" class="text-white">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                                alt="circle-image" />
                            <h4 class="font-weight-normal mb-3">Daily Journal Response <i
                                    class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5">{{ App\Models\DailyJournalReponse::all()->count() }}</h2>
                            {{-- <h6 class="card-text">Decreased by 10%</h6> --}}
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-secondary card-img-holder text-white">
                    <a href="{{ route('users.self-assessment-responses') }}" class="text-white">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                                alt="circle-image" />
                            <h4 class="font-weight-normal mb-3">Self Assessment Response <i
                                    class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5">{{ App\Models\SelfAssessmentResponse::all()->count() }}</h2>
                            {{-- <h6 class="card-text">Decreased by 10%</h6> --}}
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-secondary card-img-holder text-white">
                    <a href="{{ route('habbits.category') }}" class="text-white">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                                alt="circle-image" />
                            <h4 class="font-weight-normal mb-3">Habit Categories <i
                                    class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5">{{ App\Models\HabitCategory::all()->count() }}</h2>
                            {{-- <h6 class="card-text">Decreased by 10%</h6> --}}
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
