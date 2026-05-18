<?php

namespace App\Http\Controllers\ToappAdmin;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SettingController extends Controller
{
    public function edit()
    {
        return view('toapp_admin.settings.edit', [
            'pageTitle' => 'Settings',
            'settings' => GeneralSetting::first() ?? $this->defaultSettings(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:40'],
            'cur_text' => ['required', 'string', 'max:40'],
            'cur_sym' => ['required', 'string', 'max:40'],
            'email_from' => ['nullable', 'email', 'max:40'],
            'email_from_name' => ['nullable', 'string', 'max:255'],
            'paginate_number' => ['required', 'integer', 'min:5', 'max:100'],
            'registration' => ['nullable', 'boolean'],
            'ev' => ['nullable', 'boolean'],
            'sv' => ['nullable', 'boolean'],
            'kv' => ['nullable', 'boolean'],
            'maintenance_mode' => ['nullable', 'boolean'],
            'secure_password' => ['nullable', 'boolean'],
        ]);

        $settings = GeneralSetting::firstOrNew(['id' => 1]);
        $settings->site_name = $validated['site_name'];
        $settings->cur_text = $validated['cur_text'];
        $settings->cur_sym = $validated['cur_sym'];
        $settings->email_from = $validated['email_from'] ?? null;
        $settings->email_from_name = $validated['email_from_name'] ?? null;
        $settings->paginate_number = $validated['paginate_number'];
        $settings->registration = (int) ($validated['registration'] ?? 0);
        $settings->ev = (int) ($validated['ev'] ?? 0);
        $settings->sv = (int) ($validated['sv'] ?? 0);
        $settings->kv = (int) ($validated['kv'] ?? 0);
        $settings->maintenance_mode = (int) ($validated['maintenance_mode'] ?? 0);
        $settings->secure_password = (int) ($validated['secure_password'] ?? 0);
        $settings->save();

        return back()->with('status', 'Settings updated successfully.');
    }

    private function defaultSettings(): GeneralSetting
    {
        return new GeneralSetting([
            'site_name' => 'To-app',
            'cur_text' => 'USD',
            'cur_sym' => '$',
            'paginate_number' => 20,
            'registration' => 1,
            'ev' => 0,
            'sv' => 0,
            'kv' => 0,
            'maintenance_mode' => 0,
            'secure_password' => 0,
        ]);
    }
}
