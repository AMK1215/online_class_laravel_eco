<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Vendor;
use App\Models\User;
use App\Http\Requests\VendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with(['user', 'reviews', 'payments'])
            ->withCount(['reviews', 'payments'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.vendor.index', compact('vendors'));
    }

    public function create()
    {
        $users = User::where('type', '!=', 'Player')->get();
        return view('admin.vendor.create', compact('users'));
    }

    public function store(VendorRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            
            $vendor = Vendor::create($validated);

            // Create vendor settings if provided
            if ($request->has('settings')) {
                foreach ($request->settings as $key => $value) {
                    $vendor->settings()->create([
                        'key' => $key,
                        'value' => $value
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.vendors.index')
                ->with('success', 'Vendor created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Vendor creation failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to create vendor. Please try again.');
        }
    }

    public function show($id)
    {
        $vendor = Vendor::with(['user', 'reviews.user', 'payments', 'settings'])
            ->findOrFail($id);

        $recentPayments = $vendor->payments()->latest()->take(5)->get();
        $recentReviews = $vendor->reviews()->with('user')->latest()->take(5)->get();

        return view('admin.vendor.show', compact('vendor', 'recentPayments', 'recentReviews'));
    }


    

    public function edit($id)
    {
        $vendor = Vendor::with(['user', 'settings'])->findOrFail($id);
        $users = User::where('type', '!=', 'Player')->get();
        
        return view('admin.vendor.edit', compact('vendor', 'users'));
    }

    public function update(UpdateVendorRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $vendor = Vendor::findOrFail($id);
            $validated = $request->validated();
            
            $vendor->update($validated);

            // Update vendor settings
            if ($request->has('settings')) {
                $vendor->settings()->delete(); // Remove old settings
                foreach ($request->settings as $key => $value) {
                    $vendor->settings()->create([
                        'key' => $key,
                        'value' => $value
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.vendors.index')
                ->with('success', 'Vendor updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Vendor update failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to update vendor. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $vendor = Vendor::findOrFail($id);
            $vendor->delete();

            return redirect()->route('admin.vendors.index')
                ->with('success', 'Vendor deleted successfully');

        } catch (\Exception $e) {
            Log::error('Vendor deletion failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to delete vendor. Please try again.');
        }
    }

    public function toggleStatus($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->status = !$vendor->status;
        $vendor->save();

        return redirect()->back()
            ->with('success', 'Vendor status updated successfully');
    }

    public function reviews($id)
    {
        $vendor = Vendor::with(['reviews.user'])->findOrFail($id);
        $reviews = $vendor->reviews()->with('user')->paginate(10);

        return view('admin.vendor.reviews', compact('vendor', 'reviews'));
    }

    public function payments($id)
    {
        $vendor = Vendor::with(['payments'])->findOrFail($id);
        $payments = $vendor->payments()->paginate(10);

        return view('admin.vendor.payments', compact('vendor', 'payments'));
    }

    public function settings($id)
    {
        $vendor = Vendor::with(['settings'])->findOrFail($id);
        
        return view('admin.vendor.settings', compact('vendor'));
    }
}
