<?php
namespace App\Http\Controllers;

use App\Models\total_facilities;
use App\Models\dentail_facilities;
use Illuminate\Http\Request;

class FacilityManagementController extends Controller
{
    public function index()
    {
        $totals = total_facilities::with('dentail')->get();
        return view('admin.facilities.index', compact('totals'));
    }

    public function create()
    {
        return view('admin.facilities.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'dentail.*.name' => 'required|string|max:255',
            'dentail.*.quantity' => 'required|integer',
        ]);

        $total = total_facilities::create(['name' => $data['name']]);
        
        if (isset($data['dentail'])) {
            foreach ($data['dentail'] as $dentail) {
                $total->dentail()->create([
                    'name' => $dentail['name'],
                    'quantity' => $dentail['quantity'],
                ]);
            }
        }

        return redirect()->route('facility_management.index')
            ->with('success', 'Cơ sở vật chất đã được tạo thành công.');
    }

    public function edit(total_facilities $total)
    {
        return view('admin.facilities.edit', compact('total'));
    }

    public function update(Request $request, total_facilities $total)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'dentail.*.id' => 'nullable|integer|exists:dentail_facilities,id',
            'dentail.*.name' => 'required|string|max:255',
            'dentail.*.quantity' => 'required|integer',
        ]);

        $total->update(['name' => $data['name']]);

        $existingDentailIds = [];
        
        if (isset($data['dentail'])) {
            foreach ($data['dentail'] as $dentail) {
                if (isset($dentail['id'])) {
                    $existingDentail = dentail_facilities::find($dentail['id']);
                    if ($existingDentail) {
                        // Cập nhật thông tin của dentail
                        $existingDentail->update([
                            'name' => $dentail['name'],
                            'quantity' => $dentail['quantity'],
                        ]);
                        $existingDentailIds[] = $existingDentail->id;
                    }
                } else {
                    // Thêm mới dentail facility
                    $newDentail = $total->dentail()->create([
                        'name' => $dentail['name'],
                        'quantity' => $dentail['quantity'],
                    ]);
                    $existingDentailIds[] = $newDentail->id;
                }
            }
        }

        // Xóa các dentail không còn tồn tại trong request
        dentail_facilities::where('total_id', $total->id)
            ->whereNotIn('id', $existingDentailIds)
            ->delete();

        return redirect()->route('facility_management.index')
            ->with('success', 'Cơ sở vật chất đã được cập nhật thành công.');
    }

    public function destroy(total_facilities $total)
    {
        $total->delete();

        return redirect()->route('facility_management.index')
            ->with('success', 'Cơ sở vật chất đã được xóa thành công.');
    }
    public function getDentailFacilities($totalId)
    {
        $dentails = dentail_facilities::where('total_id', $totalId)->get();
        return response()->json($dentails);
    }
    public function increment(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string', 
            'quantity' => 'required|integer|min:1'
        ]);

        $dentail = dentail_facilities::where('name', $data['name'])->first(); 

        if (!$dentail) {
            return response()->json(['error' => 'Dentail facility not found'], 404);
        }

        $dentail->increment('quantity', $data['quantity']);

        return response()->json(['message' => 'Increment successful']);
    }

    public function decrement(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer', 
            'quantity' => 'required|integer|min:1'
        ]);

        $dentail = dentail_facilities::find($data['id']);

        if (!$dentail) {
            return response()->json(['error' => 'Dentail facility not found'], 404);
        }

        if ($dentail->quantity < $data['quantity']) {
            return response()->json(['error' => 'Not enough quantity to decrement'], 400);
        }

        $dentail->decrement('quantity', $data['quantity']);

        return response()->json(['message' => 'Decrement successful']);
    }

}

?>