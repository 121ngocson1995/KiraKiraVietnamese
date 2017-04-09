@extends('layouts.app')

@section('body')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                    You'll be redirected in 3 seconds.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        setTimeout(function () {
            window.location.href = '/';
        }, 3000)
    })();
</script>
@endsection
