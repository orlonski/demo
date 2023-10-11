<?php

namespace Database\Seeders;

use App\Filament\Resources\Shop\OrderResource;
use App\Models\Address;
use App\Models\Blog\Author;
use App\Models\Blog\Categoria as BlogCategoria;
use App\Models\Blog\Post;
use App\Models\Comment;
use App\Models\Shop\Marca;
use App\Models\Shop\Categoria as ShopCategoria;
use App\Models\Shop\Cliente;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use App\Models\Shop\Payment;
use App\Models\Shop\Produto;
use App\Models\User;
use Closure;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
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
        $categorias = $this->withProgressBar(20, fn () => ShopCategoria::factory(1)
            ->has(
                ShopCategoria::factory()->count(3),
                'children'
            )->create());
        $this->command->info('Categorias criadas.');

        $this->command->warn(PHP_EOL . 'Criando clientes...');
        $clientes = $this->withProgressBar(1000, fn () => Cliente::factory(1)
            ->has(Address::factory()->count(rand(1, 3)))
            ->create());
        $this->command->info('Clientes criados.');

        $this->command->warn(PHP_EOL . 'Criando produtos...');
        $produtos = $this->withProgressBar(50, fn () => Produto::factory(1)
            ->sequence(fn ($sequence) => ['shop_marca_id' => $marcas->random(1)->first()->id])
            ->hasAttached($categorias->random(rand(3, 6)), ['created_at' => now(), 'updated_at' => now()])
            ->has(
                Comment::factory()->count(rand(10, 20))
                    ->state(fn (array $attributes, Produto $produto) => ['cliente_id' => $clientes->random(1)->first()->id]),
            )
            ->create());
        $this->command->info('Produtos criados.');

        $this->command->warn(PHP_EOL . 'Creating orders...');
        $orders = $this->withProgressBar(1000, fn () => Order::factory(1)
            ->sequence(fn ($sequence) => ['shop_cliente_id' => $clientes->random(1)->first()->id])
            ->has(Payment::factory()->count(rand(1, 3)))
            ->has(
                OrderItem::factory()->count(rand(2, 5))
                    ->state(fn (array $attributes, Order $order) => ['shop_produto_id' => $produtos->random(1)->first()->id]),
                'items'
            )
            ->create());

        foreach ($orders->random(rand(5, 8)) as $order) {
            Notification::make()
                ->title('New order')
                ->icon('heroicon-o-shopping-bag')
                ->body("{$order->cliente->name} ordered {$order->items->count()} produtos.")
                ->actions([
                    Action::make('View')
                        ->url(OrderResource::getUrl('edit', ['record' => $order])),
                ])
                ->sendToDatabase($user);
        }
        $this->command->info('Shop orders created.');

        // Blog
        $this->command->warn(PHP_EOL . 'Criando categorias...');
        $blogCategorias = $this->withProgressBar(20, fn () => BlogCategoria::factory(1)
            ->count(20)
            ->create());
        $this->command->info('Categorias criadas.');

        $this->command->warn(PHP_EOL . 'Creating blog authors and posts...');
        $this->withProgressBar(20, fn () => Author::factory(1)
            ->has(
                Post::factory()->count(5)
                    ->has(
                        Comment::factory()->count(rand(5, 10))
                            ->state(fn (array $attributes, Post $post) => ['cliente_id' => $clientes->random(1)->first()->id]),
                    )
                    ->state(fn (array $attributes, Author $author) => ['blog_categoria_id' => $blogCategorias->random(1)->first()->id]),
                'posts'
            )
            ->create());
        $this->command->info('Blog authors and posts created.');
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
