<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QrCode;
use Illuminate\Support\Facades\Storage;

class QrCodeController extends Controller
{
    /**
     * Display a listing of qr codes
     */
    public function index(Request $request)
    {
        $adminId = $request->user()->id;
        
        $qrCodes = QrCode::where('admin_id', $adminId)
                        ->latest()
                        ->get();

        $qrCodes = $qrCodes->map(function ($qrCode) {
            $qrCodeArray = $qrCode->toArray();
            $qrCodeArray['image_url'] = $qrCode->image ? asset('storage/' . $qrCode->image) : null;
            return $qrCodeArray;
        });

        return response()->json([
            'status' => 'success',
            'data' => $qrCodes,
        ]);
    }

    /**
     * Store a newly created qr code
     */
    public function store(Request $request)
    {
        $adminId = $request->user()->id;
        
        // Ensure admin has only one QR code, or delete previous
        // $existing = QrCode::where('admin_id', $adminId)->first();
        // if ($existing) {
        //     if ($existing->image) Storage::disk('public')->delete($existing->image);
        //     $existing->delete();
        // }

        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'app_url' => 'nullable|url|max:255',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('qrcodes', 'public');
        }

        $qrCode = QrCode::create([
            'admin_id' => $adminId,
            'image' => $imagePath,
            'app_url' => $validatedData['app_url'] ?? null,
        ]);

        $qrCodeArray = $qrCode->toArray();
        $qrCodeArray['image_url'] = $qrCode->image ? asset('storage/' . $qrCode->image) : null;

        return response()->json([
            'status' => 'success',
            'message' => 'QR Code created successfully',
            'data' => $qrCodeArray,
        ], 201);
    }

    /**
     * Display the specified qr code
     */
    public function show(Request $request, $id)
    {
        $adminId = $request->user()->id;
        
        $qrCode = QrCode::where('admin_id', $adminId)
                       ->findOrFail($id);

        $qrCodeArray = $qrCode->toArray();
        $qrCodeArray['image_url'] = $qrCode->image ? asset('storage/' . $qrCode->image) : null;

        return response()->json([
            'status' => 'success',
            'data' => $qrCodeArray,
        ]);
    }

    /**
     * Update the specified qr code
     */
    public function update(Request $request, $id)
    {
        $adminId = $request->user()->id;
        
        $qrCode = QrCode::where('admin_id', $adminId)
                       ->findOrFail($id);

        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'app_url' => 'nullable|url|max:255',
        ]);

        $dataToUpdate = [
            'app_url' => $request->has('app_url') ? $validatedData['app_url'] : $qrCode->app_url,
        ];

        if ($request->hasFile('image')) {
            if ($qrCode->image) {
                Storage::disk('public')->delete($qrCode->image);
            }
            $dataToUpdate['image'] = $request->file('image')->store('qrcodes', 'public');
        }

        $qrCode->update($dataToUpdate);

        $qrCodeArray = $qrCode->fresh()->toArray();
        $qrCodeArray['image_url'] = $qrCodeArray['image'] ? asset('storage/' . $qrCodeArray['image']) : null;

        return response()->json([
            'status' => 'success',
            'message' => 'QR Code updated successfully',
            'data' => $qrCodeArray,
        ]);
    }

    /**
     * Remove the specified qr code
     */
    public function destroy(Request $request, $id)
    {
        $adminId = $request->user()->id;
        
        $qrCode = QrCode::where('admin_id', $adminId)
                       ->findOrFail($id);

        if ($qrCode->image) {
            Storage::disk('public')->delete($qrCode->image);
        }

        $qrCode->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'QR Code deleted successfully',
        ]);
    }
}
