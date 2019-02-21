<div class="show-notice">
    @if (Session::has('success'))
        <div class="alert alert-success alert-message">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger alert-message alert-error-profile">
            {{ Session::get('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-message alert-error-profile">
            <span>{{ $errors->first() }}</span><br>
        </div>
    @endif
</div>
