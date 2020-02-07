<?php

namespace Modules\Contact\Controllers;

use Illuminate\Http\Request;

use Modules\Contact\Models\Contact;
use System\Core\Controllers\WebController as SystemWebController;
use System\Core\Models\Config;

class WebController extends SystemWebController
{
    // get send mail

    public function getSend()
    {
        $data['contact'] = Config::where('module', 'Contact')->first();
        return view('Contact::web.contact', $data);
    }

    public function postSend(Request $request)
    {
        $request->validate([
            'sender_name' => 'required|max:50',
            'title' => 'required|max:191',
            'sender_email' => 'required|email',
            'sender_content' => 'required',
            'sender_phone' => 'required|min:10|numeric'
        ], [
            'sender_name.required' => 'Chưa nhập họ tên',
            'sender_name.max' => 'Ký tự họ tên vượt quá số lượng cho phép',
            'title.required' => 'Chưa nhập tiêu đề',
            'title.max' => 'Ký tự tiêu đề vượt quá số lượng cho phép',
            'sender_email.required' => 'Chưa nhập email',
            'sender_email.email' => 'Email không hợp lệ',
            'sender_content.required' => 'Chưa nhập nội dung',
            'sender_phone.required' => 'Chưa nhập số điện thoại',
            'sender_phone.min' => 'Số điện thoại gồm 10 chữ số',
            'sender_phone.numeric' => 'Số điện thoại không hợp lệ'
        ]);
        Contact::create([
            'service' => $request->service,
            'title' => $request->title,
            'sender_name' => $request->sender_name,
            'sender_email' => $request->sender_email,
            'sender_content' => $request->sender_content,
            'sender_phone' => $request->sender_phone
        ]);
        return redirect()->route('mod_contact.web.send_contact')->with('success', '1');
    }
}
