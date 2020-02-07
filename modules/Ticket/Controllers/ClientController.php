<?php

namespace Modules\Ticket\Controllers;

use System\Core\Controllers\WebController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\Request\Models\RequestProduct;
use Modules\Request\Models\Requests;
use Modules\Ticket\Models\Category;
use Modules\Ticket\Models\Ticket;
use Modules\User\Models\User;
use File;
use Modules\Ticket\Models\Messages;

class ClientController extends WebController
{
    public function getTickets()
    {
        $data['listTicket'] = Ticket::where('customer_id', auth('web')->id())->orderByDesc('created_at')->get();
        return view('Ticket::web.list', $data);
    }
    public function getAddTicket()
    {
        $user_id = auth('web')->id();
        $user = User::where('id', $user_id)->first();
        $email = $user->email;
        $data['listCategory'] = Category::where('status', 1)->orderBy('order', 'ASC')->get();
        $arr_product = [];
        $request = Requests::where('client_email', $email)->get();
        if (isset($request) && count($request)) {
            foreach ($request as $iReq) {
                if ($iReq['isOrderCreated'] == 1) {
                    $product = RequestProduct::where('request_id', $iReq['id'])->get();
                    foreach ($product as $iPro) {
                        $arr_product[] = ['id' => $iPro['product_id'], 'name' => mod_ticket_get_name_product($iPro['product_id'])];
                    }
                }
            }
        }
        if (isset($arr_product) && count($arr_product)) {
            $arr_product = unique_multidim_array($arr_product, 'id');
            $data['listProduct'] = $arr_product;
            return view('Ticket::web.add', $data);
        }
        $data['listProduct'] = [];
        return view('Ticket::web.add', $data);
    }

    public function postAddTicket(Request $request)
    {
        $request->validate(
            [
                'product_id' => 'required',
                'category_id' => 'required',
                'title' => 'required|max:191',
                'content' => 'required'
            ],
            [
                'product_id.required' => 'Chưa chọn sản phẩm',
                'category_id.required' => 'Chưa chọn hạng mục',
                'title.required' => 'Chưa nhập tiêu đề',
                'title.max' => 'Tên tiêu đề vượt quá số lượng ký tự cho phép',
                'content.required' => 'Chưa nhập nội dung'
            ]
        );

        $new_ticket = Ticket::create([
            'title' => $request->title,
            'customer_id' => auth('web')->id(),
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
            'user_id' => auth('web')->id(),
            'content' => $request->content,
            'attachments' => $name_full_att,
            'reply_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('client.add_ticket')->with('success', '1');
    }

    public function getDetailTicket($id)
    {
        $data['request_detail'] = Ticket::where('id', $id)->first();
        if ($data['request_detail']) {
            if ($data['request_detail']['customer_id'] == auth('web')->id()) {
                $data['listAttachment'] = mod_ticket_get_last_list_attachment($id);
                $data['messages_detail'] = Messages::where('ticket_id', $id)->get();
                $data['listHistory'] = Messages::where('ticket_id', $id)->orderBy('id', 'DESC')->get();
                return view('Ticket::web.detail', $data);
            }
            return redirect()->route('client.tickets');
        }
        return redirect()->route('client.tickets');
    }

    public function postDetailTicket(Request $request, $id)
    {
        if ($request->has('attachments')) {
            $attachments = $request->attachments;
            $name_att = [];
            if (count($attachments)) {
                foreach ($attachments as $att) {
                    $name_att[] = time()  . $att->getClientOriginalName();
                    $path = base_path('public' . DIRECTORY_SEPARATOR . 'shared' . DIRECTORY_SEPARATOR . 'Ticket');
                    if (File::isDirectory($path)) {
                        $att->move(base_path('public' . DIRECTORY_SEPARATOR . 'shared' . DIRECTORY_SEPARATOR . 'Ticket'), time()  . $att->getClientOriginalName());
                    } else {
                        File::makeDirectory($path);
                        $att->move(base_path('public' . DIRECTORY_SEPARATOR . 'shared' . DIRECTORY_SEPARATOR . 'Ticket'), time()  . $att->getClientOriginalName());
                    }
                }
                $name_full_att = json_encode($name_att, true);
            }
        } else {
            $name_full_att = '[]';
        }
        Messages::insert([
            'ticket_id' => $id,
            'user_id' => auth('web')->id(),
            'content' => $request->content,
            'attachments' => $name_full_att,
            'reply_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]);
        Ticket::where('id', $id)->update(['status' => 7]);
        return redirect()->route('client.detail_ticket', $id);
    }

    public function getDownloadTicket($name_file)
    {
        $file = public_path('shared/Ticket/') . $name_file;
        return response()->download($file, $name_file);
    }
}
