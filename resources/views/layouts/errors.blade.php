@if (count($errors) > 0)
<div class="alert alert-danger" role="alert">
    <h4 class="alert-heading">خطا ها</h4>
    <div class="errors-container">
        <ul>
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>
</div>
@endif