<?php

namespace Modules\Discount\Console;

use AliBayat\LaravelCategorizable\Category;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Discount\Entities\Discount;
use Modules\Product\Entities\Product;
use Modules\User\Entities\User;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DiscountStopCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount:stop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'discount will stop on expiration Date.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $discounts = Discount::where('status', 1)
            ->whereDate('expiration', '<=', Carbon::now())->get();
        if ($discounts->isNotEmpty()) {
            foreach ($discounts as $discount) {
                // type of discount is basket
                if ($discount->type === 'basket') {

                    if ($discount->select_all === 1) {
                        foreach (User::get() as  $user) {
                            $this->removeDiscountCodeForUser($user, $discount->code);
                        }
                    } else {
                        foreach (json_decode($discount->selected) as $id) {
                            $user  = User::find($id);
                            $this->removeDiscountCodeForUser($user, $discount->code);
                        }
                    }
                }

                // type of discount is product
                if ($discount->type == 'product') {
                    if ($discount->select_all === 1) {
                        foreach (Product::get() as $product) {
                            $this->changeFinalPriceFromProduct($product);
                        }
                    } else {
                        foreach (json_decode($discount->selected) as $id) {
                            $product = Product::find($id);
                            $this->changeFinalPriceFromProduct($product);
                        }
                    }
                }

                // type of discount is category
                if ($discount->type == 'category') {
                    $products = collect();
                    if ($discount->select_all === 1) {
                        foreach (Category::get() as $category) {
                            $data = $category->entries(Product::class)->get();
                            if ($data->isNotEmpty()) {
                                $products->push($data);
                            }
                        }
                    } else {
                        foreach (json_decode($discount->selected) as $id) {
                            $data = Category::find($id)->entries(Product::class)->get();
                            if ($data->isNotEmpty()) {
                                $products->push($data);
                            }
                        }
                    }
                    foreach ($products->flatten()->unique('id') as $product) {
                        $this->changeFinalPriceFromProduct($product);
                    }
                }

                $discount->status = false;
                $discount->save();
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }

    public function removeDiscountCodeForUser($user, $code)
    {
        $profile  = $user->profile;

        if ($profile) {
            $ProfileDiscountCode = $profile->discount_code;

            if (!is_null($ProfileDiscountCode) || !empty($ProfileDiscountCode)) {


                $profile->update([
                    'discount_code' => array_diff($ProfileDiscountCode, [$code])
                ]);
            }
        }
    }

    public function changeFinalPriceFromProduct($product)
    {
        $product->update([
            'final_price' => $product->tax_status === 0 ? $product->price : $product->price * 1.09
        ]);
    }
}
