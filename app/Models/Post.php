<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    protected $with = ['category', 'author'];
    // protected $fillable = ['title', 'excerpt', 'body'];

    public function scopeFilter($query, array $filters) // Post::newQuery()->filter()
    {
        // Query bug was fixed in v-42 branch. We needed to add an additional where clause. 
        $query->when($filters['search'] ?? false, fn ($query, $search) =>
            $query->where(fn($query) => 
                $query->where('title', 'like', '%'. $filters['search'] . '%')
                    ->orWhere('body', 'like', '%'.  $filters['search']. '%'))
        );

        $query->when($filters['category'] ?? false, fn ($query, $category) =>
            $query->whereHas('category', fn($query) =>
                $query->where('slug', $category))
        );

        $query->when($filters['author'] ?? false, fn ($query, $author) =>
            $query->whereHas('author', fn($query) =>
                $query->where('username', $author))
        );
     
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
