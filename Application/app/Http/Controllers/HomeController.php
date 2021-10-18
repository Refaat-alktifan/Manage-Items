<?php
namespace App\Http\Controllers;

use App\Settings;
use App\Item;
use App\ItemReply;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use MercurySeries\Flashy\Flashy;
use Request;

class HomeController extends Controller
{
/**
 * Load basic settings
 */
    public function __construct()
    {
        $this->middleware('auth');
        $sett = Settings::all();
        foreach ($sett as $setts) {
            $this->settings[$setts->name] = $setts->value;
        }
    }
/**
 * Verify admin is logged in
 */
    public function validateAdmin()
    {
        if (Auth::user()->is_admin != 1) {
            die('You have no permission');
        }

        $sett = Settings::all();
        foreach ($sett as $setts) {
            $this->settings[$setts->name] = $setts->value;
        }
    }
/**
 * Show the application dashboard.
 */
    public function index()
    {
        $replies = array();
        if (Auth::user()->is_admin == 1) {
            $items = Item::orderBy('status', 'DESC')->orderBy('priority', 'DESC')->where('status', '0')->paginate(10);
        } else {
            $departments = explode(',', Auth::user()->department);
            $items = Item::whereIn('department', $departments)->orderBy('status', 'DESC')->orderBy('priority', 'DESC')->where('status', '0')->paginate(10);
        }
        foreach ($items as $item) {
            $replies[] = ItemReply::where('tid', $item->tid)->orderBy('id', 'DESC')->get()->take(1);
        }
        return view('home', compact('items', 'replies'));
    }
/**
 * Search
 */
    public function search()
    {
        $request = Request::get('search');
        $item = Item::where('tid', $request)->get()->first();
        if (!$item) {
            Flashy::error("Item id not found");
            return redirect('home');
        }
        return redirect('admin/item/' . $request);

    }
/**
 * View Item from admin panel
 */
    public function viewItem($tid)
    {
        $item = Item::where('tid', $tid)->get()->first();
        $email = $item->email;
        $default = url('images/user.png');
        $size = 40;
        $userAvatar = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) .  "&s=" . $size . "?d=identicon&r=PG";
        $staffs = ItemReply::where('tid', $tid)->where('staff', '!=', '0')->get();
        $staffAvatar = array();
        foreach ($staffs as $staff) {
            $user = User::where('id', $staff->staff)->select('email')->first();
            $email = $user->email;
            $default = url('/images/staff.png');
            $size = 40;
            $staffAvatar[$staff->staff] = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) .  "&s=" . $size . "?d=identicon&r=PG";
        }
        $reply = ItemReply::where('tid', $tid)->paginate(10);
        return view('admin.viewItem', compact('item', 'reply', 'item', 'reply', 'userAvatar', 'staffAvatar'));
    }
/**
 * Store reply by staff
 */
    public function storeReply($tid)
    {
        $item = Item::where('tid', $tid)->get()->first();
        if ($item->status == 1) {
            $item->update(['status' => '0']);
        }
        $req = Request::all();
        $req['staff'] = Auth::user()->id;
        $req['name'] = Auth::user()->name;

        ItemReply::create($req);
        Flashy::message('Your reply added.');
// Mail user this info
        $data = array(
            'item' => $item->tid,
            'name' => $item->name,
        );
        $useremail = $item->email;
//        Mail::send('Emails.itemReply', $data, function ($message) use ($useremail) {
//            $message->from($this->settings['from'], $_ENV['APP_NAME'] . ' Item');
//            $message->to($useremail)->subject($_ENV['APP_NAME'] . ' Item');
//        });
        return redirect('admin/item/' . $req['tid']);
    }
/**
 * View Closed items
 */
    public function closedItems()
    {
        $replies = [];
        if (Auth::user()->is_admin == 1) {
            $items = Item::orderBy('status', 'DESC')->orderBy('priority', 'DESC')->paginate(10);
        } else {
            $departments = explode(',', Auth::user()->department);
            $items = Item::whereIn('department', $departments)->orderBy('status', 'DESC')->orderBy('priority', 'DESC')->paginate(10);
        }
        foreach ($items as $item) {
            $replies[] = ItemReply::where('tid', $item->tid)->orderBy('id', 'DESC')->get()->take(1);
        }
        return view('admin.manageItems', compact('items', 'replies'));
    }
/**
 *Manage staffs
 */
    public function users()
    {
        $this->validateAdmin();
        $users = User::paginate('10');
        return view('admin.manageUser', compact('users'));
    }
/**
 * Settings page.
 */
    public function settings()
    {
        $this->validateAdmin();
        $settings = Settings::all();
        foreach ($settings as $sett) {
            $data[$sett->name] = $sett->value;
        }
        return view('admin.settings', compact('data'));
    }
/**
 * Delete support item
 */
    public function deleteItem($tid)
    {
        Item::where('tid', $tid)->delete();
        ItemReply::where('tid', $tid)->delete();
        return redirect('manage/items');
    }
/**
 * User Profile page
 */
    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }
/**
 * User profile data update
 */
    public function updateProfile()
    {
        $input = Request::all();
        $user = Auth::user();
        $user->update($input);
        Flashy::message('Your profile updated successfully');
        return redirect('home');
    }
/**
 * User password update.
 */
    public function updateProfilePassword()
    {
        $input = Request::all();
        $user = Auth::user();
        $account['password'] = bcrypt($input['password']);
        $user->update($account);
        Flashy::message('Your password updated successfully');
        return redirect('home');
    }
/**
 * Add new staff
 */
    public function userAdd()
    {$this->validateAdmin();
        $departments = explode(',', $this->settings['department']);
        return view('admin.newUser', compact('departments'));
    }
/**
 * Add user to database
 */
    public function storeUser()
    {$this->validateAdmin();
        $request = Request::all();

        $department = implode(',', $request['department']);

        $data['name'] = $request['name'];
        $data['email'] = $request['email'];
        $data['department'] = $department;
        $data['password'] = bcrypt($request['password']);
        User::create($data);
        Flashy::message('Staff added successfully.');
        return redirect('manage/user');
    }
/**
 * Edit staff
 */
    public function editUser($id)
    {$this->validateAdmin();
        $user = User::findOrFail($id);
        $departments = explode(',', $this->settings['department']);
        $selected = explode(',', $user->department);
        return view('admin.editUser', compact('user', 'departments', 'selected'));
    }
/**
 * Update staff details
 */
    public function updateUser($id)
    {$this->validateAdmin();
        $user = User::findOrFail($id);
        $request = Request::all();
        $department = implode(',', $request['department']);

        $data['name'] = $request['name'];
        $data['email'] = $request['email'];
        $data['department'] = $department;
        $user->update($data);
        Flashy::message('Staff updated successfully.');
        return redirect('manage/user');
    }
/**
 * Update settings
 */
    public function updateSettings()
    {$this->validateAdmin();
        $requests = Request::all();
        foreach ($requests as $req => $k) {
            if ($req != "_token") {
                if ($k) {
                    $settings = Settings::where('name', $req)->first();
                    $settings->update(['value' => $k]);
                }
            }
        }
        Flashy::message('Settings updated');
        return redirect('manage/settings');
    }
}
