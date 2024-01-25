<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ConditionSeeder::class,
            ExpressionSeeder::class,
        ]);

        Store::query()->create([
            'name' => 'FirstStore',
            'apiToken' => 'eyJhbGciOiJFUzI1NiIsImtpZCI6IjIwMjMxMjI1djEiLCJ0eXAiOiJKV1QifQ.eyJlbnQiOjEsImV4cCI6MTcyMTI1MjYzMCwiaWQiOiJkYmI4ZjE5YS1lMDg2LTQ3MzMtOTE0Ny1mYWU2NmM1OTM1NTgiLCJpaWQiOjE4NDA0MzIxLCJvaWQiOjc2MjUzLCJzIjozMiwic2lkIjoiZjYwMDVkNTYtZjAyMC01MmVhLTk0NjUtNWRiYTExZjEyYmE3IiwidCI6ZmFsc2UsInVpZCI6MTg0MDQzMjF9.0hSdZ7939Wbv6Tu6UuDYvkLZUxsqKf8r9-ctP_UYvFm3YnyrSsQm4goAQk1SD3pOzT86N_F8jvF4ioe-UB9rfQ',
        ]);
    }
}
