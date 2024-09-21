<?php

namespace App\Console\Commands;

use App\Models\OrderProduct;
use Illuminate\Console\Command;

class ClearOrderProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-order-products-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        OrderProduct::where([
            'created_at', '<' , now()->subDay()
        ])->each(function (OrderProduct $orderProduct){
            $orderProduct->delete();
            $this->output->info("order_product: $orderProduct->id deleted successfully");
        });
    }
}
