<?php
namespace App\Http\Controllers;

use App\Models\total_fatilities;
use App\Models\dentail_fatilities;
use Illuminate\Http\Request;

class FacilityManagementController extends Controller
{
    public function index()
    {
        $totals = total_fatilities::with('dentail')->get();
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
            'dentail.*.status' => 'required|integer',
            'dentail.*.quantity' => 'required|integer',
        ]);

        $total = total_fatilities::create(['name' => $data['name']]);
        
        if (isset($data['dentail'])) {
            foreach ($data['dentail'] as $dentail) {
                $total->dentail()->create($dentail);
            }
        }

        return redirect()->route('facility_management.index')
            ->with('success', 'Cơ sở vật chất đã được tạo thành công.');
    }

    public function edit(total_fatilities $total)
    {
        return view('admin.facilities.edit', compact('total'));
    }

    public function update(Request $request, total_fatilities $total)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'dentail.*.id' => 'nullable|integer|exists:dentail_fatilities,id',
            'dentail.*.name' => 'required|string|max:255',
            'dentail.*.status' => 'required|integer',
            'dentail.*.quantity' => 'required|integer',
        ]);

        $total->update(['name' => $data['name']]);

        $existingDentailIds = [];
        
        if (isset($data['dentail'])) {
            foreach ($data['dentail'] as $dentail) {
                if (isset($dentail['id'])) {
                    $existingDentail = dentail_fatilities::find($dentail['id']);
                    if ($existingDentail) {
                        // Cập nhật thông tin của dentail
                        $existingDentail->update($dentail);
                        $existingDentailIds[] = $existingDentail->id;
                    }
                } else {
                    // Thêm mới dentail facility
                    $newDentail = $total->dentail()->create($dentail);
                    $existingDentailIds[] = $newDentail->id;
                }
            }
        }

        // Xóa các dentail không còn tồn tại trong request
        dentail_fatilities::where('total_id', $total->id)
            ->whereNotIn('id', $existingDentailIds)
            ->delete();

        return redirect()->route('facility_management.index')
            ->with('success', 'Cơ sở vật chất đã được cập nhật thành công.');
    }

    public function destroy(total_fatilities $total)
    {
        $total->delete();

        return redirect()->route('facility_management.index')
            ->with('success', 'Cơ sở vật chất đã được xóa thành công.');
    }
    public function getDentailFacilities($totalId)
    {
        $dentails = dentail_fatilities::where('total_id', $totalId)->get();
        return response()->json($dentails);
    }
}

?>