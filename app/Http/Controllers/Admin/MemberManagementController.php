<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class MemberManagementController extends Controller
{
    public function index()
    {
        $members = Member::with('user')->paginate(15);
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_code' => 'required|unique:members',
            'name' => 'required',
            'email' => 'required|email|unique:members',
            'member_type' => 'required|in:student,teacher',
            'class' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);

        $validated['status'] = 'active';

        // Create user account for member
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('password123'), // Default password
            'role' => 'member',
        ]);

        $validated['user_id'] = $user->id;
        $member = Member::create($validated);

        // Generate QR Code
        $qrCode = QrCode::format('png')->size(300)->generate($member->member_code);
        $qrPath = 'qrcodes/members/' . $member->id . '.png';
        Storage::disk('public')->put($qrPath, $qrCode);
        $member->update(['qr_code' => $qrPath]);

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan. Password default: password123');
    }

    public function show(Member $member)
    {
        $member->load('transactions.book', 'fines');
        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('admin.members.form', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'member_code' => 'required|unique:members,member_code,' . $member->id,
            'name' => 'required',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'member_type' => 'required|in:student,teacher',
            'class' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
            'status' => 'required|in:active,inactive',
        ]);

        $member->update($validated);

        // Update user account
        if ($member->user) {
            $member->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);
        }

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil diupdate');
    }

    public function destroy(Member $member)
    {
        if ($member->qr_code) {
            Storage::disk('public')->delete($member->qr_code);
        }

        // Delete associated user
        if ($member->user) {
            $member->user->delete();
        }

        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus');
    }

    public function generateQR(Member $member)
    {
        if ($member->qr_code && Storage::disk('public')->exists($member->qr_code)) {
            return response()->file(storage_path('app/public/' . $member->qr_code));
        }

        $qrCode = QrCode::format('png')->size(300)->generate($member->member_code);
        return response($qrCode)->header('Content-Type', 'image/png');
    }
}
