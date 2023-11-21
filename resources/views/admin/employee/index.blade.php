@extends('admin.layouts.layout')

@section('title', 'Employee Listing')

@section('content')
    <div class="jumbotron">
        <div class="container mt-4">

            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="">
                            <h1>Employee List</h1>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <div class="text-right">
                            @if(auth()->user()->can('add employee'))
                                <a href="{{route('employee.create')}}" class="btn btn-dark"> <i
                                        class="bi bi-plus-circle-dotted"></i> Add New Employee</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <hr/>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Employee ID</th>
                    <th scope="col">Email</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody id="employee-list">
                </tbody>
            </table>
            <div id="pagination" class="text-center gap-1">

            </div>
        </div>

    </div>

    <script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/employee.js') }}"></script>

@endsection
