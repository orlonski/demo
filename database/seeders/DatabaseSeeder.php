<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Blog\Categoria as BlogCategoria;
use App\Models\Categoria as Categoria;
use App\Models\Cliente;
use App\Models\Marca;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    const IMAGE_URL = 'https://source.unsplash.com/random/200x200/?img=1';

    public function run(): void
    {
        // Clear images
        Storage::deleteDirectory('public');

        // Admin
        $this->command->warn(PHP_EOL . 'Creating admin user...');
        $user = $this->withProgressBar(1, fn () => User::factory(1)->create([
            'name' => 'Demo User',
            'email' => 'admin@filamentphp.com',
        ]));
        $this->command->info('Admin user created.');

        // Shop
        $this->command->warn(PHP_EOL . 'Criando marcas...');
        $marcas = $this->withProgressBar(20, fn () => Marca::factory()->count(20)
            ->has(Address::factory()->count(rand(1, 3)))
            ->create());
        $this->command->info('Marcas criadas.');

        $this->command->warn(PHP_EOL . 'Criando categorias...');
        $categorias = $this->withProgressBar(20, fn () => Categoria::factory(1)
            ->has(
                Categoria::factory()->count(3),
                'children'
            )->create());
        $this->command->info('Categorias criadas.');

        $this->command->warn(PHP_EOL . 'Criando clientes...');
        $clientes = $this->withProgressBar(1000, fn () => Cliente::factory(1)
            ->has(Address::factory()->count(rand(1, 3)))
            ->create());
        $this->command->info('Clientes criados.');

        $this->command->warn(PHP_EOL . 'Criando produtos...');

        $this->command->warn(PHP_EOL . 'Criando pedidos...');

        // Blog
        $this->command->warn(PHP_EOL . 'Criando categorias...');
        $blogCategorias = $this->withProgressBar(20, fn () => BlogCategoria::factory(1)
            ->count(20)
            ->create());
        $this->command->info('Categorias criadas.');

        $this->command->warn(PHP_EOL . 'Creating blog authors and posts...');
    }

    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection();

        foreach (range(1, $amount) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }
}
