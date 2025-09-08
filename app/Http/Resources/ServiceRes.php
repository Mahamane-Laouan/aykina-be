<?php

namespace App\Http\Resources;

use App\Http\Controllers\API\BaseController;
use App\Models\SubCategoryModel;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Service;

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

        // $imgs = explode("::::", $this->service_image);
        // $pro_img = array();

        // $images = explode("::::", $this->service_image);
        // $imgs = array();
        // $imgsa = array();
        // foreach ($images as $key => $image) {

        //     $imgs = asset('public/images/service_images/' . $image);

        //     array_push($imgsa, $imgs);
        // }

        // $pro_img = $imgsa;
        $pro_img = array();

        $services_all = Service::where('id', $this->id)->with('serviceImages')->first();

        $imgsa = [];

        foreach ($services_all->serviceImages as $image) {
            $imgsa[] = asset('/images/service_images/' . $image->service_images); // 'image_path' is the column name
        }

        $pro_img = $imgsa;

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
