<?php

namespace Modules\Request\Controllers;

use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Product\Models\Category as ProductCategory;
use Modules\Product\Models\Product;
use Modules\Request\Models\RequestImage;
use Modules\Request\Models\RequestProduct;
use Modules\Request\Models\Requests;
use Modules\User\Models\User;
use Spatie\Activitylog\Models\Activity;
use System\Core\Controllers\AdminController as SystemAdminController;

class AdminController extends SystemAdminController
{


    public function getListRequest(Request $request)
    {
        $param = $request->all();
        $filterdata = Requests::filter($param);
        $data['listRequest'] = $filterdata->orderBy('order', 'desc')->paginate(10);
        return view('Request::admin.list', $data);
    }

    public function getAddRequest()
    {
        session()->forget('shopping_cart_id');
        return view('Request::admin.add');
    }

    public function postAddRequest(Request $request)
    {
        $request->validate([
            'client_name' => 'required|max:255',
            'client_phone' => 'required|numeric|digits:10',
            'client_email' => 'required|email',
            'product_ids' => 'required',
            'status' => 'required',
            'confirm_image' => 'required_if:status,==,1|max:2048',
        ], [
            'status.required' => 'Chưa chọn trạng thái',
            'client_phone.required' => 'Chưa nhập số điện thoại khách hàng',
            'client_phone.numeric' => 'Số điện thoại chứa kí tự không phải là số',
            'client_phone.digits' => 'Số điện thoại chứa đủ 10 số',
            'client_phone.required' => 'Chưa nhập số điện thoại khách hàng',
            'client_email.required' => 'Chưa nhập email khách hàng',
            'client_email.email' => 'Chưa nhập đúng kiểu email',
            'client_name.required' => 'Chưa nhập tên khách hàng',
            'client_name.max' => 'Tên quá 255 kí tự',
            'product_ids.required' => 'Chưa chọn sản phẩm',
            'confirm_image.required_if' => 'Yêu cầu nhập hình ảnh chứng từ',
            'confirm_image.max' => 'Hình ảnh tối đa 2mb'
        ]);

        if ($request['status'] == 1) {
            $request->validate([
                'confirm_image' => 'required'
            ], [
                'confirm_image.required' => 'Vui lòng nhập hình ảnh chứng từ',
            ]);
        }
        $maxOrder = Requests::max('order');

        if (!mod_request_check_email_user_exist($request['client_email'])) {
            $client = User::create([
                'email' => $request['client_email'],
                'password' => Hash::make('123456'),
                'display_name' => $request['client_name']
            ]);

            $contact = [
                'sender_name' => $request['client_name'],
                'sender_email' => $request['client_email'],
                'password' => '123456',
            ];

            Mail::send('Request::admin.component.mailfb', array('name' => $contact["sender_name"], 'email' => $contact["sender_email"], 'password' => $contact["password"]), function ($message) use ($contact) {
                $message->to($contact["sender_email"])->subject('Thông báo từ EMC');
            });
        } else
            $client = User::Where('email', $request['client_email'])->firstOrFail();
        // Upload Image

        $insert['imagePath'] = null;
        if ($files = $request->file('confirm_image')) {
            $destinationPath = 'public/request/'; // upload path
            $profilefile = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profilefile);
            $insert['imagePath'] = '/' . $destinationPath . $profilefile;
        }

        $clientRequest = Requests::create([
            'staff_id' => auth('admin')->id(),
            'client_id' => $client['id'],
            'client_name' => $request['client_name'],
            'client_phone' => $request['client_phone'],
            'client_email' => $request['client_email'],
            'total' => $request['total'],
            'payment' => $request['payment'],
            'payment_method' => $request['payment_method'],
            'note' => $request['note'],
            'status' => $request['status'],
            'vat_percent' => $request['vat_percent'],
            'sale_percent' => $request['sale_percent'],
            'vat_percent' => $request['vat_percent'],
            'confirm_image' => $insert['imagePath'],
            'order' => $maxOrder ? $maxOrder + 1 : 1,
        ]);

        if ($clientRequest) {
            activity()
                ->performedOn($clientRequest)
                ->causedBy(auth('admin')->id())
                ->withProperties(['request_id' => $clientRequest->id, 'note' => $request['note']])
                ->log('Tạo yêu cầu');
        }
        foreach ($request['product_ids'] as $product_id) {
            RequestProduct::create([
                'request_id' => $clientRequest['id'],
                'product_id' => $product_id
            ]);
        }

