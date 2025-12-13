<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Fine;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function dashboard()
    {
        $member = auth()->user()->member;
        
        if (!$member) {
            return redirect()->route('home')->with('error', 'Member profile not found');
        }

        $activeBorrowings = $member->activeBorrowings()->with('book')->get();
        $overdueCount = $activeBorrowings->filter(function($transaction) {
            return $transaction->isOverdue();
        })->count();
        
        $totalFines = $member->totalUnpaidFines();
        $activeBooking = $member->bookings()->where('status', 'pending')->with('book')->first();

        return view('member.dashboard', compact('member', 'activeBorrowings', 'overdueCount', 'totalFines', 'activeBooking'));
    }

    public function profile()
    {
        $member = auth()->user()->member;
        
        return view('member.profile', compact('member'));
    }

    public function history()
    {
        $member = auth()->user()->member;
        $transactions = $member->transactions()->with('book')->orderBy('created_at', 'desc')->paginate(10);

        return view('member.history', compact('transactions'));
    }

    public function fines()
    {
        $member = auth()->user()->member;
        $fines = $member->fines()->with('transaction.book')->orderBy('created_at', 'desc')->paginate(10);
        $totalUnpaid = $member->totalUnpaidFines();

        return view('member.fines', compact('fines', 'totalUnpaid'));
    }
}
