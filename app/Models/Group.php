<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Spatie\Translatable\HasTranslations;
    use Spatie\Sluggable\HasSlug;
    use Spatie\Sluggable\SlugOptions;
    use Spatie\Sluggable\HasTranslatableSlug;
    
    class Group extends Model
    {
        
        use HasFactory, HasTranslations, HasTranslatableSlug;
        
        public $translatable = ['name', 'slug'];
        
        protected $guarded = [];
        
        
        /**
         * Get the options for generating the slug.
         */
        /**
         * Get the options for generating the slug.
         */
        public function getSlugOptions(): SlugOptions
        {
            $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];
            
            return SlugOptions::createWithLocales($locales)
                              ->generateSlugsFrom(function ($model, $locale) {
                                  return "{$model->name}";
                              })
                              ->saveSlugsTo('slug');
        }
        
    }