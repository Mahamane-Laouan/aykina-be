<?php

namespace App\Http\Resources;

use App\Http\Controllers\API\BaseController;
use App\Models\SubCategoryModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ProductCategory;
use App\Models\Product;

class ProductRes extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        // $imgs = explode("::::", $this->product_image);
        // $pro_img = array();
        // foreach ($imgs as $img) {
        //     if (strpos($img, 'products_img/') !== false) {
        //         $image = new BaseController;
        //         $pro_img[] = $image->s3FetchFile($img);
        //     } else {
        //         $pro_img[] = url('/products_img/' . $img);
        //     }
        // }


        //  $images = explode("::::", $this->product_image);
        //     $imgs = array();
        //     $imgsa = array();
        //     foreach ($images as $key => $image) {


        //         // $imgs =  asset('assets/images/post/'. $image);

        //         $imgs = asset('public/images/product_images/' . $image);

        //         array_push($imgsa, $imgs);
        //     }
        //     // $user->service_image = $imgsa;

        //     $pro_img = $imgsa;
        $pro_img = array();

        $services_all = Product::where('product_id', $this->product_id)->with('productImages')->first();


        $imgsa = [];

        foreach ($services_all->productImages as $image) {
            $imgsa[] = asset('/images/product_images/' . $image->product_image); // 'image_path' is the column name
        }

        // Assign images to the array
        $pro_img = $imgsa;

        // if (strpos($this->icon, '/') !== false) {
        //     $icon = new BaseController;
        //     $icon_pic = $icon->s3FetchFile($this->icon);
        // } else {
        //     $icon_pic = url('/category_img/' . $this->icon);
        // }

        $category = ProductCategory::where('id', $this->cat_id)->first();

        return [
            'product_id' => (string)$this->product_id,
            'cat_id' => (string)$this->cat_id,
            'cat_name' => $category ? $category->c_name : "",
            'v_id' => (string)$this->v_id,
            'product_name' => $this->product_name ? $this->product_name : "",
            'product_description' => $this->product_description ? $this->product_description : "",
            // 'size' => $this->size ? explode(',', $this->size) : [],
            'size' => $this->size ? $this->size : "",
            // 'colorspecifications' => $this->colors ? explode(',', $this->colors) : [],
            'colors' => $this->colors ? $this->colors : "",
            'product_price' => $this->product_price ? (string)$this->product_price : "",
            'product_discount_price' => $this->product_discount_price ? (string)$this->product_discount_price : "",
            'weight' => $this->weight ? (string)$this->weight : "",
            'product_image' => $pro_img,
            // 'product_image' => ($this->product_image) ? url('/products_img/' . $this->product_image) : url('/products_img/' . 'photo-not-available.png.png') ,
            'pro_ratings' => $this->pro_ratings ? (string)$this->pro_ratings : "",
            'product_create_date' => $this->product_create_date ? (string)$this->product_create_date : "",
            'created_at' => $this->created_at ? $this->created_at : "",
            'updated_at' => $this->updated_at ? $this->updated_at : "",
        ];
    }
}
