<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //清空数据工厂
        Admin::truncate();
        //调用数据工厂
        factory(Admin::class,10)->create();
        //修改一个数据为admin
        Admin::where('id',1)->update(['username'=>'admin']);
    }
}
