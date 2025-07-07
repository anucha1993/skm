<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function getToken(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'secretkey' => 'required',
        ]);

        // ตัวอย่างตรวจสอบ user/secretkey (ควรเปลี่ยนเป็นตรวจสอบกับฐานข้อมูลจริง)
        if (
            $request->user === 'admin.labour' &&
            $request->secretkey === 'Qw8!pLz7@kT2#vX9$eR6^bN1&uY4*oM3sD5%jH0' // secretkey ยาวและปลอดภัย
        ) {
            $token = bin2hex(random_bytes(32));
            // เก็บ token ลง cache (ตัวอย่าง)
            Cache::put('api_token_' . $token, $request->user, now()->addHours(2));
            return response()->json(['token' => $token]);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
