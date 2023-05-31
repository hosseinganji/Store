@if (count($errors) > 0)
    <div class="alert alert-danger text-right" role="alert">
        <div class="errors-container">
            @foreach ($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    </div>
@endif
