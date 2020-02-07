<?php

namespace Modules\Recruitment\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use File;
use Modules\Recruitment\Models\EmailTemplate;
use Modules\Recruitment\Models\Progress;
use Modules\Recruitment\Models\Recruitment;
use System\Core\Controllers\AdminController as SystemAdminController;
use Illuminate\Support\Facades\Mail;
use Modules\Recruitment\Models\Job;

class AdminController extends SystemAdminController
{
    public function getListRecruitment(Request $request)
    {
        $param = $request->all();
        $filterdata = Recruitment::filter($param);
        $data['listRec'] = $filterdata->orderBy('id', 'desc')->paginate(10);
        $data['listJob'] = Job::orderBy('order', 'asc')->get();
        if (isset($param['created_at'])) {
            $arr_time = explode(" - ", $param['created_at']);
            $param['begindate'] = $arr_time[0];
            $param['enddate'] = $arr_time[1];
        }
        $data['filterdata'] = $param;
        return view('Recruitment::admin.recruitment.list', $data);
    }

    public function getTestRecruitment($id)
    {
        $data['iJob'] = Job::find($id);
        return view('Recruitment::admin.recruitment.test', $data);
    }
    public function postTestRecruitment(Request $request)
    {

        $request->validate([
            'attach_file' => 'required|max:10000|mimes:pdf,doc,docx',

        ], [

            'attach_file.required' => 'Chưa thêm tệp hồ sơ',
            'attach_file.max' => 'File không quá 10mb',
            'attach_file.mimes' => 'Yêu cầu file doc, pdf, docx'
        ]);


        $pathFile = '';
        if ($request->hasFile('attach_file')) {
            $files = $request->file('attach_file');
            $destinationPath = 'public/recruitment/attach_file/'; // upload path
            $pathFile = date('YmdHis') . '-' . $files->getClientOriginalName();
            $filelink = 'public/recruitment/attach_file/' . $pathFile;
            $files->move($destinationPath, $pathFile);
        }

        Recruitment::create([
            'user_id' =>  auth('admin')->id(),
            'job_id' => $request->job_id,
            'status' => 0,
            'position' => $request->position,
            'attach_file' => $filelink,
        ]);
        return redirect()->route('mod_recruitment.admin.list_recruitment')->with('flash_data', ['type' => 'success', 'message' => 'thêm hồ sơ thành công']);
    }

    public function getDetailRecruitment($id)
    {

        $iRec = Recruitment::find($id);
        $Progs = mod_recruitment_list_progress_by_recruitment_id($id);
        $data['iRec'] = $iRec;
        $data['Progs'] = $Progs;
        return view('Recruitment::admin.recruitment.detail', $data);
    }

    public function postSendMail($id, Request $request)
    {
        $request->validate([
            'status' => 'required',
            'content' => 'required'
        ], [
            'status.required' => 'Chưa chọn trạng thái',
            'content.required' => 'Chưa nhập nội dung phản hồi'
        ]);

        $iRec = Recruitment::find($id);
        $iProgress = [
            'user_id' => auth('admin')->id(),
            'recruitment_id' => $iRec['id'],
            'content' => strip_tags(html_entity_decode($request->content)),
            'status' => $request->status
        ];

        $iRec->update([
            'status' => $request->status
        ]);
        $contact = [
            'sender_name' => $iRec->personal->info->fullname,
            'sender_email' => $iRec->personal->email,
            'reply_content' => $request->content,
        ];

        Mail::send('Recruitment::admin.email_template.mailfb', array('name' => $contact["sender_name"], 'email' => $contact["sender_email"], 'reply_content' => $contact["reply_content"]), function ($message) use ($contact) {
            $message->to($contact["sender_email"])->subject('Thông báo từ EMC');
        });

        self::postAddProgress($iProgress);

        return redirect()->route('mod_recruitment.admin.detail_recruitment', $id)->with('flash_data', ['type' => 'success', 'message' => 'Cập nhật tiến trình tuyển dụng thành công']);
    }

    public function postAddProgress($data)
    {
        Progress::create($data);
        return true;
    }

    public function getDownload($id)
    {

        if (auth('admin')->check()) {
            $iRec = Recruitment::find($id);

            if ($iRec) {
                if ($iRec['attach_file']) {
                    return response()->streamDownload(function () use ($iRec) {
                        echo file_get_contents(public_path($iRec['attach_file']));
                    }, File::name(public_path($iRec['attach_file'])) . '.' . File::extension(public_path($iRec['attach_file'])));
                } else return "Error";
            }
            return "Error";
        }
        return "Error";
    }

