<?php

namespace Modules\Recruitment\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use Filterable;
    protected $table = 'recruitment_jobs';

    protected $fillable = [
        'lang',
        'title',
        'slug',
        'position',
        'work_address',
        'work_type',
        'image',
        'people_number',
        'salary',
        'link',
        'expired_at',
        'description',
        'content',
        'seo_title',
        'seo_image',
        'seo_keywords',
        'seo_description',
        'status',
        'order',
        'contact_info'
    ];

    protected $filterable = [
        'title',
        'status',
        'created_at',
    ];

    public function filterTitle($query, $value)
    {
        if (!empty($value)) return $query->where('title', 'LIKE', '%' . $value . '%');
    }

    public function filterStatus($query, $value)
    {
        if ($value != -1) return $query->where('status', $value);
    }

    public function filterCreatedAt($query, $value)
    {
        if ($value) {
            $value = urldecode($value);
            $arr_time = explode(" - ", $value);
            $begintime = Carbon::createFromFormat('d/m/Y H:i', $arr_time[0] . ' 00:00')->format('Y-m-d H:i:s');
            $endtime = Carbon::createFromFormat('d/m/Y H:i', $arr_time[1] . '23:59')->format('Y-m-d H:i:s');
            return $query->where('created_at', '>=', $begintime)->where('created_at', '<=', $endtime);
        }
    }
}