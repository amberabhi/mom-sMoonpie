<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Services\HttpService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Product; // Adjust the namespace if your model is elsewhere

class FetchProductsFromAPI extends Command
{
    protected $signature = 'fetch:products';

    protected $httpService;

    protected $description = 'Fetch products from API and store them in the database';

    public function __construct()
    {
        parent::__construct();
        $this->httpService = new HttpService();
    }

    public function handle()
    {
        $this->info('Starting to fetch products from API...');
        $settings = Setting::first();
        $timestamp = time();  // Use Laravel's timestamp method or set it according to your needs
        $token = $settings->apparelmagic_token;  // Replace with your actual token

        $pageNumber = 1;  // Start from page 1
        $pageSize = 100;  // Fetch 10 records per page

        do {
            $response = $this->httpService->getRequest($settings->apparelmagic_endpoint."products", [
                'time' => $timestamp,
                'token' => $token,
                'pagination' => [
                    'page_number' => $pageNumber,
                    'page_size' => $pageSize
                ]
            ]);

            if (isset($response['response']) && count($response['response'])) {
                $data = $response['response'];

                // Fetch the records and save them to the database
                if (!empty($data)) {
                    foreach ($data as $productData) {
                        Product::updateOrCreate(
                            ['product_id' => $productData['product_id']], // Match by product_id
                            $this->mapProductData($productData) // Pass data mapped to your model fields
                        );
                    }

                    // Get pagination details
                    $pagination = $response['meta']['pagination'];
                    $pageNumber = (int)$pagination['current_page'] + 1; // Increment to the next page
                } else {
                    Log::info('No more products found.');
                    $this->info('No more products found.');
                    break;
                }
            } else {
                $this->error('Failed to fetch data from API. Status: ' . $response);
                Log::error('Failed to fetch data from API. Status: ' . $response);
                break;
            }
        } while ($pagination['number_records_returned'] == $pageSize); // Continue if there are more records

        Log::info('Products fetching completed.');
        $this->info('Products fetching completed.');
    }

    /**
     * Map API response data to the product table columns
     */
    private function mapProductData($productData)
    {
        return [
            'product_id' => $productData['product_id'],
            'is_product' => $productData['is_product'],
            'is_component' => $productData['is_component'],
            'is_bundle' => $productData['is_bundle'],
            'is_virtual_bundle' => $productData['is_virtual_bundle'],
            'is_gift_card' => $productData['is_gift_card'],
            'is_emblem' => $productData['is_emblem'],
            'is_inventory_tracked' => $productData['is_inventory_tracked'],
            'style_number' => $productData['style_number'],
            'alt_code' => $productData['alt_code'],
            'description' => $productData['description'],
            'category' => $productData['category'],
            'class' => $productData['class'],
            'group' => $productData['group'],
            'size_range_id' => $productData['size_range_id'],
            'cost' => $productData['cost'],
            'price' => $productData['price'],
            'retail_price' => $productData['retail_price'],
            'margin' => $productData['margin'],
            'cost_labor' => $productData['cost_labor'],
            'cost_materials' => $productData['cost_materials'],
            'cost_base' => $productData['cost_base'],
            'cost_misc' => $productData['cost_misc'],
            'cost_landed' => $productData['cost_landed'],
            'duty_rate' => $productData['duty_rate'],
            'cost_duty' => $productData['cost_duty'],
            'cost_freight' => $productData['cost_freight'],
            'cost_auto' => $productData['cost_auto'],
            'vendor_cost_base' => $productData['vendor_cost_base'],
            'vendor_currency_id' => $productData['vendor_currency_id'],
            'origin' => $productData['origin'],
            'content' => $productData['content'],
            'weight' => $productData['weight'],
            'box_size' => $productData['box_size'],
            'tariff_code' => $productData['tariff_code'],
            'mid_code' => $productData['mid_code'],
            'is_taxable' => $productData['is_taxable'],
            'notes' => $productData['notes'],
            'production_notes' => $productData['production_notes'],
            'vendor_id' => $productData['vendor_id'],
            'season' => $productData['season'],
            'price_break_id' => $productData['price_break_id'],
            'care_instructions' => $productData['care_instructions'],
            'unit_of_measure' => $productData['unit_of_measure'],
            'lead_time' => $productData['lead_time'],
            'buyer_filter' => $productData['buyer_filter'],
            'web_title' => $productData['web_title'],
            'web_description' => $productData['web_description'],
            'magento_config_product_id' => $productData['magento_config_product_id'],
            'magento_category_id' => $productData['magento_category_id'],
            'magento_attribute_set_id' => $productData['magento_attribute_set_id'],
            'magento_last_price' => $productData['magento_last_price'],
            'magento_sync' => $productData['magento_sync'],
            'magento_sync_timestamp' => $productData['magento_sync_timestamp'],
            'balluun_sync' => $productData['balluun_sync'],
            'balluun_ext_id' => $productData['balluun_ext_id'],
            'joor_product_id' => $productData['joor_product_id'],
            'joor_sync' => $productData['joor_sync'],
            'pct_royalty' => $productData['pct_royalty'],
            'amount_royalty' => $productData['amount_royalty'],
            'licensor' => $productData['licensor'],
            'joor_web_title' => $productData['joor_web_title'],
            'joor_web_description' => $productData['joor_web_description'],
            'pct_markup' => $productData['pct_markup'],
            'joor_sync_colorway_swatches' => $productData['joor_sync_colorway_swatches'],
            'skus_active' => $productData['skus_active'],
            'square_web_title' => $productData['square_web_title'],
            'square_web_description' => $productData['square_web_description'],
            'square_sync' => $productData['square_sync'],
            'b2b_web_title' => $productData['b2b_web_title'],
            'b2b_web_description' => $productData['b2b_web_description'],
            'last_modified_time' => $productData['last_modified_time'],
            'last_modified_command' => $productData['last_modified_command'],
            'last_modified_user_id' => $productData['last_modified_user_id'],
            'creation_time' => $productData['creation_time'],
            'creation_user_id' => $productData['creation_user_id'],
            'creation_user_name' => $productData['creation_user_name'],
            'last_modified_user_name' => $productData['last_modified_user_name'],
            'division_id' => $productData['division_id'],
            'sample_size' => $productData['sample_size'],
            'tech_pack_layout_id' => $productData['tech_pack_layout_id'],
            'is_note_required' => $productData['is_note_required'],
            'is_returnable' => $productData['is_returnable'],
            'attribute_options' => $productData['attribute_options'],
            'ref_table' => $productData['ref_table'],
            'collection' => $productData['collection'],
            'vendor_name' => $productData['vendor_name'],
            'price_break_name' => $productData['price_break_name'],
            'size_range_info' => json_encode($productData['size_range_info']),
            'images' => json_encode($productData['images']),
            'price_groups' => json_encode($productData['price_groups']),
            'prepacks' => json_encode($productData['prepacks']),
            'specs' => json_encode($productData['specs']),
            'bill_of_materials' => json_encode($productData['bill_of_materials']),
            'processes' => json_encode($productData['processes']),
            'tags' => json_encode($productData['tags']),
            'buyer_filters' => json_encode($productData['buyer_filters']),
            'royalties' => json_encode($productData['royalties']),
            'emblem_placements' => json_encode($productData['emblem_placements']),
            'alt_product_code' => $productData['alt_product_code'],
            'hs_active' => $productData['hs_active'],
            'exclude_rsk' => $productData['exclude_rsk'],
            'product_name' => $productData['product_name'],
            'custom_headwear' => $productData['custom_headwear'],
        ];
    }
}
