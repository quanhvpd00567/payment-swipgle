<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Price;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PricesController extends Controller
{
    // View prices page
    public function index()
    {
        // Get prices
        $prices = Price::orderbyDesc('id')->get();
        return view('backend.prices', ['prices' => $prices]);
    }

    // View add price page
    public function add_price()
    {
        // Get settngs
        $settings = DB::table('settings')->find(1);
        return view('backend.add.price', ['settings' => $settings]);
    }

    // Add price store
    public function add_price_store(Request $request)
    {
        // Validate form
        $validator = Validator::make($request->all(), [
            'space' => ['required', 'numeric'],
            'price' => ['required', 'max:50'],
        ]);

        // Send errors to view page
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // bytes check
        if ($request->space <= 0) {
            return redirect()->back()->withErrors(['Enter valid space number']);
        }

        // check price
        if ($request->price <= 0) {
            return redirect()->back()->withErrors(['Enter valid price']);
        }

        // Create new price
        $price = Price::create([
            'space' => $request->space,
            'price' => $request->price,
        ]);

        // if created
        if ($price) {
            // Back with success message
            $request->session()->flash('success', 'price added successfully');
            return redirect()->route('prices');
        } else {
            // Error response
            return redirect()->back()->withErrors(['Error please refresh page and try again']);
        }
    }

    // View edit price
    public function edit_price($id)
    {
        // Get price data
        $price = Price::where('id', $id)->first();
        // Get settngs
        $settings = DB::table('settings')->find(1);
        // if data not null
        if ($price != null) {
            return view('backend.edit.price', ['price' => $price, 'settings' => $settings]);
        } else {
            // Abort 404 if data null
            return abort(404);
        }
    }

    // Edit price store
    public function edit_price_store(Request $request)
    {
        // Get price data
        $price = Price::where('id', $request->price_id)->first();
        // If price data is null
        if ($price != null) {
            // Validate form
            $validator = Validator::make($request->all(), [
                'space' => ['required', 'numeric'],
                'price' => ['required', 'max:50'],
            ]);

            // Send errors to view page
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            // bytes check
            if ($request->space <= 0) {
                return redirect()->back()->withErrors(['Enter valid space number']);
            }

            // check price
            if ($request->price <= 0) {
                return redirect()->back()->withErrors(['Enter valid price']);
            }

            // Update price
            $update = Price::where('id', $request->price_id)->update([
                'space' => $request->space,
                'price' => $request->price,
            ]);

            // if update
            if ($update) {
                // Back with success message
                $request->session()->flash('success', 'price updated successfully');
                return back();
            } else {
                // Error response
                return redirect()->back()->withErrors(['Error please refresh page and try again']);
            }
        } else {
            // Error response
            return response()->json([
                'error' => 'illegal request',
            ]);
        }
    }

    // Delete price
    public function delete_price($id)
    {
        // get price by id
        $price = Price::where('id', $id)->first();
        // if data not null
        if ($price != null) {
            // Delete price
            $delete = Price::where('id', $id)->delete();
            // if delete
            if ($delete) {
                // Back with success message
                session()->flash('success', 'Price deleted successfully');
                return back();
            } else {
                // Error response
                return redirect()->back()->withErrors(['Delete error please refresh page and try again']);
            }
        } else {
            // Error response
            return redirect()->back()->withErrors(['Delete error please refresh page and try again']);
        }
    }
}
