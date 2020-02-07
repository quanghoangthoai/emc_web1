<?php

namespace Modules\Client\Controllers;

use Modules\User\Models\UserSocial;
use System\Core\Controllers\WebController as Controller;

class ClientController extends Controller
{
    public function getUnlinkSocial($provider)
    {
        UserSocial::where('user_id', auth('web')->id())->where('provider', $provider)->delete();
        return redirect()->route('client.my_account');
    }

    public function getMyProduct()
    {
        return view('Client::pages.my_products');
    }
    public function getProduct()
    {
        return view('Client::pages.products');
    }
    public function getRequests()
    {
        return view('Client::pages.request');
    }
    public function getOrders()
    {
        return view('Client::pages.orders');
    }
    public function getDetailOrder()
    {
        return view('Client::pages.detail_order');
    }
    public function getTickets()
    {
        return view('Client::pages.tickets');
    }
    public function getDetailTicket()
    {
        return view('Client::pages.detail_ticket');
    }
    public function getAddTicket()
    {
        return view('Client::pages.add_ticket');
    }
    public function getHistoryDownload()
    {
        return view('Client::pages.history_dowload');
    }
    public function getDetailHistoryDownload()
    {
        return view('Client::pages.detail_history_dowload');
    }
    public function getChangePassword()
    {
        return view('Client::pages.change_password');
    }
    public function getRecruitments()
    {
        return view('Client::pages.recruitments');
    }
    public function getMyAccount()
    {
        return view('Client::pages.my_acounts');
    }
}