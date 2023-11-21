<x-mail::message>
Welcome to Zethic Tech! We're thrilled to have you join our community.

<p>Employee Name: {{$employee->name}}<br/>
    Employee ID: {{$employee->employee_id}} </p>

Personalize your experience by adding some information about yourself. Take a tour and discover all the amazing features available to you. Engage with the community and connect with like-minded individuals.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
