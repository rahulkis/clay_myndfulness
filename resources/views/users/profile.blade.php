@extends ('layouts.app')

@section ('title','User profile : '. $user->name)

@section ('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-account-group"></i>
            </span> User profile : {{ $user->name }}
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route("dashboard") }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    User profile
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="border-bottom text-center pb-4">
                                <img src="{{ $user->avatar ?? asset('assets/images/faces/man.png') }}"
                                    alt="profile" class="img-lg rounded-circle mb-3">
                                <p>
                                    Last active on <span
                                        class="font-italic">{{ $user->tokens->sortBy("last_used_at")->last()->last_used_at->diffForHumans() }}</span>
                                </p>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-gradient-success mr-2">
                                        <x-medal-icon height="30" width="30" /> {{ $user->total_medals }}
                                        MEDALS</button>
                                    <button class="btn btn-gradient-success">
                                        <x-coin-icon height="24" width="24" /> {{ $user->total_coins }} COINS
                                    </button>
                                </div>
                            </div>
                            <div class="py-4">
                                <p class="clearfix">
                                    <span class="float-left"> Status </span>
                                    <span class="float-right text-muted">
                                        {{ !$user->deleted_at ? "Active" :"In Active" }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left"> Package will Expire on </span>
                                    <span class="float-right text-muted">
                                        {{ ($user->activePlan && $user->activePlan->price != 0) ? niceDate($user->activePlan->end_date) : 'Lifetime' }}</span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left"> Habits </span>
                                    <span class="float-right text-muted"> {{$habbits_active}}/{{$habbits_total}} </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left"> Self Assessment </span>
                                    <span class="float-right text-muted"> {{$self_assesment_count}} </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left"> Daily Journal </span>
                                    <span class="float-right text-muted"> {{$daily_journal_count}}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-8" x-data="{activeTab: 'onboarding'}">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3>{{ $user->name }}
                                        @if($user->activePlan && $user->activePlan->price != 0)
                                        <strong class="premium">Premium User</strong>
                                        @else
                                        Free User
                                        @endif
                                        <svg data-toggle="modal" data-target="#viewPlan" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><g fill="currentColor"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M8.93 6.588l-2.29.287l-.082.38l.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319c.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246c-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0a1 1 0 0 1 2 0z"/></g></svg>
                                    </h3>
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 mr-2 text-muted">{{ $user->email }}</h5>
                                        <div class="br-wrapper br-theme-css-stars"><select id="profile-rating"
                                                name="rating" autocomplete="off" style="display: none;">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                            <div class="br-widget"><a href="#" data-rating-value="1"
                                                    data-rating-text="1" class="br-selected br-current"></a><a href="#"
                                                    data-rating-value="2" data-rating-text="2"></a><a href="#"
                                                    data-rating-value="3" data-rating-text="3"></a><a href="#"
                                                    data-rating-value="4" data-rating-text="4"></a><a href="#"
                                                    data-rating-value="5" data-rating-text="5"></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 py-2">
                                <ul class="nav nav-tabs profile-navbar" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" x-bind:class="activeTab == 'onboarding' ? 'active' : ''"
                                            href="#onboarding" x-on:click.prevent="activeTab = 'onboarding'">
                                            <i class="mdi mdi-account-outline"></i> Onboarding Response </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            x-bind:class="activeTab == 'daily-journal' ? 'show active' : ''"
                                            href="#daily-journal" x-on:click.prevent="activeTab = 'daily-journal'">
                                            <i class="mdi mdi-newspaper"></i> Daily Journal </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            x-bind:class="activeTab == 'self-assessment' ? 'show active' : ''"
                                            href="#self-assessment" x-on:click.prevent="activeTab = 'self-assessment'">
                                            <i class="mdi mdi-calendar"></i> Self Assessment </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" x-bind:class="activeTab == 'payment' ? 'show active' : ''"
                                            href="#payment" x-on:click.prevent="activeTab = 'payment'">
                                            <i class="mdi mdi-attachment"></i> Payment History </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content profile-feed pl-2">
                                <div x-bind:class="activeTab == 'onboarding' ? 'show active' : ''" x-transition
                                    class="tab-pane fade vh-100 overflow-auto" id="onboarding" role="tabpanel"
                                    aria-labelledby="onboarding-tab">
                                    @if ($user->onboarding_responses->count())
                                        <table class="table table-condense table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Question</th>
                                                    <th>Response</th>
                                                </tr>
                                                @foreach ($user->onboarding_responses as $response)
                                                    <tr>
                                                        <td>{{ $response->question }}</td>
                                                        <td class="py-0">
                                                            <ol>
                                                                @foreach ($response->options as $item)
                                                                    <li>{{ $item }}</li>
                                                                @endforeach
                                                            </ol>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </thead>
                                        </table>
                                    @else
                                        <h4>Onboarding not yet completed.</h4>
                                    @endif
                                </div>
                                <div x-bind:class="activeTab == 'daily-journal' ? 'show active' : ''" x-transition
                                    class="tab-pane fade vh-100 overflow-auto" id="daily-journal" role="tabpanel"
                                    aria-labelledby="daily-journal-tab">
                                    @livewire('users.daily-journal-responses-list', ['user_id' => $user->id,'show_filter' => false,'single_user' => true], key('journal-responses'.$user->id))

                                </div>
                                <div x-bind:class="activeTab == 'self-assessment' ? 'show active' : ''" x-transition
                                    class="tab-pane fade vh-100 overflow-auto" id="self-assessment" role="tabpanel"
                                    aria-labelledby="self-assessment-tab">
                                    @livewire('users.self-assessment-responses-list', ['user_id' => $user->id,'show_filter' => false,'single_user' => true], key('journal-responses'.$user->id))

                                </div>
                                <div x-bind:class="activeTab == 'payment' ? 'show active' : ''" x-transition
                                    class="tab-pane fade vh-100 overflow-auto" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                                    <h4>Coming soon</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewPlan" tabindex="-1" role="dialog" aria-labelledby="addPlanModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @livewire('users.profile.view-plan', ['user_id' => $user->id], key($user->id))
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
