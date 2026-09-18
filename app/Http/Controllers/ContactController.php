<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        // Honeypot: bots fill hidden fields. Pretend success without storing.
        if ($request->filled('website')) {
            return response()->json(['ok' => true], 201);
        }

        $validated = $request->validate([
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'source' => ['nullable', 'string', 'max:50'],
        ]);

        $contactMessage = ContactMessage::create([
            'first_name' => $validated['firstName'],
            'last_name' => $validated['lastName'] ?? null,
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
            'source' => $validated['source'] ?? 'contact',
            'ip' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        Log::info('Contact message received', [
            'id' => $contactMessage->id,
            'email' => $contactMessage->email,
            'subject' => $contactMessage->subject,
            'source' => $contactMessage->source,
        ]);

        return response()->json(['ok' => true, 'id' => $contactMessage->id], 201);
    }
}
