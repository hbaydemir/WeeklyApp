<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Plan::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Plan başarıyla oluşturuldu!');
    }
}
