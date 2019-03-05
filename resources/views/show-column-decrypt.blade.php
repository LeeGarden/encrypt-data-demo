@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Choose column for <span class="text-danger">Decrypt</span></h3>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('start-decrypt') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="table_name" value="{{ $table_name }}">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Column name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list_column as $column)
                                    <tr>
                                        <td>{{ $column }}</td>
                                        <td class="">
                                            <input name="column[]" type="checkbox" value="{{ $column }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-lg-offset-4 col-lg-6">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmModal">Start Decrypt</button>
                        </div>
                        <div class="modal fade" id="confirmModal" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Confirm Dialog Box</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>We will start decrypt data. Are you sure?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Yes</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
