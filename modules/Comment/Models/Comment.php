<?php

namespace Modules\Comment\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Post\Models\Post;
use Modules\Comment\Models\Filterable;
use Illuminate\Support\Carbon;

class Comment extends Model
{
    use Filterable;
    protected $table = 'comments';


    protected $fillable = ['user_id', 'post_id', 'parent_id', 'body', 'user_parent_id', 'module_id', 'commentable_id', 'commentable_type', 'link'];

    protected $filterable = [
        'title',
        'created_at'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function module()
    {
        return $this->belongsTo(CommentModule::class, 'module_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function filterTitle($query, $value)
    {
        if ($value != '') return $query->join('users', 'users.id', '=', 'comments.user_id')
            ->where('comments.body', 'LIKE', '%' . $value . '%')
            ->orWhere('comments.commentable_type', 'LIKE', '%' . $value . '%')
            ->orWhere('users.display_name', 'LIKE', '%' . $value . '%')->select('comments.*');
    }

    public function filterCreatedAt($query, $value)
    {
        if ($value) {
            $value = urldecode($value);
            $arr_time = explode(" - ", $value);
            $begintime = Carbon::createFromFormat('d/m/Y H:i', $arr_time[0] . ' 00:00')->format('Y-m-d H:i:s');
            $endtime = Carbon::createFromFormat('d/m/Y H:i', $arr_time[1] . '23:59')->format('Y-m-d H:i:s');
            return $query->where('comments.created_at', '>=', $begintime)->where('comments.created_at', '<=', $endtime);
        }
    }
}
