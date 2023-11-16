@extends('layouts.main')
@section('content')
    <div class="row mb-3">
        <div class="card mb-12 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal">URLs List</h4>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                @elseif (Session::has('error'))
                    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                @endif
                <form class="row row-cols-md-auto g-3 align-items-end py-3" method="get" action="{{ route('url.list') }}">
                    <div class="col-sm-7">
                        <input type="text" name="query" id="id" class="form-control" placeholder="Searching...." value="{{ request()->has('query') ? request()->get('query') : '' }}">
                    </div>
                    <div class="col-sm">
                        <select class="form-select" name="order">
                            <option value="">Select An Option</option>
                            <option value="asc" @if(!empty(request()->has('order')) && request()->get('order') == 'asc') selected @endif>Ascending</option>
                            <option value="desc" @if(!empty(request()->has('order')) && request()->get('order') == 'desc') selected @endif>Descending</option>
                        </select>
                    </div>
                    <div class="col-sm">
                        <button type="submit" class="btn btn-success btn-active-light-success">Show Results</button>
                    </div>
                    <div class="col-sm">
                        <a href="{{ route('url.list') }}" class="btn btn-warning btn-active-light-warning">Reset Parameters</a>
                    </div>
                </form>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Domain Name</th>
                        <th scope="col">Url</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($urls as $key => $item)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $item->domain->name }}</td>
                            <td>
                                <a href="{{ $item->url }}" target="_blank">{{ $item->url }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $urls->withQueryString()->links('vendor.pagination.index') !!}
            </div>
        </div>
    </div>
@stop
