@extends('layouts.main')
@section('content')
    <div class="row mb-3">
        <div class="card mb-12 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal">Create URLs</h4>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                @elseif (Session::has('error'))
                    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                @endif
                <form id="form" method="post" action="{{ route('url.store') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="mb-3">
                        <label for="url" class="form-label">Example textarea</label>
                        <textarea class="form-control @if($errors->has('url')) is-invalid @endif" id="url" rows="3"
                                  data-parsley-required="true" name="url"></textarea>
                        @if($errors->has('url'))
                            <div class="invalid-feedback">{{ $errors->first('url') }}</div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-lg btn-outline-primary">Sign up for free</button>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $('#form').parsley();
        $(document).ready(function () {
            $('#form').parsley();
        });
    </script>
@stop
