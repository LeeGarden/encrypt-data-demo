@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Choose table to encrypt/decrypt data</h3>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Table name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list_table as $table)
                                <tr>
                                    <td>{{ $table }}</td>
                                    <td>
                                        <a href="{{ route('show-column-encrypt', $table) }}" class="btn btn-default">Encrypt</a>
                                        <a href="{{ route('show-column-decrypt', $table) }}" class="btn btn-primary">Decrypt</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
