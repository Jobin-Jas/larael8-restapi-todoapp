<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id'];

    // protected $guarded = [];

    protected $hidden = ['updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(BlogPost::class, 'commentable');
    }
}

/**

 $blogpost->comments()->create($data);
 $comment->replies()->create($data);

 /api/blogPosts/1/comments POST

 /api/comments/1/replies POST

 /api/comments/{comment} PATCH / PUT => authorization
 /api/comments/{comment} DELETE => authorization

 CommentsController, ReplyController


 LIKE
 Step 1 : Create Model, controller and migration
      2 : Migration user_id, likeable_type, likeable_type
      3 : Add relationships to models - Blogpost, Comment, Like
      4 : Create routes and controller functions

/api/blogposts/1/likes POST
liked ? unlike : like

/api/comments/1/likes POST
liked ? unlike : like

unlike (remove from db)

 */
