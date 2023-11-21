<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Employee Create Test
     */
    public function test_it_creates_an_employee(): void
    {
        // Create a user with 'add employee' permission
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'employee']);

        Permission::create(['name' => 'add employee']);

        $admin = Role::findByName('admin');
        $permission1 = Permission::findByName('add employee');
        $admin->givePermissionTo($permission1);


        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $employeeData = [
            'name' => 'Vicky Chhetri',
            'email' => 'vickychhetri4@gmail.com',
            'employee_id' => 'EMP1600',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'building_no' => '123',
            'street_name' => 'Sector 71',
            'city' => 'Mohali',
            'state' => 'Punjab',
            'country' => 'India',
            'pincode' => '166002',
        ];

        $response = $this->postJson('/admin/employee', $employeeData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Employee created successfully!'
            ]);

        // Assert that the employee is in the database
        $this->assertDatabaseHas('users', [
            'name' => 'Vicky Chhetri',
            'email' => 'vickychhetri4@gmail.com',
            'employee_id' => 'EMP1600',
        ]);
    }

    public function test_it_update_an_employee(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'employee']);
        Permission::create(['name' => 'add employee']);
        Permission::create(['name' => 'edit employee']);
        $admin = Role::findByName('admin');
        $permission1 = Permission::findByName('add employee');
        $permission2 = Permission::findByName('edit employee');
        $admin->givePermissionTo($permission1);
        $admin->givePermissionTo($permission2);


        $employee = User::create([
            'name' => 'Sahil Kumar',
            'email' => 'sahil@gmail.com',
            'employee_id' => 'EMP16601',
            'password' => Hash::make('password123'),
        ]);
        $employee->assignRole('admin');
        $this->actingAs($employee);

        $employeeAddress = UserAddress::create([
            'user_id' => $employee->id,
            'building_no' => '1087',
            'street_name' => 'Sector 71',
            'city' => 'Mohali',
            'state' => 'Punjab',
            'country' => 'India',
            'pincode' => '166002',
        ]);

        $employeeDataNew = [
            'name' => 'Vicky Chhetri',
            'email' => 'vickychhetri4@gmail.com',
            'employee_id' => 'EMP1600',
            'password' => 'password12356',
            'password_confirmation' => 'password12356',
            'building_no' => '123',
            'street_name' => 'Sector 71',
            'city' => 'Mohali',
            'state' => 'Punjab',
            'country' => 'Nepal',
            'pincode' => '144009',
        ];
        $response = $this->putJson('/admin/employee/' . $employee->id, $employeeDataNew);
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Employee updated successfully!'
            ]);

        $employee->refresh();
        $employeeAddress->refresh();

        $this->assertEquals('Vicky Chhetri', $employee->name);
        $this->assertEquals('vickychhetri4@gmail.com', $employee->email);
        $this->assertEquals('EMP1600', $employee->employee_id);
        $this->assertTrue(Hash::check('password12356', $employee->password));

        $this->assertEquals('123', $employeeAddress->building_no);
        $this->assertEquals('Sector 71', $employeeAddress->street_name);
        $this->assertEquals('Mohali', $employeeAddress->city);
        $this->assertEquals('Punjab', $employeeAddress->state);
        $this->assertEquals('Nepal', $employeeAddress->country);
        $this->assertEquals('144009', $employeeAddress->pincode);

    }
}
