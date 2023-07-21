@extends ('layouts.app')

@section ('title','Leaderboard')

@section ('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-chart-bar"></i>
            </span> Leaderboard
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route("dashboard") }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    Leaderboard
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body table-responsive"  x-data="{activeTab: 'week'}">
                    <div class="mt-4 py-2">
                        <ul class="nav nav-tabs profile-navbar" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" x-bind:class="activeTab == 'week' ? 'active' : ''"
                                    href="#week" x-on:click.prevent="activeTab = 'week'">
                                    <i class="mdi mdi-account-outline"></i> This week </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    x-bind:class="activeTab == 'month' ? 'show active' : ''"
                                    href="#month" x-on:click.prevent="activeTab = 'month'">
                                    <i class="mdi mdi-newspaper"></i> This month </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    x-bind:class="activeTab == 'year' ? 'show active' : ''"
                                    href="#year" x-on:click.prevent="activeTab = 'year'">
                                    <i class="mdi mdi-calendar"></i> This year </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" x-bind:class="activeTab == 'lifetime' ? 'show active' : ''"
                                    href="#lifetime" x-on:click.prevent="activeTab = 'lifetime'">
                                    <i class="mdi mdi-attachment"></i> lifetime </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content profile-feed pl-2">
                        <div x-bind:class="activeTab == 'week' ? 'show active' : ''" x-transition
                            class="tab-pane fade" id="week" role="tabpanel"
                            aria-labelledby="week-tab">
                            <h1 class="display-2 mt-3 mb-3">This week leaders</h1>
                            @include("rewards.listing", ["records" => $leaderboard["this_week"]])
                        </div>
                        <div x-bind:class="activeTab == 'month' ? 'show active' : ''" x-transition
                            class="tab-pane fade" id="month" role="tabpanel"
                            aria-labelledby="month-tab">
                            <h1 class="display-2 mt-3 mb-3">This month leaders</h1>
                            @include("rewards.listing", ["records" => $leaderboard["this_month"]])
                        </div>
                        <div x-bind:class="activeTab == 'year' ? 'show active' : ''" x-transition
                            class="tab-pane fade" id="year" role="tabpanel"
                            aria-labelledby="year-tab">
                            <h1 class="display-2 mt-3 mb-3">This year leaders</h1>
                            @include("rewards.listing", ["records" => $leaderboard["this_year"]])
                        </div>
                        <div x-bind:class="activeTab == 'lifetime' ? 'show active' : ''" x-transition
                            class="tab-pane fade" id="lifetime" role="tabpanel" aria-labelledby="lifetime-tab">
                            <h1 class="display-2 mt-3 mb-3">Lifetime leaders</h1>
                            @include("rewards.listing", ["records" => $leaderboard["lifetime"]])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push ("js")
    <script>
        removeItem = function(id){
            swal({
                title: "Are you sure?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (!isConfirm) return;
                alert("please add delete function here.");
                // Livewire.emitTo('subscription-plan-component','delete',id);
            });
        }
    </script>
@endpush
