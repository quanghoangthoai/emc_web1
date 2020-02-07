<?php

use Illuminate\Support\Str;
use Modules\Recruitment\Models\EmailTemplate;
use Modules\Recruitment\Models\Job;
use Modules\Recruitment\Models\Progress;

if (!function_exists('mod_recruitment_list_status')) {
    function mod_recruitment_list_status()
    {
        $data = [
            '0' => 'Mới',
            '1' => 'Đã tiếp nhận',
            '2' => 'Mời phỏng vấn',
            '3' => 'Tuyển dụng thành công',
            '4' => 'Tuyển dụng thất bại',
        ];
        return $data;
    }
}

if (!function_exists('mod_recruitment_get_status')) {
    function mod_recruitment_get_status($id)
    {
        $json = '[
                {"id":0,"status":"Mới","colorClass":"badge badge-warning"},
                {"id":1,"status":"Đã tiếp nhận","colorClass":"badge badge-info"},
                {"id":2,"status":"Mời phỏng vấn","colorClass":"badge badge-success"},
                {"id":3,"status":"Tuyển dụng thành công","colorClass":"badge badge-light"},
                {"id":4,"status":"Tuyển dụng thất bại","colorClass":"badge badge-danger"}
            ]';
        $arr = json_decode($json, true);
        $string = '';
        if ($arr) {
            foreach ($arr as $iArr) {
                if ($iArr['id'] == $id) {
                    $string = '<span class="' . $iArr['colorClass'] . '">' . $iArr['status'] . '</span>';
                    break;
                }
            }
        }
        return $string;
    }
}

if (!function_exists('mod_recruitment_list_mail_template')) {
    function mod_recruitment_list_mail_template()
    {
        $data = EmailTemplate::orderBy('id', 'asc')->get();
        return $data;
    }
}

if (!function_exists('mod_recruitment_list_progress_by_recruitment_id')) {
    function mod_recruitment_list_progress_by_recruitment_id($id)
    {
        $data = Progress::where('recruitment_id', $id)->orderBy('created_at', 'desc')->get();
        foreach ($data as $iProg) {
            if ($iProg->user) {
                $iProg['user_fullname'] = $iProg->user->info['fullname'];
                $iProg['user_department'] = $iProg->user->info->department['name'];
            } else {
                $iProg['user_fullname'] = 'Ai đó';
                $iProg['user_department'] = 'Không xác định';
            }
        }

        return $data;
    }
}
if (!function_exists('mod_recruitment_str_limit')) {
    function mod_recruitment_str_limit($text, $num = 10)
    {
        return Str::limit($text, $num);
    }
}
if (!function_exists('mod_recruitment_fix_job_order')) {
    function mod_recruitment_fix_job_order()
    {
        $listJob = Job::select('id')->orderBy('order', 'asc')->get();
        $weight = 0;
        foreach ($listJob as $cat) {
            ++$weight;
            Job::where('id', $cat['id'])->update([
                'order' => $weight
            ]);
        }
        return true;
    }
}