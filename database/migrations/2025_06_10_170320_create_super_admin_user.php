<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $role = Role::firstOrCreate(['name' => 'Super Admin']);

        $user = User::firstOrCreate(
            [
                'name'     => 'Super Admin',
                'email'    => 'superadmin@example.com',
                'password' => bcrypt('password'),
            ]
        );

        $role->users()->attach($user);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $role = Role::where('name', 'Super Admin')->first();

        if ($role) {
            $user = DB::table('users')->where('email', 'superadmin@example.com')->first();
            if ($user) {
                $role->users()->detach($user);
                DB::table('users')->where('email', 'superadmin@example.com')->delete();
            }
        }
    }
};
