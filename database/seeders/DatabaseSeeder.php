<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // logicForTextField:['is','is_not','starts_with','ends_with','contains','doesnot_starts_with','doesnot_end_with','doesnot_contains'],
        //            logicForDateField:['before','on','after','on_or_before','on_or_after','between'],
        // \App\Models\User::factory(10)->create();
        // \App\Models\Subscriber::factory(100)->create();
        //  \App\Models\Logic::insert([
        //     ['logic'=>'is','logic_type'=>'text'],  
        //     ['logic'=>'is_not','logic_type'=>'text'],  
        //     ['logic'=>'starts_with','logic_type'=>'text'],  
        //     ['logic'=>'ends_with','logic_type'=>'text'],  
        //     ['logic'=>'contains','logic_type'=>'text'],  
        //     ['logic'=>'doesnot_starts_with','logic_type'=>'text'],  
        //     ['logic'=>'doesnot_end_with','logic_type'=>'text'],  
        //     ['logic'=>'doesnot_contains','logic_type'=>'text'],  //for text 


        //     ['logic'=>'before','logic_type'=>'date'],  //for date 
        //     ['logic'=>'on','logic_type'=>'date'],  //for date 
        //     ['logic'=>'after','logic_type'=>'date'],  //for date 
        //     ['logic'=>'on_or_before','logic_type'=>'date'],  //for date 
        //     ['logic'=>'on_or_after','logic_type'=>'date'],  //for date 
        //     ['logic'=>'between','logic_type'=>'date'],  //for date 
            
            
        //  ]);

         \App\Models\LogicType::insert([
             ['subscribers_column_name'=>'first_name',"logic_type"=>'text'],
             ['subscribers_column_name'=>'last_name',"logic_type"=>'text'],
             ['subscribers_column_name'=>'email',"logic_type"=>'text'],
             ['subscribers_column_name'=>'birth_day',"logic_type"=>'date'],
             ['subscribers_column_name'=>'created_at',"logic_type"=>'date'],
             ['subscribers_column_name'=>'updated_at',"logic_type"=>'date'],
         ]);
    }
}