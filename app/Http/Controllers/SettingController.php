<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::pluck('value','key'); // ambil semua setting
        return view('pages.settings.setting', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $request->validate([
            'site_name' => 'required',
            'whatsapp' => 'nullable',
            'address' => 'nullable',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|max:2048'
        ]);

        // Upload Logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('settings', 'public');

            Setting::updateOrCreate(
                ['key' => 'site_logo'],
                ['value' => $logoPath]
            );
        }

        // Save basic settings
        $fields = ['site_name', 'whatsapp', 'address','email'];

        foreach ($fields as $field) {
            Setting::updateOrCreate(
                ['key' => $field],
                ['value' => $request->$field]
            );
        }

        return back()->with('success', 'Settings updated successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
