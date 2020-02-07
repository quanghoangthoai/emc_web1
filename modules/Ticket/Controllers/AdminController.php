<?php

namespace Modules\Ticket\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use System\Core\Controllers\AdminController as SystemAdminController;
use Modules\Ticket\Models\Category;
use Modules\Ticket\Models\ReplyTemplate;
use Modules\Ticket\Models\Ticket;
use Modules\Ticket\Models\Messages;
use Modules\User\Models\Department;
use Modules\User\Models\User;
use File;
use Modules\Request\Models\RequestProduct;
use Modules\Request\Models\Requests;

class AdminController extends SystemAdminController
{
    // Controller for ticket

    public function getListTicket(Request $request)
    {
        $param = $request->all();
        $filterdata = Ticket::filter($param);
        $data['listTic'] = $filterdata->orderBy('id', 'desc')->paginate(5)->appends(request()->except('page'));
        if (isset($param['created_at'])) {
            $arr_time = explode(" - ", $param['created_at']);
            $param['begindate'] = $arr_time[0];
            $param['enddate'] = $arr_time[1];
        }
        $data['filterdata'] = $param;
        $data['listTicket'] = Ticket::orderByDesc('created_at')->paginate(5);
        return view('Ticket::admin.ticket.list', $data);
    }


    public function getDetailTicket($id)
    {
        if (mod_ticket_check_role_customer(auth('admin')->id()) == false) {
            $data['ticket_detail'] = Ticket::where('id', $id)->first();
            if ($data['ticket_detail']) {
                if ($data['ticket_detail']['status'] == 1) {
                    Ticket::where('id', $id)->update(['status' => 2]);
                }
                $data['listAttachment'] = mod_ticket_get_last_list_attachment($id);
                $data['messages_detail'] = Messages::where('ticket_id', $id)->get();
                $data['listHistory'] = Messages::where('ticket_id', $id)->orderBy('id', 'DESC')->get();
                $data['listDepament'] = Department::all();
                $data['listReply'] = ReplyTemplate::all();
                $data['listStaff'] = User::all();
                return view('Ticket::admin.ticket.detail', $data);
            }
            return redirect()->route('mod_ticket.admin.list_ticket')->with('flash_data', ['type' => 'error', 'message' => 'Không tìm thấy yêu cầu']);
        }
        return redirect()->route('mod_ticket.admin.list_ticket')->with('flash_data', ['type' => 'error', 'message' => 'Bạn không có quyền xem']);
    }

