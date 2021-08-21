<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\User;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    // View admin dashboard
    public function index()
    {
        // Get settings data
        $settings = DB::table('settings')->find(1);
        // Count earnings
        $earnings = Transaction::where('payment_status', 2)->where('currency', $settings->website_currency)->sum('amount');
        $today_earnings = Transaction::where('payment_status', 2)->where('currency', $settings->website_currency)->whereDay('created_at', Carbon::today())->sum('amount');
        // Count transfers
        $transfers = Transfer::all()->count();
        $today_transfers = Transfer::whereDay('created_at', Carbon::today())->count();
        // Count users
        $users = User::where('permission', 2)->count();
        $today_users = User::where('permission', 2)->whereDay('created_at', Carbon::today())->count();
        // Count transactions
        $transactions = Transaction::all()->count();
        $today_transactions = Transaction::whereDay('created_at', Carbon::today())->count();
        // Get last registerd users
        $lastUsers = User::where('permission', 2)->limit(4)->orderbyDesc('id')->get();
        return view('backend.dashboard', [
            'settings' => $settings,
            'earnings' => $earnings,
            'today_earnings' => $today_earnings,
            'transfers' => $transfers,
            'today_transfers' => $today_transfers,
            'users' => $users,
            'today_users' => $today_users,
            'transactions' => $transactions,
            'today_transactions' => $today_transactions,
            'lastUsers' => $lastUsers,
        ]);
    }

    // Get all transfer days
    public function getAllDays()
    {
        $day_array = array();
        $transfers_dates = Transfer::orderBy('created_at', 'ASC')->whereMonth('created_at', Carbon::now()->month)->pluck('created_at');
        $transfers_dates = json_decode($transfers_dates);
        if (!empty($transfers_dates)) {
            foreach ($transfers_dates as $unformatted_date) {
                $date = new \DateTime($unformatted_date);
                $day_no = $date->format('Y-m-d');
                $day_name = $date->format('Y-m-d');
                $day_array[$day_no] = $day_name;
            }
        }
        return $day_array;
    }

    // Count daily transfers
    public function getDailyTransfersCount($day)
    {
        $daily_transfer_count = transfer::whereDate('created_at', $day)->get()->count();
        return $daily_transfer_count;
    }

    // Get transfers data
    public function getDailyTransfersData()
    {
        $daily_transfer_count_array = array();
        $day_array = $this->getAllDays();
        $day_name_array = array();
        if (!empty($day_array)) {
            foreach ($day_array as $day_no => $day_name) {
                $daily_transfer_count = $this->getDailyTransfersCount($day_no);
                array_push($daily_transfer_count_array, $daily_transfer_count);
                array_push($day_name_array, $day_name);
            }
        }
        $max_no = max($daily_transfer_count_array);
        $daily_transfer_data_array = array('days' => $day_name_array, 'transfer_count_data' => $daily_transfer_count_array);
        return $daily_transfer_data_array;
    }

    // Charts get users days
    public function getAllUsersDays()
    {
        $day_array = array();
        $users_dates = User::where('permission', 2)->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'ASC')->pluck('created_at');
        $users_dates = json_decode($users_dates);
        if (!empty($users_dates)) {
            foreach ($users_dates as $unformatted_date) {
                $date = new \DateTime($unformatted_date);
                $day_no = $date->format('d');
                $day_name = $date->format('D');
                $day_array[$day_no] = $day_name;
            }
        }
        return $day_array;
    }

    // Get daily users count
    public function getDailyUsersCount($day)
    {
        $daily_user_count = User::where('permission', 2)->whereDay('created_at', $day)->get()->count();
        return $daily_user_count;
    }

    // Get daily users data
    public function getDailyUsersData()
    {
        $daily_user_count_array = array();
        $day_array = $this->getAllUsersDays();
        $day_name_array = array();
        if (!empty($day_array)) {
            foreach ($day_array as $day_no => $day_name) {
                $daily_user_count = $this->getDailyUsersCount($day_no);
                array_push($daily_user_count_array, $daily_user_count);
                array_push($day_name_array, $day_name);
            }
        }
        $max_no = max($daily_user_count_array);
        $max = round(($max_no + 10 / 2) / 10) * 10;
        $daily_user_data_array = array(
            'days' => $day_name_array,
            'users_count_data' => $daily_user_count_array,
        );
        return $daily_user_data_array;
    }

    // Redirect to dashboard
    public function redirectAdmin()
    {
        return redirect()->route('admin.dashboard');
    }
}
