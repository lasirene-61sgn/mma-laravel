<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\QrCode;
use Illuminate\Support\Facades\Storage;

class QrCodeController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $qrCodes = QrCode::where('admin_id', $admin->id)->latest()->paginate(10);
        return view('admin.qr_code.index', compact('qrCodes'));
    }

    public function create()
    {
        return view('admin.qr_code.create');
    }

    public function store(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'app_url' => 'nullable|url|max:255',
            'image'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $request->file('image')->store('qrcodes', 'public');

        QrCode::create([
            'admin_id' => $admin->id,
            'image'    => $imagePath,
            'app_url'  => $request->app_url,
        ]);

        return redirect()->route('admin.qr-codes.index')
                         ->with('success', 'QR Code added successfully!');
    }

    public function edit($id)
    {
        $admin = Auth::guard('admin')->user();
        $qrCode = QrCode::where('admin_id', $admin->id)->findOrFail($id);
        return view('admin.qr_code.edit', compact('qrCode'));
    }

    public function update(Request $request, $id)
    {
        $admin = Auth::guard('admin')->user();
        $qrCode = QrCode::where('admin_id', $admin->id)->findOrFail($id);

        $request->validate([
            'app_url' => 'nullable|url|max:255',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $qrCode->app_url = $request->app_url;

        if ($request->hasFile('image')) {
            if ($qrCode->image) {
                Storage::disk('public')->delete($qrCode->image);
            }
            $qrCode->image = $request->file('image')->store('qrcodes', 'public');
        }

        $qrCode->save();

        return redirect()->route('admin.qr-codes.index')
                         ->with('success', 'QR Code updated successfully!');
    }

    public function destroy($id)
    {
        $admin = Auth::guard('admin')->user();
        $qrCode = QrCode::where('admin_id', $admin->id)->findOrFail($id);

        if ($qrCode->image) {
            Storage::disk('public')->delete($qrCode->image);
        }

        $qrCode->delete();

        return redirect()->route('admin.qr-codes.index')
                         ->with('success', 'QR Code deleted successfully!');
    }
}
