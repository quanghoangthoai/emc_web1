<?php

namespace System\Core\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function __construct()
    {
        // Run on system boot
        check_system_roles();
        check_install_mod_user();

        /**
         * remove public in url
         */
        $root_domain = request()->root();
        $arrDomain = explode('/', $root_domain);
        if (end($arrDomain) == 'public') {
            unset($arrDomain[count($arrDomain) - 1]);
            $newRoot = implode('/', $arrDomain);
            if (request()->path() == '/') {
                return redirect()->to($newRoot)->send();
            } else {
                return redirect()->to($newRoot . '/' . request()->path())->send();
            }
        }
    }

    public function postGetSlug()
    {
        return response()->json(str_slug(request()->plainText));
    }
}