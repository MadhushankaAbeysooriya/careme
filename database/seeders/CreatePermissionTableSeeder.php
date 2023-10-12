<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreatePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'user-type-list',
            'user-type-create',
            'user-type-edit',
            'user-type-delete',
            'card-issuance-status-list',
            'card-issuance-status-create',
            'card-issuance-status-edit',
            'card-issuance-status-delete',
            'card-issue-criteria-list',
            'card-issue-criteria-create',
            'card-issue-criteria-edit',
            'card-issue-criteria-delete',
            'dependence-list',
            'dependence-create',
            'dependence-edit',
            'dependence-delete',
            'dependence-fwd',
            'dependence-fwd-reject',
            'dependence-approve',
            'dependence-reject',
            'province-list',
            'province-create',
            'province-edit',
            'province-delete',
            'district-list',
            'district-create',
            'district-edit',
            'district-delete',
            'dsdivision-list',
            'dsdivision-create',
            'dsdivision-edit',
            'dsdivision-delete',
            'ethnicity-list',
            'ethnicity-create',
            'ethnicity-edit',
            'ethnicity-delete',
            'forces-list',
            'forces-create',
            'forces-edit',
            'forces-delete',
            'marital-status-list',
            'marital-status-create',
            'marital-status-edit',
            'marital-status-delete',
            'person-list',
            'person-create',
            'person-edit',
            'person-delete',
            'person-fwd',
            'person-fwd-reject',
            'person-approve',
            'person-reject',
            'person-status-list',
            'person-status-create',
            'person-status-edit',
            'person-status-delete',
            'ranaviru-type-list',
            'ranaviru-type-create',
            'ranaviru-type-edit',
            'ranaviru-type-delete',
            'rank-list',
            'rank-create',
            'rank-edit',
            'rank-delete',
            'regiment-department-list',
            'regiment-department-create',
            'regiment-department-edit',
            'regiment-department-delete',
            'relationship-list',
            'relationship-create',
            'relationship-edit',
            'relationship-delete',
            'card-issue-list',
            'card-issue-create',
            'card-issue-edit',
            'card-issue-delete',            
         ];
      
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
