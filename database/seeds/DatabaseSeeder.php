<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User as User;
use App\Config as Config;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        Model::unguard();
        $this->call('UserTableSeeder');
        # $this->call('ConfigTableSeeder');
    }

}

class UserTableSeeder extends Seeder {

    public function run(){
        DB::table('users')->delete();
        User::create([
            'email' => 'tbson87@gmail.com',
            'password' => Hash::make('griever87'),
            'name' => 'Tran Bac Son',
            'role' => 'ADMIN'
        ]);
        User::create([
            'email' => 'tbson88@gmail.com',
            'password' => Hash::make('griever87'),
            'name' => 'Tran Bac Son 1',
            'role' => 'USER'
        ]);
        User::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'name' => 'Admin',
            'role' => 'ADMIN'
        ]);
        User::create([
            'email' => 'user@gmail.com',
            'password' => Hash::make('user'),
            'name' => 'User',
            'role' => 'USER'
        ]);
    }
}

class ConfigTableSeeder extends Seeder {

    public function run(){
        DB::table('config')->delete();
        Config::create(['uid' => 'VAR_01', 'title' => 'Title 01', 'value' => '01', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_02', 'title' => 'Title 02', 'value' => '02', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_03', 'title' => 'Title 03', 'value' => '03', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_04', 'title' => 'Title 04', 'value' => '04', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_05', 'title' => 'Title 05', 'value' => '05', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_06', 'title' => 'Title 06', 'value' => '06', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_07', 'title' => 'Title 07', 'value' => '07', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_08', 'title' => 'Title 08', 'value' => '08', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_09', 'title' => 'Title 09', 'value' => '09', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_10', 'title' => 'Title 10', 'value' => '10', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_11', 'title' => 'Title 11', 'value' => '11', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_12', 'title' => 'Title 12', 'value' => '12', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_13', 'title' => 'Title 13', 'value' => '13', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_14', 'title' => 'Title 14', 'value' => '14', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_15', 'title' => 'Title 15', 'value' => '15', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_16', 'title' => 'Title 16', 'value' => '16', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_17', 'title' => 'Title 17', 'value' => '17', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_18', 'title' => 'Title 18', 'value' => '18', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_19', 'title' => 'Title 19', 'value' => '19', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_20', 'title' => 'Title 20', 'value' => '20', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_21', 'title' => 'Title 21', 'value' => '21', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_22', 'title' => 'Title 22', 'value' => '22', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_23', 'title' => 'Title 23', 'value' => '23', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_24', 'title' => 'Title 24', 'value' => '24', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_25', 'title' => 'Title 25', 'value' => '25', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_26', 'title' => 'Title 26', 'value' => '26', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_27', 'title' => 'Title 27', 'value' => '27', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_28', 'title' => 'Title 28', 'value' => '28', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_29', 'title' => 'Title 29', 'value' => '29', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_30', 'title' => 'Title 30', 'value' => '30', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_31', 'title' => 'Title 31', 'value' => '31', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_32', 'title' => 'Title 32', 'value' => '32', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_33', 'title' => 'Title 33', 'value' => '33', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_34', 'title' => 'Title 34', 'value' => '34', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_35', 'title' => 'Title 35', 'value' => '35', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_36', 'title' => 'Title 36', 'value' => '36', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_37', 'title' => 'Title 37', 'value' => '37', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_38', 'title' => 'Title 38', 'value' => '38', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_39', 'title' => 'Title 39', 'value' => '39', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_40', 'title' => 'Title 40', 'value' => '40', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_41', 'title' => 'Title 41', 'value' => '41', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_42', 'title' => 'Title 42', 'value' => '42', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_43', 'title' => 'Title 43', 'value' => '43', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_44', 'title' => 'Title 44', 'value' => '44', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_45', 'title' => 'Title 45', 'value' => '45', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_46', 'title' => 'Title 46', 'value' => '46', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_47', 'title' => 'Title 47', 'value' => '47', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_48', 'title' => 'Title 48', 'value' => '48', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_49', 'title' => 'Title 49', 'value' => '49', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_50', 'title' => 'Title 50', 'value' => '50', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_51', 'title' => 'Title 51', 'value' => '51', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_52', 'title' => 'Title 52', 'value' => '52', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_53', 'title' => 'Title 53', 'value' => '53', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_54', 'title' => 'Title 54', 'value' => '54', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_55', 'title' => 'Title 55', 'value' => '55', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_56', 'title' => 'Title 56', 'value' => '56', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_57', 'title' => 'Title 57', 'value' => '57', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_58', 'title' => 'Title 58', 'value' => '58', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_59', 'title' => 'Title 59', 'value' => '59', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_60', 'title' => 'Title 60', 'value' => '60', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_61', 'title' => 'Title 61', 'value' => '61', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_62', 'title' => 'Title 62', 'value' => '62', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_63', 'title' => 'Title 63', 'value' => '63', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_64', 'title' => 'Title 64', 'value' => '64', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_65', 'title' => 'Title 65', 'value' => '65', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_66', 'title' => 'Title 66', 'value' => '66', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_67', 'title' => 'Title 67', 'value' => '67', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_68', 'title' => 'Title 68', 'value' => '68', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_69', 'title' => 'Title 69', 'value' => '69', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_70', 'title' => 'Title 70', 'value' => '70', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_71', 'title' => 'Title 71', 'value' => '71', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_72', 'title' => 'Title 72', 'value' => '72', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_73', 'title' => 'Title 73', 'value' => '73', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_74', 'title' => 'Title 74', 'value' => '74', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_75', 'title' => 'Title 75', 'value' => '75', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_76', 'title' => 'Title 76', 'value' => '76', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_77', 'title' => 'Title 77', 'value' => '77', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_78', 'title' => 'Title 78', 'value' => '78', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_79', 'title' => 'Title 79', 'value' => '79', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_80', 'title' => 'Title 80', 'value' => '80', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_81', 'title' => 'Title 81', 'value' => '81', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_82', 'title' => 'Title 82', 'value' => '82', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_83', 'title' => 'Title 83', 'value' => '83', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_84', 'title' => 'Title 84', 'value' => '84', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_85', 'title' => 'Title 85', 'value' => '85', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_86', 'title' => 'Title 86', 'value' => '86', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_87', 'title' => 'Title 87', 'value' => '87', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_88', 'title' => 'Title 88', 'value' => '88', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_89', 'title' => 'Title 89', 'value' => '89', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_90', 'title' => 'Title 90', 'value' => '90', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_91', 'title' => 'Title 91', 'value' => '91', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_92', 'title' => 'Title 92', 'value' => '92', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_93', 'title' => 'Title 93', 'value' => '93', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_94', 'title' => 'Title 94', 'value' => '94', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_95', 'title' => 'Title 95', 'value' => '95', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_96', 'title' => 'Title 96', 'value' => '96', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_97', 'title' => 'Title 97', 'value' => '97', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_98', 'title' => 'Title 98', 'value' => '98', 'var_type' => 'int']);
        Config::create(['uid' => 'VAR_99', 'title' => 'Title 99', 'value' => '99', 'var_type' => 'int']);
    }
}