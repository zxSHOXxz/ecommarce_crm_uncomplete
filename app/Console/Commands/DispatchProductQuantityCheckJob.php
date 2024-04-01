<?php

namespace App\Console\Commands;


use App\Jobs\ProductsQuantityCheck;
use Illuminate\Console\Command;


class DispatchProductQuantityCheckJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispatch:products_quantity_check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch Products Quantity Check Job if quantity <= 50 job qunatity will be draft';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dispatch(new ProductsQuantityCheck());
        return Command::SUCCESS;
    }
}
