@extends('layouts.app')

@section('title', 'Settings - Shifra')
@section('body-class', 'settings-page')

@section('styles')
<style>
    .settings-page {
        background-color: #f8fbff;
        min-height: 100vh;
        padding-bottom: 100px;
    }

    .settings-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .settings-header {
        margin-bottom: 30px;
        padding: 20px;
        background: white;
        border-radius: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #edf2f7;
    }

    .settings-header h1 {
        font-size: 24px;
        color: #2D3E50;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .settings-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #edf2f7;
        overflow: hidden;
        margin-bottom: 25px;
    }

    .card-header {
        padding: 20px 25px;
        border-bottom: 1px solid #f1f5f9;
        background: #fafafa;
    }

    .card-header h2 {
        font-size: 18px;
        color: #2D3E50;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-body {
        padding: 25px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #2D3E50;
        box-shadow: 0 0 0 3px rgba(45,62,80,0.1);
    }

    .toggle-switch {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
    }

    .toggle-switch label {
        font-size: 15px;
        color: #2D3E50;
        font-weight: 500;
    }

    .toggle-switch input {
        width: 50px;
        height: 24px;
        appearance: none;
        background: #e2e8f0;
        border-radius: 12px;
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .toggle-switch input:checked {
        background: #2D3E50;
    }

    .toggle-switch input::before {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        background: white;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        transition: all 0.3s ease;
    }

    .toggle-switch input:checked::before {
        left: 28px;
    }

    .btn-save {
        padding: 12px 30px;
        background: #2D3E50;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 16px;
    }

    .btn-save:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45,62,80,0.2);
    }
</style>
@endsection

@section('content')
<div class="settings-container">
    <div class="settings-header">
        <h1>
            <i class="fas fa-cog" style="color: #2D3E50;"></i>
            Settings
        </h1>
        <a href="{{ route('profile.edit') }}" class="btn-change-photo" style="padding: 10px 20px;">
            <i class="fas fa-arrow-left"></i> Back to Profile
        </a>
    </div>

    <form action="{{ route('profile.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Notification Settings -->
        <div class="settings-card">
            <div class="card-header">
                <h2><i class="fas fa-bell"></i> Notification Settings</h2>
            </div>
            <div class="card-body">
                <div class="toggle-switch">
                    <label>Enable Notifications</label>
                    <input type="checkbox" name="notifications" value="1" {{ ($settings['notifications'] ?? true) ? 'checked' : '' }}>
                </div>
                <div class="toggle-switch">
                    <label>Email Updates</label>
                    <input type="checkbox" name="email_updates" value="1" {{ ($settings['email_updates'] ?? true) ? 'checked' : '' }}>
                </div>
            </div>
        </div>

        <!-- Appearance Settings -->
        <div class="settings-card">
            <div class="card-header">
                <h2><i class="fas fa-palette"></i> Appearance</h2>
            </div>
            <div class="card-body">
                <div class="toggle-switch">
                    <label>Dark Mode</label>
                    <input type="checkbox" name="dark_mode" value="1" {{ ($settings['dark_mode'] ?? false) ? 'checked' : '' }}>
                </div>
                <div class="form-group">
                    <label>Language</label>
                    <select name="language" class="form-control">
                        <option value="en" {{ ($settings['language'] ?? 'en') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="ar" {{ ($settings['language'] ?? 'en') == 'ar' ? 'selected' : '' }}>العربية</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Account Settings -->
        <div class="settings-card">
            <div class="card-header">
                <h2><i class="fas fa-lock"></i> Account Settings</h2>
            </div>
            <div class="card-body">
                <p style="color: #64748b; margin-bottom: 20px;">
                    Manage your account settings and preferences
                </p>
                <a href="{{ route('profile.edit') }}" style="color: #3182ce; text-decoration: none;">
                    Edit Profile Information →
                </a>
            </div>
        </div>

        <button type="submit" class="btn-save">
            <i class="fas fa-save"></i> Save Settings
        </button>
    </form>
</div>
@endsection