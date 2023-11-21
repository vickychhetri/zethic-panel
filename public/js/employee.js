// public/js/employees.js

$(document).ready(function () {
    // Fetch and display employees on page load
    fetchdEmployees();

    // function fetchEmployees(page) {
    //     $.ajax({
    //         url: '/admin/employee',
    //         type: 'GET',
    //         dataType: 'json',
    //         success: function (data) {
    //             console.log(data.employees);
    //             displayEmployees(data.employees);
    //         },
    //         error: function (error) {
    //             console.error('Error fetching employees: ', error);
    //         }
    //     });
    // }


});

function fetchdEmployees(pageNumber = 1) {
    $.ajax({
        url: '/admin/employee/', // Replace with your Laravel API endpoint
        method: 'GET',
        data: {page: pageNumber}, // Send the page number as a parameter
        success: function (response) {
            // Once the data is successfully fetched
            displayEmployees(response.employees); // Display the fetched employees
        },
        error: function (xhr, status, error) {
            // Handle error, if any
            console.error(error);
        }
    });
}

function displayEmployees(emp) {
    let employees = emp.data;
    let employeeList = $('#employee-list');
    // Clear existing list items
    employeeList.empty();

    // Append new list items
    employees.forEach(function (employee) {
        employeeList.append('<tr>');
        employeeList.append('<td>' + employee.id + '</td>');
        employeeList.append('<td>' + employee.name + '</td>');
        employeeList.append('<td>' + employee.employee_id + '</td>');
        employeeList.append('<td>' + employee.email + '</td>');
        employeeList.append('<td>' + employee.created_at + '</td>');
        employeeList.append('<td> <a href="/admin/employee/' + employee.id + '"  class="btn btn-outline-dark"> details</a></td>');
        employeeList.append('</tr>');
    });

    let currentPage = emp.current_page;
    let totalPages = emp.last_page;

    // Create pagination buttons
    let pagination = $('#pagination');
    pagination.empty();

    // Previous button
    if (currentPage > 1) {
        pagination.append('<button onclick="fetchdEmployees(' + (currentPage - 1) + ')">Previous</button>');
    }
    pagination.append(' ');
    // Next button
    if (currentPage < totalPages) {
        pagination.append('<button onclick="fetchdEmployees(' + (currentPage + 1) + ')">Next</button>');
    }

}

// employee-validation.js

function validation_employee_form() {
    var valid = true;
    // Employee Name
    var employeeName = $("#employeeName").val().trim();
    if (employeeName === "") {
        valid = false;
        $.notify("Please enter Employee Name", "error");
    }

    // Employee ID
    var employeeID = $("#employeeID").val().trim();
    if (employeeID === "") {
        valid = false;
        $.notify("Please enter Employee ID", "error");
    }

    // Email
    var email = $("#email").val().trim();
    if (email === "") {
        valid = false;
        $.notify("Please enter Email", "error");
    }

    // Password
    var password = $("#password").val();
    if (password === "") {
        valid = false;
        $.notify("Please enter Password", "error");
    }
    if (password.length < 8) {
        valid = false;
        $.notify("Please enter minimum 8 character password", "error");
    }

    // Confirm Password
    var confirmPassword = $("#password_confirmation").val();
    if (confirmPassword === "" || confirmPassword !== password) {
        valid = false;
        $.notify("Passwords do not match", "error");
    }

    // Building Number
    var buildingNo = $("#buildingNo").val().trim();
    if (buildingNo === "") {
        valid = false;
        $.notify("Please enter Building Number", "error");
    }

    // Street Name
    var streetName = $("#streetName").val().trim();
    if (streetName === "") {
        valid = false;
        $.notify("Please enter Street Name", "error");
    }

    // City
    var city = $("#city").val().trim();
    if (city === "") {
        valid = false;
        $.notify("Please enter City", "error");
    }

    // State
    var state = $("#state").val().trim();
    if (state === "") {
        valid = false;
        $.notify("Please enter State", "error");
    }

    // Country
    var country = $("#country").val().trim();
    if (country === "") {
        valid = false;
        $.notify("Please enter Country", "error");
    }

    // Pincode
    var pincode = $("#pincode").val().trim();
    if (pincode === "" || !$.isNumeric(pincode)) {
        valid = false;
        $.notify("Please enter a valid Pincode", "error");
    }
    // If the form is valid, you can submit it
    if (valid) {
        return true;
    }
    return valid;
}

$(document).ready(function () {
    $("#submitForm").click(function (event) {
        event.preventDefault();
        let $btn = $(this);
        $btn.prop('disabled', true); // Disable the button
        $btn.html('Loading...'); // Change button text to 'Loading...'

        let validate = validation_employee_form();
        if (validate === false) {
            $btn.prop('disabled', false).html('Submit');
            return false;
        }
        // Serialize form data
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
        let formData = $("#employeeForm").serialize();

        // Ajax request
        $.ajax({
            type: "POST",
            url: "/admin/employee", // Replace with your server endpoint
            data: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                // Handle success
                console.log(response);
                // You can add more logic here based on the response from the server
                if (response.message) {
                    if (response.success == true) {
                        $("#employeeForm")[0].reset();
                        $.notify(response.message, "success");
                    } else {
                        $.notify(response.message.substring(0, 100), "error");
                    }
                }
                $btn.prop('disabled', false).html('Submit');
            },
            error: function (error) {
                // Handle error
                console.log(error);
                if (error.message) {
                    $.notify(error.message.substring(0, 100), "error");
                }
                $btn.prop('disabled', false).html('Submit');
            }
        });
    });
});


$(document).ready(function () {
    $("#submitUpdateForm").click(function (event) {
        event.preventDefault();
        // let validate = validation_employee_form();
        // if (validate === false) {
        //     return false;
        // }
        // Serialize form data
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
        let formData = $("#employeeFormUpdate").serialize();

        let id = $('#employee_record_id').val();

        // Ajax request
        $.ajax({
            type: "PUT",
            url: "/admin/employee/" + id, // Replace with your server endpoint
            data: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                // Handle success
                console.log(response.responseJSON);
                // You can add more logic here based on the response from the server
                if (response.message) {
                    if (response.success == true) {
                        $.notify(response.message, "success");
                    } else {
                        $.notify(response.message.substring(0, 100), "error");
                    }
                }
            },
            error: function (error) {
                // Handle error
                $.notify(error?.responseJSON?.message.substring(0, 100), "error");
            }
        });
    });
});




