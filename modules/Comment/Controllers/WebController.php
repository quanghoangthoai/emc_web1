<?php

namespace Modules\Comment\Controllers;

use System\Core\Controllers\WebController as SystemWebController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Modules\Comment\Models\CommentModule;
use Modules\Comment\Models\Comment;

class WebController extends SystemWebController
{
    // load and add comment
    public function getLoadComment($id, $module, $link)
    {
        $data['link'] = $link;
        $data['module_id'] = mod_comment_get_module_id($module);
        $data['check_comment'] = mod_comment_get_check_comment($module);
        $data['comments'] = mod_comment_get_content_comment($id, $data['module_id']);
        $data['module'] = $module;
        $data['post_id'] = $id;
        return view('Comment::admin.comment.loadcomment', $data);
    }

    public function postComment(Request $request)
    {
        try {
            $check_module = false;
            $listModule_active = CommentModule::where('status', 1)->get();
            $request->validate(
                [
                    'body' => 'required',
                ]
            );

            $input = $request->all();
            foreach ($listModule_active as $iMod) {
                if ($input['module_id'] == $iMod['id']) {
                    $check_module = true;
                }
            }
            if ($input['module_id'] != '' && $check_module == true) {
                $input['user_id'] = auth('web')->id();
                $input['commentable_id'] = $request->post_id;
                $input['commentable_type'] = mod_comment_get_module_class($request->module_id);
                $input['link'] = $request->post_link;
                Comment::create($input);
                return response()->json(['status' => true]);
            }
            return response()->json(['status' => false]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false]);
        }
    }

    public function postCommentParent(Request $request)
    {
        try {
            $check_module = false;
            $listModule_active = CommentModule::where('status', 1)->get();
            $id = $request->id;
            $comment = Comment::where('id', $id)->first();
            foreach ($listModule_active as $iMod) {
                if ($comment['module_id'] == $iMod['id']) {
                    $check_module = true;
                }
            }
            if ($request->body_parent != null && $check_module == true) {
                if (auth('web')->id() !== null) {
                    Comment::insert([
                        'user_id' => $comment['user_id'],
                        'post_id' => $comment['post_id'],
                        'module_id' => $comment['module_id'],
                        'commentable_id' => $comment['commentable_id'],
                        'commentable_type' => $comment['commentable_type'],
                        'link' => $comment['link'],
                        'parent_id' => $id,
                        'user_parent_id' => auth('web')->id(),
                        'body' => $request->body_parent,
                        'created_at' => Carbon::now()
                    ]);
                    return response()->json(['status' => true]);
                }
                return response()->json(['status' => false]);
            }
            return response()->json(['status' => false]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false]);
        }
    }

    // check login

    public function postLogin(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Chưa nhập email',
            'password.required' => 'Chưa nhập mật khẩu'
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin']);
        }

        $is_remember = $request->has('is_remember') ? true : false;

        if (auth('web')->attempt(['email' => $request->username, 'password' => $request->password], $is_remember)) {
            if (auth('web')->user()->status == 0) {
                auth('web')->logout();
                session()->flush();
                return response()->json(['status' => false, 'message' => 'Tài khoản của bạn đang bị khóa']);
            } else {
                return response()->json(['status' => true, 'message' => 'Đăng nhập thành công']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Thông tin đăng nhập không chính xác']);
        }
    }
}
