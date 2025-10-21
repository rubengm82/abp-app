@if (session('success'))
    <div class="toast toast-end">
        <div class="alert alert-success">
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

@if (session('info'))
    <div class="toast toast-end">
        <div class="alert alert-info">
            <span>{{ session('info') }}</span>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="toast toast-end">
        <div class="alert alert-error">
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif
@if (session('warning'))
    <div class="toast toast-end">
        <div class="alert alert-warning">
            <span>{{ session('warning') }}</span>
        </div>
    </div>
@endif