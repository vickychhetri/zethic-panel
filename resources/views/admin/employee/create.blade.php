@extends('admin.layouts.layout')

@section('title', 'Employee Create')
@section('linksscript')
    {{--    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>--}}

@endsection

<!-- Your custom JavaScript -->

@section('content')
    <div class="jumbotron">
        <div class="container mt-4">

            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="">
                            <h1>Add New Employee</h1>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <div class="text-right">
                            <a href="#" class="btn btn-dark"> <i class="bi bi-plus-circle-dotted"></i> Add New Employee</a>
                        </div>
                    </div>
                </div>
            </div>

            <hr/>
            <div class="container mt-5">
                <form id="employeeForm" method="post">

                    <div class="row">

                        <!-- First Column -->
                        <div class="col-md-6">

                            <!-- Employee Name -->
                            <div class="form-group">
                                <label for="employeeName">Employee Name</label>
                                <input type="text" class="form-control" id="employeeName" name="name"
                                       placeholder="Enter employee name" required>
                            </div>

                            <!-- Employee ID -->
                            <div class="form-group">
                                <label for="employeeID">Employee ID</label>
                                <input type="text" class="form-control" id="employeeID" name="employee_id"
                                       placeholder="Enter employee ID" required>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="Enter email" required>
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Enter password" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                       name="password_confirmation" placeholder="Enter password" required>
                            </div>
                        </div>

                        <!-- Second Column -->
                        <div class="col-md-6">

                            <!-- Building Number -->
                            <div class="form-group">
                                <label for="buildingNo">Building Number</label>
                                <input type="text" class="form-control" id="buildingNo" name="building_no"
                                       placeholder="Enter building number" required>
                            </div>

                            <!-- Street Name -->
                            <div class="form-group">
                                <label for="streetName">Street Name</label>
                                <input type="text" class="form-control" id="streetName" name="street_name"
                                       placeholder="Enter street name" required>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control" id="city" name="city"
                                               placeholder="Enter city" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control" id="state" name="state"
                                               placeholder="Enter state" required>
                                    </div>
                                </div>
                            </div>
                            <!-- City -->


                            <!-- State -->


                            <!-- Country -->
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" name="country"
                                       placeholder="Enter country" required>
                            </div>

                            <!-- Pincode -->
                            <div class="form-group">
                                <label for="pincode">Pincode</label>
                                <input type="text" class="form-control" id="pincode" name="pincode"
                                       placeholder="Enter pincode" required>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex justify-content-center gap-2">
                        <div class="">
                            <button type="submit" id="submitForm" class="btn btn-success mt-4 ">Submit</button>
                        </div>
                        <div>
                            <a type="submit" class="btn btn-dark mt-4" href="{{route('employee.index')}}">Back to Listing</a>
                        </div>
                    </div>
                    <!-- Submit Button -->


                </form>
            </div>

        </div>

    </div>

    <script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/notify.js') }}"></script>
    <script src="{{ asset('js/employee.js') }}"></script>

@endsection
