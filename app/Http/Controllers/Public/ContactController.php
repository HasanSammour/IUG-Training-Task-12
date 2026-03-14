<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        $contactInfo = [
            'address' => 'Palestine - Gaza - Al-Rimal Camp - East of Al-Shifa Medical Hospital',
            'phone' => '+970 59 123 4567',
            'email' => 'shifra.center@gmail.com',
            'hours' => 'Saturday - Thursday: 9:00 AM - 5:00 PM',
            'whatsapp' => 'https://whatsapp.com/channel/0029VbBHUCv8kyyDuKmDzh2w',
            'instagram' => 'https://www.instagram.com/p/DQ_gRYyDMlx/?igsh=b2hieGZqcTM2bmho',
            'map_url' => 'https://www.google.com/maps/place/Al-Shifa+Medical+Complex/@31.5243795,34.4353623,17z/data=!3m1!4b1!4m6!3m5!1s0x14fd7f5a0b9b9b9b:0x9b9b9b9b9b9b9b9b!8m2!3d31.5243795!4d34.4379372!16s%2Fg%2F1td0b0j3?entry=ttu',
        ];
        
        return view('public.contact', compact('contactInfo'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);
        
        // Save to database
        ContactMessage::create($request->all());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message. We will get back to you soon!'
            ]);
        }
        
        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }
}