<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
            // +++++++++++++++++++++++++++++++Start SuperAdmin Role&&Permission+++++++++++++++++++++++++++++++++++++

            // create SuperAdmin Role
            $SuperAdmin = Role::create(['name' => 'SuperAdmin']);


            $permissions = [

                'companies_access',
                'company_show',
                'company_delete',
                'company_search',
                'company_create',
                'company_update',

                'products_access',
                'product_show',
                'product_delete',
                'product_search',
                'product_create',
                'product_update',


                'categories_access',
                'category_show',
                'category_delete',
                'category_create',
                'category_update',


                'features_access',
                'feature_show',
                'feature_delete',
                'feature_search',
                'feature_create',
                'feature_update',


                'types_access',
                'type_show',
                'type_delete',
                'type_create',
                'type_update',

                'devices_access',
                'device_show',
                'device_delete',
                'device_search',
                'device_create',
                'device_update',




                'teams_access',
                'team_show',
                'team_delete',
                'team_search',
                'team_create',
                'team_update',


                'feedbacks_access',
                'feedbacks_show',
                'feedback_update',
                'feedback_delete',
                'feedback_create',

                'survey_access',


                'customers_access',
                'customer_show',
                'customer_delete',
                'customer_search',
                'customer_create',
                'customer_update',

                'appointments_access',
                'appointment_show',
                'appointment_delete',
                'appointment_search',
                'appointment_create',
                'appointment_update',


                'orders_access',
                'order_show',
                'order_delete',
                'order_user',
                'order_create',
                'order_update',
                'order_search',



            ];
            foreach ($permissions as $permission)   {
                Permission::create([
                    'name' => $permission
                ]);
            }



            foreach ($permissions as $permission)   {
                $SuperAdmin->givePermissionTo($permission);
            }

            // asign SuperAdmin Role to first user
       //  $admin = User::where('id' , 1)->first();
        // $admin->assignRole('SuperAdmin');



         // +++++++++++++++++++++++++++++++End SuperAdmin Role&&Permission+++++++++++++++++++++++++++++++++++++

        // +++++++++++++++++++++++++++++++Start Admin Role&&Permission+++++++++++++++++++++++++++++++++++++

        $admin = Role::create(['name' => 'Admin']);


                // create Admin permissions

        $permissions = [


                'companies_access',
                'company_show',
                'company_delete',
                'company_search',
                'company_create',
                'company_update',


                'products_access',
                'product_show',
                'product_delete',
                'product_search',
                'product_update',
                'product_create',



                'categories_access',
                'category_show',
                'category_delete',
                'category_create',
                'category_update',


                'features_access',
                'feature_show',
                'feature_delete',
                'feature_search',
                'feature_create',
                'feature_update',


                'types_access',
                'type_show',
                'type_delete',
                'type_create',
                'type_update',

                'devices_access',
                'device_show',
                'device_delete',
                'device_search',
                'device_create',
                'device_update',


                'customers_access',
                'customer_delete',
                'customer_show',


                'teams_access',
                'team_show',
                'team_search',


                'orders_access',
                'order_show',

                'feedbacks_access',
                'feedbacks_show',
                'feedback_delete',

                'survey_access',



            ];


            foreach ($permissions as $permission)   {
                $admin->givePermissionTo($permission);
            }

            // +++++++++++++++++++++++++++++++End Admin Role&&Permission+++++++++++++++++++++++++++++++++++++




            // +++++++++++++++++++++++++++++++Start Company Role&&Permission+++++++++++++++++++++++++++++++++++++

            $company = Role::create(['name' => 'Company']);

            $permissions = [

                'products_access',
                'product_show',
                'product_delete',
                'product_search',
                'product_create',
                'product_update',

                'categories_access',
                'category_show',


                'features_access',

                'company_show',



                'teams_access',
                'team_show',
                'team_delete',
                'team_search',
                'team_create',
                'team_update',



                'orders_access',
                'order_show',
                'order_delete',
                'order_search',
                'order_create',
                'order_update',

                'appointments_access',
                'appointment_update',
                'appointment_show',


                'feedbacks_show',



                'customers_access',
                'customer_show',





            ];
            foreach ($permissions as $permission)   {
                $company->givePermissionTo($permission);
            }




            // +++++++++++++++++++++++++++++++End Company Role&&Permission+++++++++++++++++++++++++++++++++++++


             // +++++++++++++++++++++++++++++++Start Team Role&&Permission+++++++++++++++++++++++++++++++++++++

             $team = Role::create(['name' => 'Team']);

             $permissions = [

                'appointments_access',
                'appointment_update',
                 'appointment_show',


                 'orders_access',
                'order_update',
                'order_show',


                'customer_show',



             ];
             foreach ($permissions as $permission)   {
                 $team->givePermissionTo($permission);
             }

             // +++++++++++++++++++++++++++++++End Team Role&&Permission+++++++++++++++++++++++++++++++++++++




                    // +++++++++++++++++++++++++++++++Start Customer Role&&Permission+++++++++++++++++++++++++++++++++++++

                    $customer = Role::create(['name' => 'Customer']);

                    $permissions = [

                        'devices_access',
                        'device_show',


                        'types_access',
                        'type_show',


                        'companies_access',
                        'company_show',

                        'products_access',
                        'product_show',


                        'categories_access',
                        'category_show',



                        'order_show',
                        'order_delete',
                        'order_search',
                        'order_create',
                        'order_user',
                        'order_update',


                        'feedbacks_show',
                        'feedback_update',
                        'feedback_delete',
                        'feedback_create',


                        'appointments_access',
                        'appointment_show',





                    ];
                    foreach ($permissions as $permission)   {
                        $customer->givePermissionTo($permission);
                    }

                    // +++++++++++++++++++++++++++++++End Customer Role&&Permission+++++++++++++++++++++++++++++++++++++








    }
}
