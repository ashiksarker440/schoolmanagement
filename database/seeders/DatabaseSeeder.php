public function run(): void
{
    // Existing seeders
    $this->call([
        FeeCategorySeeder::class,
        // ... অন্যগুলো
    ]);
}