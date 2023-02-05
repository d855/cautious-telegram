<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Spatie\Translatable\HasTranslations;

    class Pmodel extends Model
    {

        use HasFactory, HasTranslations;

        public $translatable = ['description'];

        protected $guarded = [];
        protected $appends = ['stock', 'status', 'display_code', 'shades'];

        public function getStockAttribute()
        {
            return ProductStock::where('product_id', 'like', $this->id.'%')->sum('quantity');
        }

        public function getStatusAttribute()
        {
            $statuses = [];
            foreach (ProductStatus::select('status_id')->where('product_id', 'like', $this->id.'%')->get() as $one) $statuses[] = $one ? Status::where('id', $one['status_id'])->get() : null;
            return array_unique($statuses);
        }

        public function getDisplayCodeAttribute()
        {
            return substr_replace($this->id, '.', 2, -3);
        }

        public function getShadesAttribute()
        {
			$shades = [];
			foreach (Product::select('shade_id')->where('pid', 'like', $this->id . '%')->get() as $shade) $shades[] =
				$shade ? Shade::where('id', $shade['shade_id'])->get() : null;
			return array_unique( $shades);
        }

    }