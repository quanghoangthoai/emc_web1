<?php

namespace System\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use System\Core\Controllers\AdminController;
use System\Core\Models\EmailTemplate;

class EmailTemplateController extends AdminController
{
    public function getList()
    {
        global $active_modules;
        $list_email_templates = [];
        foreach ($active_modules as $mod) {
            if (config($mod . '::mail')) {
                $arr_email_tpl = config($mod . '::mail');
                foreach ($arr_email_tpl as $email_tpl) {
                    $db_email = EmailTemplate::where('module', $mod)->where('name', $email_tpl['name'])->first();
                    if (!$db_email) {
                        $email_tpl['module'] = $mod;
                        $email_tpl['variables'] = json_encode($email_tpl['variables']);
                        $db_email = EmailTemplate::create($email_tpl);
                    }

                    $list_email_templates[$mod][] = $db_email;
                }
            }
        }
        $data['list_email_templates'] = $list_email_templates;
        return view('Admin::email_template.list', $data);
    }

    public function getEdit($id)
    {
        $data['email_tpl'] = EmailTemplate::find($id);
        if ($data['email_tpl']) {
            $data['email_tpl']['variables'] = json_decode($data['email_tpl']['variables'], true);
            return view('Admin::email_template.edit', $data);
        }
        return redirect()->route('cms.admin.list_email_templates')->with('flash_data', ['type' => 'error', 'message' => 'Truy cập không hợp lệ']);
    }

    public function postEdit($id, Request $request)
    {
        $request->validate([
            'mail_title' => 'required',
            'mail_content' => 'required'
        ], [
            'mail_title.required' => 'Chưa nhập tiêu đề email',
            'mail_content.required' => 'Chưa nhập nội dung email'
        ]);

        EmailTemplate::where('id', $id)->update([
            'mail_title' => $request->mail_title,
            'mail_content' => $request->mail_content
        ]);
        return redirect()->route('cms.admin.list_email_templates')->with('flash_data', ['type' => 'success', 'message' => 'Cập nhật mẫu email thành công']);
    }
}