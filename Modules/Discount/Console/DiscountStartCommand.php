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

class DiscountStartCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this will happen on discount beginning Date ';

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
        $discounts = Discount::where('status', 0)
            ->whereDate('beginning', '<=', Carbon::now())
            ->whereDate('expiration', '>', Carbon::now())->get();
        if ($discounts->isNotEmpty()) {
            foreach ($discounts as $key => $discount) {
                // type of discount is basket
                if ($discount->type === 'basket') {

                    if ($discount->select_all === 1) {
                        foreach (User::get() as  $user) {
                            $this->saveDiscountCodeForUser($user, $discount->code);
                        }
                    } else {
                        foreach (json_decode($discount->selected) as $id) {
                            $user  = User::find($id);

                            $this->saveDiscountCodeForUser($user, $discount->code);
                        }
                    }
                }

                // type of discount is product
                if ($discount->type == 'product') {

                    if ($discount->select_all === 1) {
                        foreach (Product::get() as $product) {
                            $this->saveFinalPriceForProduct($product, $discount->measure, $discount->amount);
                        }
                    } else {
                        foreach (json_decode($discount->selected) as $id) {
                            $product = Product::find($id);
                            $this->saveFinalPriceForProduct($product, $discount->measure, $discount->amount);
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
                        $this->saveFinalPriceForProduct($product, $discount->measure, $discount->amount);
                    }
                }

                $discount->status = true;
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

    public function saveDiscountCodeForUser($user, $code)
    {
        $profile  = $user->profile;

        if ($profile) {
            $newProfileDiscountCode = $profile->discount_code;

            if (is_null($newProfileDiscountCode)) {
                $newProfileDiscountCode = [];
            }

            if (!in_array($code, $newProfileDiscountCode)) {
                array_push($newProfileDiscountCode, $code);
                $profile->discount_code = $newProfileDiscountCode;
                $profile->save();
            }
        } else {
            $user->profile()->create([
                'discount_code' => [$code]
            ]);
        }
    }

    public function saveFinalPriceForProduct($product, $measure, $amount)
    {

        if ($measure === 'percent') {
            $price = $product->price * (100 - $amount) / 100;
        } else {
            if ($amount < $product->price) {
                $price = $product->price - $amount;
            } else {
                $price = $product->price;
            }
        }

        if ($product->tax_status === 1) {
            $price = $price * 1.09;
        }
        $product->update([
            'final_price' => $price
        ]);
    }
}
