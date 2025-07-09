<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Task extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'is_completed',
        'due_date',
    ];

    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
            'due_date' => 'date'
        ];
    }

    // By default, Spatie Media Library returns multiple files per record. To overcome that and auto-load what we actually need, let's create a special method to return the first media file for each Task. This is a bit tricky advanced Eloquent operation:

    // We need to auto-load the file with $appends Eloquent property
    // However, to avoid N+1 query performance issues, we need to check for eager loading

    protected $appends = [
        'mediaFile'
    ];

    public function getMediaFileAttribute()
    {
        if ($this->relationLoaded('media')) {
            return $this->getFirstMedia();
        }

        return null;
    }

    public function taskCategories()
    {
        return $this->belongsToMany(TaskCategory::class);
    }


}
