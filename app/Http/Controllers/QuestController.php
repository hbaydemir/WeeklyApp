<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestController extends Controller
{
    public function store(Request $request)
    {
        // Form doğrulama
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'plan_id' => 'required|exists:plans,id',
            'due_date' => 'required|date',
        ]);

        // Yeni quest oluşturma
        Quest::create([
            'title' => $request->title,
            'description' => $request->description,
            'plan_id' => $request->plan_id,
            'user_id' => Auth::id(),
            'due_date' => $request->due_date,
            'status' => 'waiting',
        ]);

        // Başarı mesajı ve yönlendirme
        return redirect()->back()->with('success', 'Quest başarıyla oluşturuldu!');
    }

    public function updateStatus(Request $request, $id)
    {
        $quest = Quest::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $quest->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Quest status updated successfully!');
    }

    public function update(Request $request, $id)
    {
        $quest = Quest::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'plan_id' => 'required|exists:plans,id',
            'due_date' => 'required|date',
        ]);

        $quest->update([
            'title' => $request->title,
            'description' => $request->description,
            'plan_id' => $request->plan_id,
            'due_date' => $request->due_date,
        ]);

        return redirect()->back()->with('success', 'Quest updated successfully!');
    }

    public function destroy($id)
    {
        $quest = Quest::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $quest->delete();

        return redirect()->back()->with('success', 'Quest deleted successfully!');
    }
}
