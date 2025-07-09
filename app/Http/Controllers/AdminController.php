<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(){
        $totalOrderCount = Order::whereNotIn('order_status', [])->count();
        $pendingOrderCount = Order::whereIn('order_status', ['Pending'])->count();
        $shippedOrderCount = Order::whereIn('order_status', ['Shipped'])->count();
        $deliveredOrderCount = Order::whereIn('order_status', ['Delivered'])->count();
        $cancelledOrderCount = Order::whereIn('order_status', ['Cancelled'])->count();
        $confirmedOrderCount = Order::whereIn('order_status', ['Confirmed'])->count();

        $totalCustomerCount = Customer::count();
        $latestOrders = Order::orderByDesc('id')->get();
        $testimonials = Testimonial::where('status', 1)->get();

        $currentYear = Carbon::now()->year;
        $monthWiseOrderCount = [
            'currentYear' => [
                'year' => $currentYear,
                'data' => json_encode($this->getMonthWiseOrderCount($currentYear)),
            ],
            'previousYear' => [
                'year' => $currentYear - 1,
                'data' => json_encode($this->getMonthWiseOrderCount($currentYear - 1)),
            ]
        ];

        $monthWiseRevenue = [
            'currentYear' => [
                'year' => $currentYear,
                'data' => json_encode($this->getMonthWiseRevenue($currentYear)),
            ],
            'previousYear' => [
                'year' => $currentYear - 1,
                'data' => json_encode($this->getMonthWiseRevenue($currentYear - 1)),
            ]
        ];

        $orderOverview = [
            'totalOrderCount' => $totalOrderCount,
            'pendingOrderCount' => $pendingOrderCount,
            'shippedOrderCount' => $shippedOrderCount,
            'deliveredOrderCount' => $deliveredOrderCount,
            'cancelledOrderCount' => $cancelledOrderCount,
            'confirmedOrderCount' => $confirmedOrderCount,
        ];

        return view('admin.dashboard', compact('orderOverview', 'totalCustomerCount', 'latestOrders', 'testimonials', 'monthWiseOrderCount', 'monthWiseRevenue'));
    }

    public function profile(){
        return view('admin.profile');
    }

    public function profileUpdate(Request $request){
        $request->validate([
            'name' => 'required', 
            'email' => 'required|email', 
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', 
        ]);

        $userId = auth()->user()->id;

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        User::find($userId)->update($data);

        if (isset($request->profile_image)) {
            $this->storeProfileImage($request->profile_image, $userId);
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function storeProfileImage($image, $id){
        $imagePath = public_path('/images/user-profile').'/'.$id;
        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0775, true);
        }
		
        $imageName = md5(time() . '_' . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
        $image->move($imagePath, $imageName);
        $storedPath = $id.'/'.$imageName;

        User::where('id', $id)->update(['profile_image' => $storedPath]);
    }

    private function getMonthWiseRevenue($year){
        $monthWiseOrderRevenue = Order::select(
                                    DB::raw('MONTH(created_at) as month'),
                                    DB::raw('SUM(total_amount) as month_total_amount')
                                )
                                ->whereYear('created_at', $year)
                                ->groupBy(DB::raw('MONTH(created_at)'))
                                ->pluck('month_total_amount', 'month');
        
        $revenueArray = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenue = $monthWiseOrderRevenue[$i] ?? 0;
            $revenueArray[] = $revenue / 1000 ;
        }

        return $revenueArray;
    }

    private function getMonthWiseOrderCount($year){
        $monthWiseOrderCount = Order::select(
                                    DB::raw('MONTH(created_at) as month'),
                                    DB::raw('COUNT(id) as total_orders')
                                )
                                ->whereYear('created_at', $year)
                                ->groupBy(DB::raw('MONTH(created_at)'))
                                ->pluck('total_orders', 'month');
        
        $orderCountArray = [];
        for ($i = 1; $i <= 12; $i++) {
            $orderCountArray[] = $monthWiseOrderCount[$i] ?? 0;
        }

        return $orderCountArray;
    }
}
