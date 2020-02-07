<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Recruitment\Models\Filterable;
use Modules\User\Models\User;

class Recruitment extends Model
{
    use Filterable;
    protected $table = 'recruitments';

    protected $fillable = [
        'id',
        'user_id',
        'status',
        'position',
        'attach_file',
        'job_id',
        'created_at'
    ];
    protected $filterable = [
        'fullname',
        'job_id',
        'status',
        'created_at'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function personal()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function progresses()
    {
        return $this->hasMany(Progress::class, 'recruitment_id');
    }

    public function filterFullname($query, $value)
    {
        if ($value)
            return $query->join('user_infos', 'user_infos.user_id', '=', 'recruitments.user_id')->where('user_infos.fullname', 'LIKE', '%' . $value . '%')->select('recruitments.*');
    }

    public function filterJobId($query, $value)
    {
        if ($value != -1) return $query->where('recruitments.job_id', $value);
    }

    public function filterStatus($query, $value)
    {
        if ($value != -1) return $query->where('recruitments.status', $value);
    }

    public function filterCreatedAt($query, $value)
    {
        if ($value) {
            $value = urldecode($value);
            $arr_time = explode(" - ", $value);
            $begintime = Carbon::createFromFormat('d/m/Y H:i', $arr_time[0] . ' 00:00')->format('Y-m-d H:i:s');
            $endtime = Carbon::createFromFormat('d/m/Y H:i', $arr_time[1] . ' 23:59')->format('Y-m-d H:i:s');
            return $query->where('recruitments.created_at', '>=', $begintime)->where('recruitments.created_at', '<=', $endtime);
        }
    }
}