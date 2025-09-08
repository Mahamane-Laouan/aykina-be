<?php

namespace App\Http\Resources;

use App\Http\Controllers\API\BaseController;
use App\Models\SubCategoryModel;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRes extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $imgs = explode("::::", $this->service_image);
        $pro_img = array();
        // foreach ($imgs as $img) {
        //     if (strpos($img, 'products_img/') !== false) {
        //         $image = new BaseController;
        //         $pro_img[] = $image->s3FetchFile($img);
        //     } else {
        //         $pro_img[] = url('/products_img/' . $img);
        //     }
        // }
        
        
         $images = explode("::::", $this->service_image);
            $imgs = array();
            $imgsa = array();
            foreach ($images as $key => $image) {


                // $imgs =  asset('assets/images/post/'. $image);

                $imgs = asset('public/images/service_images/' . $image);

                array_push($imgsa, $imgs);
            }
            // $user->service_image = $imgsa;

            $pro_img = $imgsa;

        // if (strpos($this->icon, '/') !== false) {
        //     $icon = new BaseController;
        //     $icon_pic = $icon->s3FetchFile($this->icon);
        // } else {
        //     $icon_pic = url('/category_img/' . $this->icon);
        // }
        
        $cat_name = Category::where('id', $this->cat_id)->first();

        return [
            'service_id' => (string)$this->id,
            'cat_id' => (string)$this->cat_id,
            'cat_name' => $cat_name ? $cat_name->c_name : "",
            'res_id' => (string)$this->res_id,
            'v_id' => (string)$this->v_id,
            'service_name' => $this->service_name ? $this->service_name : "",
            'service_description' => $this->service_description ? $this->service_description : "",
            'service_price' => $this->service_price ? (string)$this->service_price : "",
            'service_discount_price' => $this->service_discount_price ? (string)$this->service_discount_price : "",
            'price_unit' => $this->price_unit ? (string)$this->price_unit : "",
            'duration' => $this->duration ? (string)$this->duration : "",
            'start_time' => $this->start_time ? (string)$this->start_time : "",
            'end_time' => $this->end_time ? (string)$this->end_time : "",
            'start_time_period' => $this->start_time_period ? (string)$this->start_time_period : "",
            'end_time_period' => $this->end_time_period ? (string)$this->end_time_period : "",
            'is_features' => $this->is_features ? (string)$this->is_features : "",
            'status' => $this->status ? (string)$this->status : "",
            'service_image' => $pro_img,
            'created_date' => $this->created_date ? (string)$this->created_date : "",
            'created_at' => $this->created_at ? $this->created_at : "",
            'updated_at' => $this->updated_at ? $this->updated_at : "",
        ];
    }
}