    public function postDetailTicket(Request $request, $id)
    {
        $request->validate(
            [
                'content_reply' => 'required'
            ],
            [
                'content_reply.required' => 'Chưa nhập nội dung phản hồi'
            ]
        );
        if ($request->has('attachments')) {
            $attachments = $request->attachments;
            $name_att = [];
            if (count($attachments)) {
                foreach ($attachments as $att) {
                    if ($att != null) {
                        $name_att[] = time()  . $att->getClientOriginalName();
                        $path = base_path('public' . DIRECTORY_SEPARATOR . 'shared' . DIRECTORY_SEPARATOR . 'Ticket');
                        if (File::isDirectory($path)) {
                            $att->move(base_path('public' . DIRECTORY_SEPARATOR . 'shared' . DIRECTORY_SEPARATOR . 'Ticket'), time()  . $att->getClientOriginalName());
                        } else {
                            File::makeDirectory($path);
                            $att->move(base_path('public' . DIRECTORY_SEPARATOR . 'shared' . DIRECTORY_SEPARATOR . 'Ticket'), time()  . $att->getClientOriginalName());
                        }
                    }
                }
                $name_full_att = json_encode($name_att, true);
            }
        } else {
            $name_full_att = '[]';
        }
        Ticket::where('id', $id)->update([
            'staff_id' => auth('admin')->id(),
            'status' => 4
        ]);

        Messages::insert([
            'ticket_id' => $id,
            'user_id' => auth('admin')->id(),
            'content' => $request->content_reply,
            'attachments' => $name_full_att,
            'reply_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        return redirect()->route('mod_ticket.admin.detail_ticket', $id)->with('flash_data', ['type' => 'success', 'message' => 'Phản hồi thành công']);
    }

    public function getDetailHistory($reply_at)
    {
        $data['history_detail'] = Messages::where('reply_at', $reply_at)->first()->toArray();
        $data['listAttachmentHistory'] = mod_ticket_get_list_attachment($reply_at);
        $id = $data['history_detail']['ticket_id'];
        dd($data['listAttachmentHistory']);
        return redirect()->route('mod_ticket.admin.detail_ticket', $id);
    }


    public function getContentReply($id)
    {
        $content = ReplyTemplate::Where('id', $id)->first();
        echo $content['content'];
    }

    public function getDeleteTicket($id)
    {
        if (mod_ticket_check_role_customer(auth('admin')->id()) == false) {
            Messages::where('ticket_id', $id)->delete();
            Ticket::where('id', $id)->delete();
            return redirect()->route('mod_ticket.admin.list_ticket')->with('flash_data', ['type' => 'success', 'message' => 'Xóa thành công']);
        }
        return redirect()->route('mod_ticket.admin.list_ticket')->with('flash_data', ['type' => 'error', 'message' => 'Bạn không có quyền xóa']);
    }

    public function getCreateTicket()
    {
        $data['listCategory'] = Category::where('status', 1)->orderBy('order', 'ASC')->get();
        return view('Ticket::admin.ticket.createticket', $data);
    }

    public function postCreateTicket(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'product_id' => 'required',
                'category_id' => 'required',
                'title' => 'required|max:191',
                'content' => 'required'
            ],
            [
                'email.required' => 'Chưa nhập email',
                'email.email' => 'Email không hợp lệ',
                'product_id.required' => 'Chưa chọn sản phẩm',
                'category_id.required' => 'Chưa chọn hạng mục',
                'title.required' => 'Chưa nhập tiêu đề',
                'title.max' => 'Tên tiêu đề vượt quá số lượng ký tự cho phép',
                'content.required' => 'Chưa nhập nội dung'
            ]
        );

        $email = $request->email;
        $user = User::where('email', $email)->first();
        if (isset($user)) {
            $user_id = $user->id;
            if (mod_ticket_check_role_customer($user_id) == true) {
                if (mod_ticket_check_use_product($user->email, $request->product_id) == true) {
                    $new_ticket = Ticket::create([
                        'title' => $request->title,
                        'staff_id' => auth('admin')->id(),
                        'customer_id' => $user_id,
                        'product_id' => $request->product_id,
                        'category_id' => $request->category_id,
                        'created_at' => Carbon::now()
                    ]);

                    $new_ticket->fill(['order' => $new_ticket['id']])->save();

                    if ($request->has('attachments')) {
                        $attachments = $request->attachments;
                        $name_att = [];
                        if (count($attachments)) {
                            foreach ($attachments as $att) {
                                if ($att != null) {
                                    $name_att[] = time()  . $att->getClientOriginalName();
                                    $path = base_path('public' . DIRECTORY_SEPARATOR . 'shared' . DIRECTORY_SEPARATOR . 'Ticket');
                                    if (File::isDirectory($path)) {
                                        $att->move(base_path('public' . DIRECTORY_SEPARATOR . 'shared' . DIRECTORY_SEPARATOR . 'Ticket'), time()  . $att->getClientOriginalName());
                                    } else {
                                        File::makeDirectory($path);
                                        $att->move(base_path('public' . DIRECTORY_SEPARATOR . 'shared' . DIRECTORY_SEPARATOR . 'Ticket'), time()  . $att->getClientOriginalName());
                                    }
                                }
                            }
                            $name_full_att = json_encode($name_att, true);
                        }
                    } else {
                        $name_full_att = '[]';
                    }

                    Messages::insert([
                        'ticket_id' => $new_ticket['id'],
                        'user_id' => auth('admin')->id(),
                        'content' => $request->content,
                        'attachments' => $name_full_att,
                        'reply_at' => Carbon::now(),
                        'created_at' => Carbon::now()
                    ]);

                    return redirect()->route('mod_ticket.admin.create_ticket')->with('flash_data', ['type' => 'success', 'message' => 'Tạo yêu cầu thành công']);
                } else {
                    return redirect()->route('mod_ticket.admin.create_ticket')->withInput()->with('flash_data', ['type' => 'error', 'message' => 'Sản phẩm khách hàng chưa sử dụng']);
                }
            } else {
                return redirect()->route('mod_ticket.admin.create_ticket')->withInput()->with('flash_data', ['type' => 'error', 'message' => 'Không phải Email của khách hàng']);
            }
        } else {
            return redirect()->route('mod_ticket.admin.create_ticket')->withInput()->with('flash_data', ['type' => 'error', 'message' => 'Email không tồn tại trong hệ thống']);
        }
    }

