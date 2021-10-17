<?php
namespace App\Http\Controllers;

use App\Settings;
use App\Item;
use App\ItemReply;
use App\User;
use Illuminate\Support\Facades\Mail;
use MercurySeries\Flashy\Flashy;
use Request;

class ItemController extends Controller
{
/*
 * Load basic settings
 */
    public function __construct()
    {
        $sett = Settings::all();
        foreach ($sett as $setts) {
            $this->settings[$setts->name] = $setts->value;
        }
    }
/*
 * index page
 */
    public function index()
    {
        $departments = explode(',', $this->settings['department']);
        return view('welcome', compact('departments'));
    }
/*
 * View Item page.
 */
    public function support()
    {
        return view('Support.index');
    }
/*
 * Load item from item id
 */
    public function loadItem()
    {
        $request = Request::get('item');
        $item = Item::where('tid', $request)->first();
        if (!$item) {
            Flashy::error('Invalid Item ID');
            return redirect('view');
        }
        return redirect('item/' . $item->tid);
    }
/*
 * Slack notification sender.
 */
//    public function slack($message, $room = "general", $icon = ":longbox:")
//    {
//        if ($this->settings['slack'] != "") {
//            $room = ($room) ? $room : "general";
//            $data = "payload=" . json_encode(array(
//                "username" => "dev",
//                "channel" => "#{$room}",
//                "text" => $message,
//                "icon_emoji" => $icon,
//            ));
//            $ch = curl_init($this->settings['slack']);
//            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            $result = curl_exec($ch);
//            curl_close($ch);
//            return $result;
//        }
//    }
/*
 * New item store on database
 */
    public function storeItem()
    {
        $req = Request::all();
// dd($req['email']);
        //Generate Tid
        $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $segment_chars = 5;
        $num_segments = 4;
        $key_string = '';
        for ($i = 0; $i < $num_segments; $i++) {
            $segment = '';
            for ($j = 0; $j < $segment_chars; $j++) {
                $segment .= $tokens[rand(0, 35)];
            }
            $key_string .= $segment;
            if ($i < ($num_segments - 1)) {
                $key_string .= '-';
            }
        }
        $req['tid'] = $key_string;
        $req['status'] = 0;
        Item::create($req);
        Flashy::message('Your item opened');
//        $data = array(
//            'item' => $key_string,
//            'name' => $req['name'],
//        );
//        $useremail = $req['email'];
//        Mail::send('Emails.item', $data, function ($message) use ($useremail) {
//            $message->from($this->settings['from'], $_ENV['APP_NAME'] . ' Item');
//            $message->to($useremail)->subject($_ENV['APP_NAME'] . ' Item');
//        });
//        $staffs = User::where('department', 'LIKE', '%' . $req['department'] . '%')->get();
//        foreach ($staffs as $staff) {
//            $staffemail = $staff->email;
//            Mail::send('Emails.staffEmail', $data, function ($message) use ($staffemail) {
//                $message->from($this->settings['from'], $_ENV['APP_NAME'] . ' New Item');
//                $message->to($staffemail)->subject($_ENV['APP_NAME'] . ' New Item');
//            });
//        }
//        $this->slack('New Item - ' . $req['message'], 'support', ':robot_face:');
        return redirect('item/' . $key_string);
    }
/*
 * View Item user page.
 */
    public function viewItem($tid)
    {
        $item = Item::where('tid', $tid)->get()->first();
        $email = $item->email;
        $default = url('images/user.png');
        $size = 40;
//        $userAvatar = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($default) . "&s=" . $size;
        $userAvatar = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) .  "&s=" . $size . "?d=identicon&r=PG";
        $staffs = ItemReply::where('tid', $tid)->where('staff', '!=', '0')->get();
        $staffAvatar = array();
        foreach ($staffs as $staff) {
            $user = User::where('id', $staff->staff)->select('email')->first();
            $email = $user->email;
            $default = url('images/staff.png');
            $size = 40;
            $staffAvatar[$staff->staff] = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) .  "&s=" . $size . "?d=identicon&r=PG";
        }
        $reply = ItemReply::where('tid', $tid)->paginate(10);
        return view('Support.view', compact('item', 'reply', 'userAvatar', 'staffAvatar'));
    }
/*
 * Store item reply.
 */
    public function storeReply($tid)
    {
        $item = Item::where('tid', $tid)->get()->first();
        if ($item->status == 1) {
            $item->update(['status' => '0']);
        }
        $req = Request::all();
        ItemReply::create($req);
        Flashy::message('Your reply added.');

        // if email and slack notification are on
//        $data = array(
//            'item' => $tid,
//            'name' => 'BOT',
//        );
//        $staffs = User::where('department', 'LIKE', '%' . $item->department . '%')->get();
//        foreach ($staffs as $staff) {
//            $staffemail = $staff->email;
//            Mail::send('Emails.staffEmail', $data, function ($message) use ($staffemail) {
//                $message->from($this->settings['from'], $_ENV['APP_NAME'] . ' New Item Reply');
//                $message->to($staffemail)->subject($_ENV['APP_NAME'] . ' New Item Reply');
//            });
//        }
//        $this->slack('New Item Reply - ' . $req['message'], 'support', ':robot_face:');
        return redirect('item/' . $req['tid']);
    }
/*
 * Close Item
 */
    public function close($tid)
    {
        $item = Item::where('tid', $tid)->get()->first();
        $item->update(['status' => '1']);
        Flashy::message('Item Closed', '');
        return redirect('item/' . $tid);
    }

    /*
 * Open Item
 */
    public function open($tid)
    {
        $item = Item::where('tid', $tid)->get()->first();
        $item->update(['status' => '0']);
        Flashy::message('Item Opened', '');
        return redirect('item/' . $tid);
    }

}
