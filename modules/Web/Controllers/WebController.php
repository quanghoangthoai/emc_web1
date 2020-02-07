<?php

namespace Modules\Web\Controllers;

use Modules\Library\Models\Category as CategoryLibrary;
use Modules\Library\Models\Document;
use Modules\Page\Models\Page;
use Modules\Post\Models\Category as CategoryPost;
use Modules\Service\Models\Service;
use System\Core\Controllers\WebController as Controller;

class WebController extends Controller
{
    public function executeSlug($slug)
    {
        $arrSlug = explode('/', trim($slug));
        $numSlug = count($arrSlug);
        if ($numSlug == 1) {
            /**
             * Check: PAGES
             */
            if (module_check_active('Page')) {
                $page = Page::where(['slug' => trim($slug), 'status' => 1])->first();
                if ($page) {
                    return call_user_func_array(['Modules\Page\Controllers\WebController', 'getDetailPage'], ['page' => $page]);
                }
            }

            /**
             * Check: SERVICE
             */
            if (module_check_active('Service')) {
                /**
                 * Check: Detail Service
                 */
                $service = Service::where(['slug' => trim($slug), 'status' => 1])->first();
                if ($service) {
                    return call_user_func_array(['Modules\Service\Controllers\WebController', 'detailService'], ['service' => $service]);
                }
            }

            /**
             * Check: POST
             */
            if (module_check_active('Post')) {
                /**
                 * Check: POST_CATEGORIES
                 */
                $post_cat = CategoryPost::where(['slug' => trim($slug), 'status' => 1])->first();
                if ($post_cat) {
                    return call_user_func_array(['Modules\Post\Controllers\WebController', 'viewCategory'], ['category' => $post_cat]);
                }
            }

            /**
             * Check: Library
             */
            if (module_check_active('Library')) {
                /**
                 * Check: Library_CATEGORIES
                 */
                $library_cat = CategoryLibrary::where(['slug' => trim($slug), 'status' => 1])->first();
                if ($library_cat) {
                    return call_user_func_array(['Modules\Library\Controllers\WebController', 'viewCategory'], ['category' => $library_cat]);
                }
            }
        }

        if ($numSlug == 2) {
            /**
             * Check: Library
             */
            if (module_check_active('Library')) {
                /**
                 * Check: Library_document
                 */
                $document = Document::where(['slug' => trim($arrSlug[1]), 'status' => 1])->first();
                if ($document && $document->category['slug'] == trim($arrSlug[0])) {
                    return call_user_func_array(['Modules\Library\Controllers\WebController', 'detailDocument'], ['document' => $document]);
                }
            }
        }

        return abort(404);
    }
}