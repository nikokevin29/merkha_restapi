<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();
        $this->call(UserSeeder::class);
        $this->call(BusinessTypeSeeder::class);
        $this->call(MerchantCategorySeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(EmployeeRoleSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(MerchantSeeder::class);
        $this->call(MerchantFileSeeder::class);
        $this->call(MerchantBankSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(WishlistSeeder::class);
        $this->call(FeedSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(ProductPhotoSeeder::class);
        $this->call(PromotionSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(VoucherSeeder::class);
        $this->call(AppContentSeeder::class);
        $this->call(CampaignSeeder::class);
        $this->call(UserInterestSeeder::class);
        $this->call(CampaignDetailSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(OrderDetailSeeder::class);
        $this->call(PaymentSeeder::class);
    }
}