    // download file

    public function getDownload($name_file)
    {
        $file = public_path('shared/Ticket/') . $name_file;
        return response()->download($file, $name_file);
    }

    public function getDownloadFileManager($name_file)
    {
        $file = public_path('shared/Ticket/') . $name_file;
        return response()->download($file, $name_file);
    }

    // Controller for Category

    public function getListCategory()
    {
        if (mod_ticket_check_role_customer(auth('admin')->id()) == false) {
            $data['listCategory'] = Category::orderBy('order', 'ASC')->get();
            return view('Ticket::admin.category.list', $data);
        }
        return redirect()->route('mod_ticket.admin.list_ticket')->with('flash_data', ['type' => 'error', 'message' => 'Bạn không có quyền quản lý hạng mục']);
    }

    public function postAddCategory(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:ticket_categories,name|max:191'
            ],
            [
                'name.unique' => 'Tên hạng mục đã tồn tại',
                'name.required' => 'Chưa nhập tên hạng mục',
                'name.max' => 'Tên hạng mục vượt quá số lượng ký tự cho phép'
            ]
        );

        $new_category = Category::create([
            'name' => $request->name,
            'status' => $request->status
        ]);

        $new_category->fill(['order' => $new_category['id']])->save();

        return redirect()->route('mod_ticket.admin.list_category')->with('flash_data', ['type' => 'success', 'message' => 'Đã thêm hạng mục']);
    }

    public function getEditCategory($id)
    {
        $data['category_edit'] = Category::where('id', $id)->first();
        if ($data['category_edit']) {
            $data['listCategory'] = Category::orderBy('order', 'ASC')->get();
            return view('Ticket::admin.category.edit', $data);
        }
        return redirect()->route('mod_ticket.admin.list_category')->with('flash_data', ['type' => 'error', 'message' => 'Không tìm thấy hạng mục']);
    }

    public function postEditCategory(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|max:191'
            ],
            [
                'name.required' => 'Chưa nhập tên hạng mục',
                'name.max' => 'Tên hạng mục vượt quá số lượng ký tự cho phép'
            ]
        );

        Category::where('id', $id)->update([
            'name' => $request->name,
            'status' => $request->status
        ]);
        return redirect()->route('mod_ticket.admin.list_category')->with('flash_data', ['type' => 'success', 'message' => 'Cập nhật thành công']);
    }

    public function getDeleteCategory($id)
    {
        Category::where('id', $id)->delete();
        return redirect()->route('mod_ticket.admin.list_category')->with('flash_data', ['type' => 'success', 'message' => 'Xóa thành công']);
    }

    public function ajaxChangeOrderCategory(Request $request)
    {
        $id = $request->id;
        $order = $request->order;
        Category::where('id', $id)->update(['order' => $order]);
        $request->session()->flash('flash_data', ['type' => 'success', 'message' => 'Cập nhật thành công']);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công'
        ]);
    }

    public function changeStatusCategory(Request $request)
    {
        try {
            Category::where('id', $request->id)->update([
                'status' => $request->status,
            ]);
            return response()->json(['status' => true, 'msg' => 'Đã cập nhật trạng thái']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Đã có lỗi xảy ra']);
        }
    }

    public function ajaxChangeStatusTicket(Request $request)
    {
        try {
            Ticket::where('id', $request->id)->update([
                'status' => $request->status,
            ]);
            return response()->json(['status' => true, 'msg' => 'Đã cập nhật trạng thái']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Đã có lỗi xảy ra']);
        }
    }

    public function ajaxLoadProductFromEmail(Request $request)
    {
        try {
            $email = $request->email;
            if ($email != null) {
                $user_id = User::where('email', $email)->first();
                if (mod_ticket_check_role_customer($user_id['id']) == true) {
                    $arr_product = [];
                    $request = Requests::where('client_email', $email)->get();
                    if (isset($request) && count($request)) {
                        foreach ($request as $iReq) {
                            if ($iReq['isOrderCreated'] == 1) {
                                $product = RequestProduct::where('request_id', $iReq['id'])->get();
                                foreach ($product as $iPro) {
                                    $arr_product[] = '<option value="' . $iPro['product_id'] . '">' . mod_ticket_get_name_product($iPro['product_id']) . '</option>';
                                }
                            }
                        }
                    }
                    if (isset($arr_product) && count($arr_product)) {
                        $arr_product = array_unique($arr_product);
                        return response()->json(['status' => true, 'data' => $arr_product, 'msg' => 'Kiểm tra thành công']);
                    }
                    return response()->json(['status' => false, 'data' => '<option value="">-- Không có sản phẩm nào --</option>', 'msg' => 'Khách hàng chưa mua sản phẩm nào']);
                }
                return response()->json(['status' => false, 'msg' => 'Email này không phải của khách hàng']);
            }
            return response()->json(['status' => false, 'msg' => 'Vui lòng nhập Email để kiểm tra']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Email không hợp lệ']);
        }
    }

    // Controller for ReplyTemplate

    public function getListReplyTemplate()
    {
        if (mod_ticket_check_role_customer(auth('admin')->id()) == false) {
            $data['listReplyTemplate'] = ReplyTemplate::orderBy('order', 'ASC')->get();
            return view('Ticket::admin.replytemplate.list', $data);
        }
        return redirect()->route('mod_ticket.admin.list_ticket')->with('flash_data', ['type' => 'error', 'message' => 'Bạn không có quyền quản lý mẫu phản hồi']);
    }

    public function postAddReplyTemplate(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:191',
                'content' => 'required'
            ],
            [
                'name.required' => 'Chưa nhập tên mẫu',
                'content.required' => 'Chưa nhập nội dung',
                'name.max' => 'Tên mẫu vượt quá số lượng ký tự cho phép'
            ]
        );

        $new_ReplyTemplate = ReplyTemplate::create([
            'name' => $request->name,
            'content' => $request->content
        ]);

        $new_ReplyTemplate->fill(['order' => $new_ReplyTemplate['id']])->save();

        return redirect()->route('mod_ticket.admin.list_replytemplate')->with('flash_data', ['type' => 'success', 'message' => 'Thêm mẫu phản hồi thành công']);
    }

    public function getEditReplyTemplate($id)
    {
        $data['ReplyTemplate_edit'] = ReplyTemplate::where('id', $id)->first();
        if ($data['ReplyTemplate_edit']) {
            $data['listReplyTemplate'] = ReplyTemplate::orderBy('order', 'ASC')->get();
            return view('Ticket::admin.ReplyTemplate.edit', $data);
        }
        return redirect()->route('mod_ticket.admin.list_replytemplate')->with('flash_data', ['type' => 'error', 'message' => 'Không tìm thấy mẫu trả lời']);
    }

    public function postEditReplyTemplate(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|max:191',
                'content' => 'required'
            ],
            [
                'name.required' => 'Chưa nhập tên mẫu trả lời',
                'content.required' => 'Chưa nhập nội dung',
                'name.max' => 'Tên mẫu vượt quá số lượng ký tự cho phép'
            ]
        );

        ReplyTemplate::where('id', $id)->update([
            'name' => $request->name,
            'content' => $request->content
        ]);
        return redirect()->route('mod_ticket.admin.list_replytemplate')->with('flash_data', ['type' => 'success', 'message' => 'Cập nhật thành công']);
    }

    public function getDeleteReplyTemplate($id)
    {
        ReplyTemplate::where('id', $id)->delete();
        return redirect()->route('mod_ticket.admin.list_replytemplate')->with('flash_data', ['type' => 'success', 'message' => 'Xóa thành công']);
    }

    public function ajaxChangeOrderReplyTemplate(Request $request)
    {
        $id = $request->id;
        $order = $request->order;
        ReplyTemplate::where('id', $id)->update(['order' => $order]);
        $request->session()->flash('flash_data', ['type' => 'success', 'message' => 'Cập nhật thành công']);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công'
        ]);
    }
}
