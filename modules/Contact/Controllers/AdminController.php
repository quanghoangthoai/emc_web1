<?php

namespace Modules\Contact\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Contact\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

use System\Core\Controllers\AdminController as SystemAdminController;

class AdminController extends SystemAdminController
{
    public function getListContacts()
    {
        $data['listContact'] = Contact::orderBy('id', 'desc')->get();
        return view('Contact::admin.list', $data);
    }

    public function getViewContact($id)
    {
        $data['contact'] = Contact::find($id);
        if ($data['contact']) {
            if ($data['contact']['status'] == 1) {
                Contact::where('id', $id)->update([
                    'reply_by' => auth('admin')->id(),
                    'reply_at' => Carbon::now(),
                    'status' => 2
                ]);
            }
            return view('Contact::admin.view', $data);
        }
        return redirect()->route('mod_contact.admin.list_contact')->with('flash_data', ['type' => 'error', 'message' => 'Không tìm thấy liên hệ']);
    }

    public function postBulkAction(Request $request)
    {
        if ($request->has('ids')) {
            $ids = $request->ids;
            if (count($ids) > 0) {
                if ($request->has('delMulti')) {
                    foreach ($ids as $id) {
                        Contact::where('id', $id)->delete();
                    }
                }
                return redirect()->route('mod_contact.admin.list_contact')->with('flash_data', ['type' => 'success', 'message' => 'Xóa thành công']);
            }
        } else {
            if ($request->has('delAll')) {
                Contact::query()->delete();
                return redirect()->route('mod_contact.admin.list_contact')->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa toàn bộ liên hệ']);
            }
        }

        return redirect()->route('mod_contact.admin.list_contact')->with('flash_data', ['type' => 'warning', 'message' => 'Vui lòng chọn liên hệ']);
    }


    public function postEditContact($id, Request $request)
    {
        if ($request->type == 'reply') {
            $request->validate([
                'reply_content' => 'required'
            ], [
                'reply_content.required' => 'Chưa nhập nội dung phản hồi'
            ]);

            Contact::where('id', $id)->update([
                'reply_content' => $request->reply_content,
                'reply_at' => Carbon::now(),
                'reply_by' => auth('admin')->id(),
                'status' => 3
            ]);
            $contact = Contact::find($id);
            Mail::send('Contact::web.mailfb', array('name' => $contact["sender_name"], 'email' => $contact["sender_email"], 'sender_content' => $contact['sender_content'], 'reply_content' => $contact["reply_content"]), function ($message) use ($contact) {
                $message->to($contact["sender_email"])->subject('Thông báo từ EMC');
            });
            Session::flash('flash_message', 'Send message successfully!');
        } elseif ($request->type == 'cancel') {
            $request->validate([
                'cancel_content' => 'required'
            ], [
                'cancel_content.required' => 'Chưa nhập lý do hủy liên hệ'
            ]);
            // change status

            Contact::where('id', $id)->update([
                'reply_content' => $request->cancel_content,
                'reply_at' => Carbon::now(),
                'reply_by' => auth('admin')->id(),
                'status' => 4
            ]);
        }

        return redirect()->route('mod_contact.admin.viewcontact', $id)->with('flash_data', ['type' => 'success', 'message' => 'Đã xử lý xong!']);
    }

    public function getConfig()
    {
        return view('Contact::admin.config');
    }

    public function postConfig(Request $request)
    {
        cms_set_config('description', $request->description, 'Contact');
        return redirect()->route('mod_contact.admin.config')->with('flash_data', ['type' => 'success', 'message' => 'Đã cập nhật dữ liệu']);
    }
}
