<?php

namespace Modules\Library\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Modules\Library\Models\Category;
use Modules\Library\Models\Document;
use Modules\Library\Models\History;
use System\Core\Controllers\AdminController as SystemAdminController;

class AdminController extends SystemAdminController
{
    /**
     * Category function
     */
    public function getListCategory(Request $request)
    {
        $data['listCat'] = mod_library_list_category();
        return view('Library::admin.category.list', $data);
    }
    public function postAddCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:library_categories,slug',
            'format_type' => 'required'
        ], [
            'name.required' => 'Chưa nhập tên danh mục',
            'name.max' => 'Tiêu đề dài quá 255 kí tự',
            'slug.required' => 'Chưa nhập liên kết tĩnh',
            'slug.unique' => 'Liên kết tĩnh bị trùng',
            'format_type.required' => 'Chưa chọn định dạng'
        ]);
        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'image' => $request->image,
            'format_type' => $request->format_type,
            'description' => $request->description,
            'status' => $request->status,
            'slug' => $request->slug
        ]);
        return redirect()->route('mod_library.admin.get_list_category')->with('flash_data', ['type' => 'success', 'message' => 'Thêm danh mục thành công']);
    }
    public function getEditCategory($id, Request $request)
    {
        $data['cat'] = Category::find($id);
        if ($data['cat']) {
            $data['listCat'] = mod_library_list_category();
            return view('Library::admin.category.edit', $data);
        }
        return redirect()->route('mod_library.admin.get_list_category')->with('flash_data', ['type' => 'error', 'message' => 'Không tìm thấy danh mục.']);
    }

    public function postEditCategory($id, Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:library_categories,slug,' . $id,
            'format_type' => 'required'
        ], [
            'name.required' => 'Chưa nhập tên danh mục',
            'name.max' => 'Tiêu đề dài quá 255 kí tự',
            'slug.required' => 'Chưa nhập liên kết tĩnh',
            'slug.unique' => 'Liên kết tĩnh bị trùng',
            'format_type.required' => 'Chưa chọn định dạng'
        ]);
        $cat = Category::find($id);
        $cat->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'format_type' => $request->format_type,
            'image' => $request->image,
            'description' => $request->description,
            'status' => $request->status,
            'slug' => $request->slug
        ]);
        return redirect()->route('mod_library.admin.get_edit_category', $id)->with('flash_data', ['type' => 'success', 'message' => 'Sửa danh mục thành công']);
    }

    public function getDeleteCategory($id)
    {
        mod_library_delete_category($id);

        return redirect()->route('mod_library.admin.get_list_category')->with('flash_data', ['type' => 'success', 'message' => 'Xóa danh mục thành công']);
    }

    /**
     * Document function
     */
    public function getListDocument(Request $request)
    {
        $param = $request->all();

        $filterdata = Document::filter($param);
        $data['listDoc'] = $filterdata->get();
        return view('Library::admin.document.list', $data);
    }
    public function getAddDocument()
    {
        if (Category::count() == 0)
            return redirect()->route('mod_library.admin.get_list_category')->with('flash_data', ['type' => 'warning', 'message' => 'Vui lòng thêm danh mục trước']);

        $listCat = mod_library_list_category();
        $data['listCat'] = $listCat;
        return view('Library::admin.document.add', $data); 
    }
    public function postAddDocument(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'document_type' => 'required',
            'category_id' => 'required|exists:library_categories,id',
            'slug' => 'required|unique:library_documents,slug',
            'text_code' => 'required_if:status,==,1',
            'text_type' => 'required_if:status,==,1'
        ], [
            'name.required' => 'Chưa nhập tên tài liệu',
            'name.max' => 'Tiêu đề dài quá 255 kí tự',
            'document_type.required' => 'Chưa chọn loại tài liệu',
            'category_id.required' => 'Chưa chọn danh mục',
            'category_id.exists' => 'Danh mục không còn tồn tại, vui lòng chọn danh mục khác',

            'slug.required' => 'Chưa nhập liên kết tĩnh',
            'slug.unique' => 'Liên kết tĩnh bị trùng',
            'text_code.required_if' => 'Chưa nhập số hiệu văn bản',
            'text_type.required_if' => 'Chưa chọn loại văn bản',
        ]);

        Document::create([
            'name' => $request['name'],
            'document_type' => $request['document_type'],
            'category_id' => $request['category_id'],
            'short_description' => $request['short_description'],
            'content' => $request['content'],
            'image' => $request['image'],
            'attach_file' => $request['attach_file'],
            'status' => $request['status'],
            'slug' => $request['slug'],
            'text_code' => $request['document_type'] == '1' ? $request['text_code'] : null,
            'text_type' => $request['document_type'] == '1' ? $request['text_type'] : null,
            'issued_date' => $request['document_type'] == '1' ? $request['issued_date_submit'] : null,
            'started_date' => $request['document_type'] == '1' ? $request['started_date_submit'] : null,
            'expired_date' => $request['document_type'] == '1' ? $request['expired_date_submit'] : null,
            'issued_location' => $request['document_type'] == '1' ? $request['issued_location'] : null,
            // 'text_status' => $request['document_type'] == '1' ? $request['text_status'] : null,
            'video_url' => $request['document_type'] == '5' ? $request['video_url'] : null
        ]);

        return redirect()->route('mod_library.admin.get_list_document')->with('flash_data', ['type' => 'success', 'message' => 'Thêm tài liệu thành công']);
    }
    public function getEditDocument($id)
    {
        $listCat = mod_library_list_category();
        $data['listCat'] = $listCat;
        $data['doc'] = Document::find($id);
        return view('Library::admin.document.edit', $data);
    }
    public function postEditDocument($id, Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'document_type' => 'required',
            'category_id' => 'required|exists:library_categories,id',
            'slug' => 'required|unique:library_documents,slug,' . $id,
            'text_code' => 'required_if:status,==,1',
            'text_type' => 'required_if:status,==,1'
        ], [
            'name.required' => 'Chưa nhập tên tài liệu',
            'name.max' => 'Tiêu đề dài quá 255 kí tự',
            'document_type.required' => 'Chưa chọn loại tài liệu',
            'category_id.required' => 'Chưa chọn danh mục',
            'category_id.exists' => 'Danh mục không còn tồn tại, vui lòng chọn danh mục khác',

            'slug.required' => 'Chưa nhập liên kết tĩnh',
            'slug.unique' => 'Liên kết tĩnh bị trùng',
            'text_code.required_if' => 'Chưa nhập số hiệu văn bản',
            'text_type.required_if' => 'Chưa chọn loại văn bản',
        ]);
        Document::find($id)->update([
            'name' => $request['name'],
            'document_type' => $request['document_type'],
            'category_id' => $request['category_id'],
            'short_description' => $request['short_description'],
            'content' => $request['content'],
            'image' => $request['image'],
            'attach_file' => $request['attach_file'],
            'status' => $request['status'],
            'slug' => $request['slug'],
            'text_code' => $request['document_type'] == '1' ? $request['text_code'] : '',
            'text_type' => $request['document_type'] == '1' ? $request['text_type'] : null,
            'issued_date' => $request['document_type'] == '1' ? $request['issued_date_submit'] : null,
            'started_date' => $request['document_type'] == '1' ? $request['started_date_submit'] : null,
            'expired_date' => $request['document_type'] == '1' ? $request['expired_date_submit'] : null,
            'issued_location' => $request['document_type'] == '1' ? $request['issued_location'] : '',
            // 'text_status' => $request['document_type'] == '1' ? $request['text_status'] : null,
            'video_url' => $request['document_type'] == '5' ? $request['video_url'] : ''
        ]);
        return redirect()->route('mod_library.admin.get_list_document')->with('flash_data', ['type' => 'success', 'message' => 'Sửa tài liệu thành công']);
    }
    public function getDetailDocument($id)
    {
        $listCat = mod_library_list_category();
        $data['listCat'] = $listCat;
        $data['doc'] = Document::find($id);
        $data['doc']->increment('view_count');
        return view('Library::admin.document.detail', $data);
    }
    public function getDeleteDocument($id)
    {

        mod_library_delete_document($id);
        return redirect()->route('mod_library.admin.get_list_document')->with('flash_data', ['type' => 'success', 'message' => 'Xóa tài liệu thành công']);
    }

    public function getDownload($id)
    {

        if (auth('admin')->check()) {
            $doc = Document::find($id);

            if ($doc) {
                $doc->increment('download_count');
                $new_history = History::create([
                    'user_id' =>  auth('admin')->id(),
                    'document_id' => $doc['id'],
                    'category_id' => $doc['category_id'],
                    'download_time' => Carbon::now()
                ]);
                if ($new_history) {
                    return response()->streamDownload(function () use ($doc) {
                        echo file_get_contents(public_path($doc['attach_file']));
                    }, File::name(public_path($doc['attach_file'])) . '.' . File::extension(public_path($doc['attach_file'])));
                } else return "Error";
            }
            return "Error";
        }
        return "Error";
    }

    public function getListHistory(Request $request)
    {
        $param = $request->all();
        $filterdata = History::filter($param);
        $data['listHis'] = $filterdata->get();;


        return view('Library::admin.history.list', $data);
    }

    public function getDeleteHistory($id)
    {
        History::find($id)->delete();
        return redirect()->route('mod_library.admin.get_list_history')->with('flash_data', ['type' => 'success', 'message' => 'Xóa lịch sử thành công']);
    }

    public function getDeleteAllHistory()
    {
        History::WhereNotNull('id')->delete();
        return redirect()->route('mod_library.admin.get_list_history')->with('flash_data', ['type' => 'success', 'message' => 'Xóa lịch sử thành công']);
    }

    public function ajaxFetchExtend(Request $request)
    {
        $typeDoc = $request['docType'];
        if ($typeDoc == '1')
            $returnHTML = view('Library::admin.document.component.fetch-text')->render();
        elseif ($typeDoc == '5')
            $returnHTML = view('Library::admin.document.component.fetch-video')->render();
        else
            $returnHTML = '';
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
}
