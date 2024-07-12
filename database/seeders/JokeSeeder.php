<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class JokeSeeder extends Seeder
{
    /**
     * Run the migrations.
     */
    public function run(): void
    {
        $carrId = DB::table('users')->where('email', 'jimmy.carr@example.com')->value('id');
        $daviesId = DB::table('users')->where('email', 'greg.davies@example.com')->value('id');
        $mcintyreId = DB::table('users')->where('email', 'michael.mcintyre@example.com')->value('id');

        $users = [
            $carrId,
            $daviesId,
            $mcintyreId
        ];

        $fetchJoke = function() {
            $response = Http::withHeaders(['Accept' => 'application/json'])
                ->get('https://icanhazdadjoke.com/');
            return $response->json('joke');
        };

        foreach ($users as $userId) {
            $jokeCount = rand(1, 4);

            for ($i = 0; $i < $jokeCount; $i++) {
                DB::table('jokes')->insert([
                    'user_id' => $userId,
                    'message' => $fetchJoke(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
