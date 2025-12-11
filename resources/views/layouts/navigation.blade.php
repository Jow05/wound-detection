<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>

        <div>
            <a class="btn btn-outline-primary" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="btn btn-outline-secondary" href="{{ route('doctors.index') }}">Doctors</a>
            <a class="btn btn-outline-secondary" href="{{ route('wounds.index') }}">Wounds</a>
        </div>
    </div>
</nav>
