<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function showPieChart()
    {
        // Fetch your data from the database or any other source
        $data = [
            'label1' => 30,
            'label2' => 50,
            'label3' => 20,
        ];

        // Pass the data to the view
        $pieChart = json_encode([
            'pieData' => array_values($data), // Extract values from the associative array
            'pieLabels' => array_keys($data), // Extract keys as labels
        ]);

        return view('transaction.blade.php', compact('pieChart'));
    }
}


