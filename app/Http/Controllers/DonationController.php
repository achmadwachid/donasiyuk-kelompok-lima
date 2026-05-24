<?php

namespace App\Http\Controllers;

use App\Models\DonationRequest;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function showDonatur(Request $request)
    {
        $search = $request->query('search');

        $query = DonationRequest::with(['user.pantiProfile'])
            ->where('quantity_remaining', '>', 0);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('item_name', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Get all active requests grouped by user_id
        $activeRequests = $query->get()->groupBy('user_id');

        return view('halamanutama.donatur', compact('activeRequests'));
    }

    public function showPanti()
    {
        // Panti only sees their own active requests
        $activeRequests = DonationRequest::with(['user.pantiProfile'])
            ->where('user_id', Auth::id())
            ->where('quantity_remaining', '>', 0)
            ->get()
            ->groupBy('user_id');

        return view('halamanutama.panti', compact('activeRequests'));
    }

    public function showHistoryPanti()
    {
        // Get donations for requests made by this panti
        $donations = Donation::with(['user', 'donationRequest'])
            ->whereHas('donationRequest', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayat.panti', compact('donations'));
    }

    public function confirmDonation($id)
    {
        $donation = Donation::findOrFail($id);
        
        // Ensure the panti owning the request is the one confirming
        if ($donation->donationRequest->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $donation->update(['status' => 'sudah diterima']);

        return back();
    }

    public function storeRequest(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity_needed' => 'required|integer|min:1',
            'unit' => 'required|string|max:50',
            'is_urgent' => 'nullable|boolean',
        ]);

        DonationRequest::create([
            'user_id' => Auth::id(),
            'item_name' => $validated['item_name'],
            'quantity_needed' => $validated['quantity_needed'],
            'quantity_remaining' => $validated['quantity_needed'],
            'unit' => $validated['unit'],
            'is_urgent' => $request->has('is_urgent'),
        ]);

        return back();
    }

    public function storeDonation(Request $request)
    {
        $validated = $request->validate([
            'donation_request_id' => 'required|exists:donation_requests,id',
            'quantity_donated' => 'required|integer|min:1',
        ]);

        $donationRequest = DonationRequest::findOrFail($validated['donation_request_id']);
        
        // Ensure quantity donated doesn't exceed remaining
        $quantity = min($validated['quantity_donated'], $donationRequest->quantity_remaining);

        Donation::create([
            'donation_request_id' => $donationRequest->id,
            'user_id' => Auth::id(),
            'quantity_donated' => $quantity,
        ]);

        $donationRequest->decrement('quantity_remaining', $quantity);

        return back();
    }
}
