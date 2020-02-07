<?php

namespace System\Admin\Controllers;

use System\Core\Controllers\AdminController;

class FileController extends AdminController
{
    public function getMain()
    {
        return view('Admin::file.main');
    }
}