    public function getDeleteRecruitment($id)
    {
        $iRec = Recruitment::find($id);
        if ($iRec) {
            if ($iRec->progresses) {
                foreach ($iRec->progresses as $iProg) {
                    $iProg->delete();
                }
            }
            $iRec->delete();
        }

        return redirect()->route('mod_recruitment.admin.list_recruitment')->with('flash_data', ['type' => 'success', 'message' => 'Xóa ứng tuyển viên thành công']);
    }
    public function getListEmailTemplate()
    {
        $data['listMail'] = EmailTemplate::orderBy('id', 'desc')->get();
        return view('Recruitment::admin.email_template.list', $data);
    }
    public function postAddEmailTemplate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'content' => 'required'
        ], [
            'name.required' => 'Chưa nhập tên mẫu',
            'content.required' => 'Chưa nhập nội dung phản hồi'
        ]);

        EmailTemplate::create([
            'created_by' =>  auth('admin')->id(),
            'name' => $request->name,
            'content' => $request->content
        ]);
        return redirect()->route('mod_recruitment.admin.list_email_template')->with('flash_data', ['type' => 'success', 'message' => 'Thêm mẫu phản hồi thành công']);
    }

    public function getEditEmailTemplate($id)
    {
        $data['editemail'] = EmailTemplate::find($id);
        $data['listMail'] = EmailTemplate::orderBy('id', 'desc')->get();
        return view('Recruitment::admin.email_template.edit', $data);
    }
    public function postEditEmailTemplate($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'content' => 'required'
        ], [
            'name.required' => 'Chưa nhập tên gọi mẫu',
            'content.required' => 'Chưa nhập nội dung phản hồi'
        ]);

        EmailTemplate::where('id', $id)->update([
            'name' => $request->name,
            'content' => $request->content,
            'modified_by' => auth('admin')->id()
        ]);

        return redirect()->route('mod_recruitment.admin.list_email_template')->with('flash_data', ['type' => 'success', 'message' => 'Sửa mẫu phản hồi thành công']);
    }

    public function getDeleteEmailTemplate($id)
    {
        EmailTemplate::where('id', $id)->delete();
        return redirect()->route('mod_recruitment.admin.list_email_template')->with('flash_data', ['type' => 'success', 'message' => 'Xóa mẫu phản hồi thành công']);
    }

    public function ajaxShowMailTemplate(Request $request)
    {
        $iMail = EmailTemplate::find($request->id);
        return response()->json(['flash_data' => ['type' => 'success', 'message' => 'Thay đổi mẫu phản hồi thành công'], 'data' => $iMail['content']], 200);;
    }

    /**
     * Controller for Recruitment Job
     */

    /**
     * Get list page
     */
    public function getListJob(Request $request)
    {
        $param = $request->all();
        $filterdata = Job::filter($param);
        $data['listJob'] = $filterdata->orderBy('order', 'asc')->paginate(10)->appends($request->except('page'));
        $data['minOrder'] = Job::min('order');
        $data['maxOrder'] = Job::max('order');
        if (isset($param['created_at'])) {
            $arr_time = explode(" - ", $param['created_at']);
            $param['begindate'] = $arr_time[0];
            $param['enddate'] = $arr_time[1];
        }
        $data['filterdata'] = $param;
        return view('Recruitment::admin.job.list', $data);
    }

    public function getAddJob()
    {
        return view('Recruitment::admin.job.add');
    }

    public function postAddJob(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:recruitment_jobs,slug',
            'position' => 'required',
            'work_address' => 'required',
            'work_type' => 'required',
            'people_number' => 'required',
            'salary' => 'required',
            'contact_info' => 'required',
            'content' => 'required'
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'slug.required' => 'Chưa nhập liên kết tĩnh',
            'slug.unique' => 'Liên kết tĩnh bị trùng',
            'content.required' => 'Chưa nhập nội dung chi tiết',
            'position.required' => 'Chưa nhập vị trí tuyển dụng',
            'work_address.required' => 'Chưa nhập địa chỉ tuyển dụng',
            'work_type.required' => 'Chưa nhập loại hình công việc',
            'salary.required' => 'Chưa nhập mức lương',
            'contact_info.required' => 'Chưa nhập thông tin người liên hệ',
            'people_number.required' => 'Chưa nhập số người cần tuyển'
        ]);

        $maxOrder = Job::max('order');

        Job::create([
            'title' => $request->title,
            'slug' => empty($request->slug) ? str_slug($request->title) : $request->slug,
            'image' => $request->image,
            'description' => $request->description,
            'content' => $request->content,
            'status' => $request->status,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'seo_image' => $request->seo_image,
            'seo_keywords' => $request->seo_keywords,
            'order' => $maxOrder ? $maxOrder + 1 : 1,
            'position' => $request->position,
            'work_address' => $request->work_address,
            'work_type' => $request->work_type,
            'people_number' => $request->people_number,
            'salary' => $request->salary,
            'link' => $request->link,
            'expired_at' => Carbon::createFromFormat('d/m/Y H:i', $request->expired_at . ' 23:59')->format('Y-m-d H:i:s'),
            'contact_info' => $request->contact_info
        ]);

        return redirect()->route('mod_recruitment.admin.list_job')->with('flash_data', ['type' => 'success', 'message' => 'Thêm tin tuyển dụng thành công']);
    }

    public function getEditJob($id)
    {
        $data['editjob'] = Job::find($id);
        return view('Recruitment::admin.job.edit', $data);
    }

    public function postEditJob($id, Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:recruitment_jobs,slug,' . $id,
            'position' => 'required',
            'work_address' => 'required',
            'work_type' => 'required',
            'people_number' => 'required',
            'salary' => 'required',
            'contact_info' => 'required',
            'content' => 'required'
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'slug.required' => 'Chưa nhập liên kết tĩnh',
            'slug.unique' => 'Liên kết tĩnh bị trùng',
            'content.required' => 'Chưa nhập nội dung chi tiết',
            'position.required' => 'Chưa nhập vị trí tuyển dụng',
            'work_address.required' => 'Chưa nhập địa chỉ tuyển dụng',
            'work_type.required' => 'Chưa nhập loại hình công việc',
            'salary.required' => 'Chưa nhập mức lương',
            'contact_info.required' => 'Chưa nhập thông tin người liên hệ',
            'people_number.required' => 'Chưa nhập số người cần tuyển'
        ]);

        Job::where('id', $id)->update([
            'title' => $request->title,
            'slug' => empty($request->slug) ? str_slug($request->title) : $request->slug,
            'image' => $request->image,
            'description' => $request->description,
            'content' => $request->content,
            'status' => $request->status,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'seo_image' => $request->seo_image,
            'seo_keywords' => $request->seo_keywords,
            'position' => $request->position,
            'work_address' => $request->work_address,
            'work_type' => $request->work_type,
            'people_number' => $request->people_number,
            'salary' => $request->salary,
            'link' => $request->link,
            'expired_at' => Carbon::createFromFormat('d/m/Y H:i', $request->expired_at . ' 23:59')->format('Y-m-d H:i:s'),
            'contact_info' => $request->contact_info
        ]);

        return redirect()->route('mod_recruitment.admin.list_job')->with('flash_data', ['type' => 'success', 'message' => 'Sửa tin tuyển dụng thành công']);
    }

    public function getDeleteJob($id)
    {
        Job::where('id', $id)->delete();
        mod_recruitment_fix_job_order();
        return redirect()->route('mod_recruitment.admin.list_job')->with('flash_data', ['type' => 'success', 'message' => 'Xóa tin tuyển dụng thành công']);
    }

    /**
     * Ajax Change page
     */
    public function ajaxChangJob(Request $request)
    {
        $id = $request->id;
        $order = $request->order;
        $listJob = Job::where([['id', '!=', $id]])->orderBy('order', 'asc')->get();
        $weight = 0;
        foreach ($listJob as $job) {
            ++$weight;
            if ($weight == $order) {
                ++$weight;
            }
            Job::where('id', $job['id'])->update(['order' => $weight]);
        }
        Job::where('id', $id)->update(['order' => $order]);
        mod_recruitment_fix_job_order();
        $request->session()->flash('flash_data', ['type' => 'success', 'message' => 'Cập nhật thành công']);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công'
        ]);
    }

    public function ajaxChangeStatus(Request $request)
    {
        try {
            Job::find($request->id)->update([
                'status' => $request->status,
            ]);
            return response()->json(['status' => true, 'msg' => 'Đã cập nhật trạng thái']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Đã có lỗi xảy ra']);
        }
    }
}