        $listProduct = [];
        foreach ($clientRequest->requestProduct as $item) {
            $listProduct[] = $item->product;
        }
        $contact = [
            'sender_name' => $clientRequest['client_name'],
            'sender_email' => $clientRequest['client_email'],
            'iRequest' => $clientRequest,
            'payment_method' => mod_request_get_payment_name($clientRequest['payment_method']),
            'listProduct' => $listProduct
        ];

        Mail::send('Request::admin.component.mail-request-info', array('name' => $contact["sender_name"], 'payment_method' => $contact['payment_method'], 'listProduct' => $contact['listProduct'], 'email' => $contact["sender_email"], 'iRequest' => $contact["iRequest"]), function ($message) use ($contact) {
            $message->to($contact["sender_email"])->subject('Thông báo từ EMC');
        });


        return redirect()->route('mod_request.admin.list_request')->with('flash_data', ['type' => 'success', 'message' => 'Thêm yêu cầu thành công']);
    }

    public function getDetailRequest($id)
    {
        $iRequest = Requests::find($id);
        if ($iRequest['isOrderCreated']) {
            $requestProduct = [];
            if ($iRequest->requestProduct) {
                $requestProduct = RequestProduct::Where('request_id', $id)->pluck('product_id')->toArray();
                $shoppingCart =  Product::whereIn('id', $requestProduct)->get();
            }
            $data['iRequest'] = $iRequest;
            $data['requestProduct'] = $requestProduct;
            $data['shoppingCart'] = $shoppingCart;
            $data['images'] = $iRequest->requestImage;
            $data['listActivity'] = Activity::where(['subject_type' => 'Modules\Request\Models\Requests', 'subject_id' => $id])->orderBy('created_at', 'desc')->get();
            return view('Request::admin.detail', $data);
        }
    }
    public function getEditRequest($id)
    {

        $iRequest = Requests::find($id);
        if (!$iRequest['isOrderCreated']) {
            $requestProduct = [];
            if ($iRequest->requestProduct) {
                $requestProduct = RequestProduct::Where('request_id', $id)->pluck('product_id')->toArray();
                $shoppingCart =  Product::whereIn('id', $requestProduct)->get();
            }
            $data['iRequest'] = $iRequest;
            $data['requestProduct'] = $requestProduct;
            $data['shoppingCart'] = $shoppingCart;
            $data['images'] = $iRequest->requestImage;
            $data['listActivity'] = Activity::where(['subject_type' => 'Modules\Request\Models\Requests', 'subject_id' => $id])->orderBy('created_at', 'desc')->get();
            return view('Request::admin.edit', $data);
        } else
            return redirect()->route('mod_request.admin.detail_request', $id)->with('flash_data', ['type' => 'warning', 'message' => 'Chuyển về trang chi tiết yêu cầu']);
    }


    public function postEditRequest($id, Request $request)
    {
        $request->validate([
            'status' => 'required',
            'confirm_image_check' => 'required_if:status,==,1',
            'confirm_image' => 'max:2048'
        ], [
            'status.required' => 'Chưa chọn trạng thái',
            'confirm_image_check.required_if' => 'Yêu cầu nhập hình ảnh chứng từ',
            'confirm_image.max' => 'Hình ảnh tối đa 2mb'
        ]);
        $iRequest = Requests::find($id);
        // Upload Image
        $insert['imagePath'] = $iRequest['confirm_image'];
        if ($request['change_image_flag'] == 1) {
            if ($files = $request->file('confirm_image')) {
                if (file_exists(public_path() . $iRequest['confirm_image'])) {
                    File::delete(public_path() . $iRequest['confirm_image']);
                }
                $destinationPath = 'public/request/'; // upload path
                $profilefile = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profilefile);
                $insert['imagePath'] = '/' . $destinationPath . $profilefile;
            } else {
                if (file_exists(file_exists(public_path() . $iRequest['confirm_image']))) {
                    File::delete(public_path() . $iRequest['confirm_image']);
                }
                $insert['imagePath'] = null;
            }
        }

        $iRequest->update([
            'status' => $request['status'],
            'confirm_image' => $insert['imagePath'],
            'note' => $request['note']
        ]);

        if ($iRequest) {
            activity()
                ->performedOn(Requests::find($id))
                ->causedBy(auth('admin')->id())
                ->withProperties(['request_id' => $id, 'note' => $request['note'], 'type' => 'status', 'value' => $request['status'], 'action' => 'đổi trạng thái'])
                ->log('Sửa yêu cầu #' . $id);
        }


        return redirect()->route('mod_request.admin.edit_request', $id)->with('flash_data', ['type' => 'success', 'message' => 'Sửa yêu cầu thành công']);
    }

    // public function deleteRequest($id)
    // {
    //     $clientRequest = Requests::find($id);
    //     if ($clientRequest->requestProduct()) {
    //         foreach ($clientRequest->requestProduct() as $item) {
    //             $item->delete();
    //         }
    //     }
    //     activity()
    //         ->performedOn($clientRequest)
    //         ->causedBy(auth('admin'))
    //         ->withProperties(['request_id' => $id])
    //         ->log('Xóa yêu cầu #' . $id);
    //     RequestImage::where('request_id', $id)->delete();
    //     $clientRequest->delete();

    //     return redirect()->route('mod_request.admin.list_request')->with('flash_data', ['type' => 'success', 'message' => 'Xóa yêu cầu thành công']);
    // }

    public function ajaxDeleteImage(Request $request)
    {
        $iRequest = Request::find($request['id']);
        activity()
            ->performedOn(Requests::find($iRequest))
            ->causedBy(auth('admin')->id())
            ->withProperties(['request_id' => $iRequest['id'], 'type' => 'image', 'action' => 'Xóa hình ảnh'])
            ->log('Yêu cầu #' . $iRequest['id']);
        $iRequest->requestImage->delete();

        return view('Request::admin.component.fetch-image');
    }

    public function getDownload($id)
    {

        if (auth('admin')->check()) {
            $iRequest = Requests::find($id);

            if ($iRequest) {
                if ($iRequest['confirm_image']) {
                    activity()
                        ->performedOn($iRequest)
                        ->causedBy(auth('admin')->id())
                        ->withProperties(['request_id' => $iRequest['id'], 'type' => 'image', 'action' => 'Tải hình ảnh xuống'])
                        ->log('Yêu cầu #' . $iRequest['id']);
                    return response()->streamDownload(function () use ($iRequest) {
                        echo file_get_contents(public_path($iRequest['confirm_image']));
                    }, File::name(public_path($iRequest['confirm_image'])) . '.' . File::extension(public_path($iRequest['confirm_image'])));
                } else return "Error";
            }
            return "Error";
        }
        return "Error";
    }

    public function ajaxUploadImage(Request $request)
    {
        $iRequest = Requests::find($request['id']);

        if (!isset($iRequest->requestImage)) {
            activity()
                ->performedOn(Requests::find($iRequest))
                ->causedBy(auth('admin')->id())
                ->withProperties(['request_id' => $iRequest['id'], 'type' => 'image', 'action' => 'Tải hình ảnh lên'])
                ->log('Sửa yêu cầu #' . $iRequest['id']);
            RequestImage::create([
                'request_id' => $iRequest['id'],
                'path' => $request['path']
            ]);
        }
    }

    public function ajaxChangRequest(Request $request)
    {
        $id = $request->id;
        $order = $request->order;
        $listRequest = Requests::where([['id', '!=', $id]])->orderBy('order', 'asc')->get();
        $weight = 0;
        foreach ($listRequest as $iReq) {
            ++$weight;
            if ($weight == $order) {
                ++$weight;
            }
            Requests::where('id', $iReq['id'])->update(['order' => $weight]);
        }
        Requests::where('id', $id)->update(['order' => $order]);
        mod_request_fix_request_order();
        $request->session()->flash('flash_data', ['type' => 'success', 'message' => 'Cập nhật thành công']);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công'
        ]);
    }



    public function ajaxFetchItem()
    {
        $data['listProduct'] = Product::orderBy('id', 'desc')->get();
        $returnHTML = view('Request::admin.component.fetch-item', $data)->render(); // or method that you prefere to return data + RENDER is the key here
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function ajaxFetchCart(Request $request)
    {
        $total_price = 0;
        $total_item = 0;
        $shoppingCart = null;
        if ($request['product_ids']) {
            $shoppingCart =  Product::whereIn('id', $request['product_ids'])->get();
            foreach ($shoppingCart as $item) {
                session()->push('shopping_cart_id', $item['id']);
                if ($item['enable_sale']) {
                    $total_price +=  $item['sale_price'];
                } else {
                    $total_price +=  $item['price'];
                }
            }
        } else
         if (session()->get('shopping_cart_id')) {
            $arrayId = session()->get('shopping_cart_id');
            $shoppingCart =  Product::whereIn('id', $arrayId)->get();
            foreach ($shoppingCart as $item) {

                if ($item['enable_sale']) {
                    $total_price +=  $item['sale_price'];
                } else {
                    $total_price +=  $item['price'];
                }
            }
        }
        $arrayId = session()->put('shopping_total_price', $total_price);

        $data['shoppingCart'] = $shoppingCart;
        $data['total_price'] = $total_price;
        $data['total_item'] = $total_item;
        $data['actionType'] = $request['actionType'];
        $returnHTML = view('Request::admin.component.fetch-cart', $data)->render(); // or method that you prefere to return data + RENDER is the key here
        return response()->json(array('success' => true, 'html' => $returnHTML, 'total_price' => $total_price));
    }

    public function ajaxFetchBill(Request $request)
    {
        $total_price = 0;
        $payment_price = 0;
        $vat_percent = $request['vat_percent'];
        $sale_percent = 0;
        $money_to_sale = 10000000;
        if (session()->get('shopping_total_price')) {
            $total_price = session()->get('shopping_total_price');
            if ($total_price >= $money_to_sale) {
                $sale_percent += 10;
            }
        }
        if (isset($request['payment_status'])) {
            if ($request['payment_status'] == 1)
                $sale_percent += 10;
        }
        $payment_price = ($total_price - $total_price * $sale_percent / 100) + ($total_price - $total_price * $sale_percent / 100) * ($vat_percent / 100);
        $data['total_price'] = $total_price;
        $data['payment_price'] = $payment_price;
        $data['sale_percent'] = $sale_percent;
        $data['vat_percent'] = $vat_percent;
        $returnHTML = view('Request::admin.component.fetch-bill', $data)->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function ajaxFetchAction(Request $request)
    {
        if (isset($request["action"])) {
            if ($request["action"] == "add") {
                if (!session()->get('shopping_cart_id')) {
                    session()->put('shopping_cart_id', []);
                }
                $product_id = $request["product_id"];
                foreach ($product_id as $item) {
                    if (!in_array($item, session()->get('shopping_cart_id'))) {
                        session()->push('shopping_cart_id', $item);
                    }
                }

                return response()->json(array('action' => 'add', 'type' => 'success', 'message' => 'Thêm vào giỏ hàng thành công', 'data' => $product_id));
            }

            if ($request["action"] == 'remove') {
                $idToDelete = $request["product_id"];

                $products = session()->get('shopping_cart_id');

                if (($key = array_search($idToDelete, $products)) !== false) {
                    unset($products[$key]);
                }

                session()->put('shopping_cart_id', $products);
                return response()->json(array('type' => 'success', 'message' => 'Xóa sản phẩm thành công', 'key' => $products));
            }
            if ($request["action"] == 'empty') {
                session()->forget('shopping_cart_id');
                return response()->json(array('type' => 'success', 'message' => 'Xóa tất cả sản phẩm thành công'));
            }
        }
    }

    public function ajaxModalInsertRequest()
    {
        try {
            $data['listCategory'] = mod_request_list_product_category();
            $listProduct = [];
            foreach ($data['listCategory'] as $cat) {
                $category = ProductCategory::find($cat['id']);
                $listProduct[$cat['id']] = Product::where('category_id', $cat['id'])->where('status', 1)->get();
            }
            $data['listProduct'] = $listProduct;
            return response()->json(view('Product::admin.modalInsertContent', $data)->render());
        } catch (\Throwable $th) {
            return response()->json('<div class="alert alert-danger">Đã có lỗi xảy ra. Vui lòng đóng và thử lại.</div>');
        }
    }
    public function ajaxSearchCustomer(Request $request)
    {
        try {
            $listResult = User::with('info')
                ->whereHas('info', function ($query) {
                    $query->where('phone', '=', \Request::input('client_phone'))
                        ->orWhere('phone', 'like', '%' . \Request::input('client_phone') . '%');
                })->get();
            $data['listResult'] = $listResult;
            $html = view('Request::admin.component.resultSearchCustomer', $data)->render();
            return response()->json(['status' => true, 'html' => $html], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th], 500);
        }
    }
}
