<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('assets/images/faces/man.png') }}" alt="profile">
                    {{-- <i class="mdi mdi-user"></i> --}}
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
                    <span class="text-secondary text-small">Admin</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('habbits.category') }}">
                <span class="menu-title">Category</span>
                <i class="mdi mdi-format-list-bulleted-type  menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('contact-us.index') }}">
                <span class="menu-title">Contact Us</span>
                <i class="mdi mdi-contact-mail-outline  menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{request()->is("daily-journal/*") ? 'active' : ''}}">
            <a class="nav-link" href="{{ route("daily-journal.index") }}">
                <span class="menu-title">Daily Journal </span>
                <i class="mdi mdi-forum menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('habbits.index') }}">
                <span class="menu-title">Habits</span>
                <i class="mdi mdi-repeat menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{request()->is("leaderboard/*") ? 'active' : ''}}">
            <a class="nav-link" href="{{ route("leaderboard") }}">
                <span class="menu-title">Leaderboard </span>
                <i class="mdi mdi-chart-bar menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{request()->is("onboarding-responses/*") ? 'active' : ''}}">
            <a class="nav-link" href="{{ route("users.responses") }}">
                <span class="menu-title">Onboarding </span>
                <i class="mdi mdi-forum menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{request()->is("push-notifications/*") ? 'active' : ''}}">
            <a class="nav-link" href="{{ route("push-notification.index") }}">
                <span class="menu-title">Push Notifications </span>
                <i class="mdi mdi-bell menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#questions" aria-expanded="false" aria-controls="questions">
              <span class="menu-title">Questions</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-comment-question-outline menu-icon"></i>
            </a>
            <div class="collapse" id="questions">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('questions.index') }}">View </a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('questions.add') }}"> Add Question </a></li>
              </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#group-questions" aria-expanded="false" aria-controls="group-questions">
              <span class="menu-title">Question Group</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-comment-question-outline menu-icon"></i>
            </a>
            <div class="collapse" id="group-questions">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('questions-group.index') }}">Manage Groups </a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('questions-group.add') }}"> Add Question Group</a></li>
              </ul>
            </div>
        </li>
        <li class="nav-item {{request()->is("self-assessment-responses/*") ? 'active' : ''}}">
            <a class="nav-link" href="{{ route("users.self-assessment-responses") }}">
                <span class="menu-title">Self Assessment </span>
                <i class="mdi mdi-forum menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route("subscription-plan") }}">
                <span class="menu-title">Subscription Plans</span>
                <i class="mdi mdi-calendar-clock menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{request()->is("users/*") ? 'active' : ''}}">
            <a class="nav-link" href="{{ route("users.index") }}">
                <span class="menu-title">Users</span>
                <i class="mdi mdi-account-group menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route("change-password") }}">
                <span class="menu-title">Change Password</span>
                <i class="mdi mdi-lock menu-icon"></i>
            </a>
        </li>

    </ul>
</nav>
