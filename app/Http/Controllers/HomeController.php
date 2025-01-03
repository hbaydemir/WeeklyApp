<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quest;
use App\Models\Plan;


class HomeController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Kullanıcıya ait planları alın
        $plans = Plan::where('user_id', Auth::id())->get();

        // Quest sorgusu
        $query = Quest::with('plan')->where('user_id', auth()->id());

        // Plan'a göre filtreleme
        if ($request->filled('plan_id')) {
            $query->where('plan_id', $request->plan_id);
        }

        // Tarihe göre filtreleme
        if ($request->filled('date')) {
            $query->whereDate('due_date', $request->date);
        }

        // Show Old Quests
        if (!$request->has('show_old_quests')) {
            $query->whereDate('due_date', '>=', today()->toDateString());
        }

        // Sorguyu çalıştır ve sonuçları al
        $quests = $query->get();

        // Progress Bar Hesaplama
        $total = $quests->count();
        $waiting = $quests->where('status', 'waiting')->count();
        $completed = $quests->where('status', 'completed')->count();
        $notCompleted = $quests->where('status', 'not_completed')->count();

        // Yüzde hesaplama (bölme sıfır hatasını önlemek için kontrol)
        $waitingPercentage = $total > 0 ? ($waiting / $total) * 100 : 0;
        $completedPercentage = $total > 0 ? ($completed / $total) * 100 : 0;
        $notCompletedPercentage = $total > 0 ? ($notCompleted / $total) * 100 : 0;

        return view('home', compact(
            'plans', 
            'quests', 
            'waitingPercentage', 
            'completedPercentage', 
            'notCompletedPercentage'
        ));
    }



}
