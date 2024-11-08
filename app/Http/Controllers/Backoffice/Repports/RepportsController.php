<?php

namespace App\Http\Controllers\Backoffice\Repports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backoffice\Quotation;
use Illuminate\Support\Facades\DB;
class RepportsController extends Controller
{
    public function showRepportsQuotesPage()
    {
        $isActive = "repport";
    
        // Récupération des devis avec les relations
        $devis = Quotation::with(['user', 'autoInfo', 'assuranceAutoInfo'])
            ->where('status', '<=', 4)
            ->whereHas('user', function ($query) {
                $query->where('usertype', '<>', 99);
            })
            ->orderBy('id', 'desc')
            ->orderBy('priority', 'asc')
            ->get();
    
        return view("Backoffice.backend.repports.devis", compact("devis", "isActive"));
    }
    
}
