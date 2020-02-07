<?php

namespace System\Admin\Controllers;

use System\Core\Controllers\AdminController;
use File, DateTime, DateTimeZone;
use System\Admin\Jobs\CreateBackup;

class BackupController extends AdminController
{
    public function getListBackup()
    {
        $listZipFiles = cms_scan_folder(storage_path('app' . DIRECTORY_SEPARATOR . 'backups'), ['.DS_Store']);
        $listBackup = [];
        if ($listZipFiles) {
            foreach ($listZipFiles as $iBackup) {
                $created_at = DateTime::createFromFormat("U", File::lastModified(storage_path('app' . DIRECTORY_SEPARATOR . 'backups' . DIRECTORY_SEPARATOR . $iBackup)))
                    ->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'))
                    ->format('Y-m-d H:i:s');

                $listBackup[] = [
                    'filename' => $iBackup,
                    'created_at' => $created_at
                ];
            }
        }
        $data['listBackup'] = array_reverse($listBackup);
        return view('Admin::backup.list', $data);
    }

    public function getRunBackup()
    {
        dispatch(new CreateBackup());
        // log
        activity('backup')
            // ->causedBy()
            ->log('run backup');

        return redirect()->route('cms.admin.list_backup')
            ->with('flash_data', [
                'type' => 'success',
                'message' => 'Đã lên lịch tạo bản sao lưu mới'
            ]);
    }

    public function getDownloadBackup($filename)
    {
        return response()
            ->download(storage_path('app' . DIRECTORY_SEPARATOR . 'backups' . DIRECTORY_SEPARATOR . $filename));
    }

    public function getDeleteBackup($filename)
    {
        if (File::exists(storage_path('app' . DIRECTORY_SEPARATOR . 'backups' . DIRECTORY_SEPARATOR . $filename))) {
            File::delete(storage_path('app' . DIRECTORY_SEPARATOR . 'backups' . DIRECTORY_SEPARATOR . $filename));
        }

        // log
        activity('backup')
            // ->causedBy()
            ->log('delete backup');

        return redirect()->route('cms.admin.list_backup')
            ->with('flash_data', [
                'type' => 'success',
                'message' => 'Đã xóa bản sao lưu'
            ]);
    }
}