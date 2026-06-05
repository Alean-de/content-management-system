@include('partials.head')
@include('partials.navbar')

<h2>Profile Settings</h2>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<hr>

<h3>Change Name</h3>

<form action="{{ route('administrator.profile.name') }}"
      method="POST">

    @csrf
    @method('PUT')

    <div>
        <label>Name</label>
        <input type="text"
               name="name"
               value="{{ auth()->user()->name }}"
               required>
    </div>

    <button type="submit">
        Update Name
    </button>

</form>

<hr>

<h3>Change Email</h3>

<form action="{{ route('administrator.profile.email') }}"
      method="POST">

    @csrf
    @method('PUT')

    <div>
        <label>Email</label>
        <input type="email"
               name="email"
               value="{{ auth()->user()->email }}"
               required>
    </div>

    <button type="submit">
        Update Email
    </button>

</form>

<hr>

<h3>Change Password</h3>

<form action="{{ route('administrator.profile.password') }}"
      method="POST">

    @csrf
    @method('PUT')

    <div>
        <label>Current Password</label>
        <input type="password"
               name="current_password"
               required>
    </div>

    <div>
        <label>New Password</label>
        <input type="password"
               name="password"
               required>
    </div>

    <div>
        <label>Confirm Password</label>
        <input type="password"
               name="password_confirmation"
               required>
    </div>

    <button type="submit">
        Update Password
    </button>

</form>

<hr>

<form action="{{ route('administrator.logout') }}"
      method="POST">

    @csrf

    <button type="submit">
        Logout
    </button>

</form>

@include('partials.foot')