<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\ProductRunningOut;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;


class BackendScheduleController extends Controller
{
    public function clean_dashboard_logs()
    {
        \DB::select('DELETE FROM rate_limits where DATE(created_at) < "' . \Carbon::parse(now())->subDays(8)->format('Y-m-d H:i:s') . '"');
        \DB::select('DELETE FROM rate_limit_details where DATE(created_at) < "' . \Carbon::parse(now())->subDays(8)->format('Y-m-d H:i:s') . '"');
    }
    public function update_under_attack_limits()
    {
        $under_attacks = \App\Models\UnderAttack::where('status', 'UNDER_ATTACK')->where('created_at', '<', \Carbon::parse(now())->addMinutes(15)->format('Y-m-d H:i:s'))->count();
        if ($under_attacks) {
            (new \App\Helpers\SecurityHelper)->disable_under_attack_mode();
            \App\Models\UnderAttack::where('status', 'UNDER_ATTACK')->update(['status' => "MEDIUM"]);
        }
        $blocked_ips = \App\Models\BlockIp::whereDate('created_at', '<', \Carbon::parse(now())->subMinutes(30)->format('Y-m-d H:i:s'))->get();
        foreach ($blocked_ips as $blocked_ip) {
            $response =  (new \App\Helpers\SecurityHelper)->unblock_ip($blocked_ip->state_id);
        }
    }
    public function productCheckQuantity()
    {
        $products = Product::all();
        foreach ($products as $product) {
            if ($product->quantity <= 50) {
                $product->update(['status' => 'draft']);
                Mail::to('lalameatlala123@gmail.com')->send(new ProductRunningOut($product));
            }
        }
    }
}
