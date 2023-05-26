<?php

namespace App\Http\Controllers;

use App\Models\Member;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\StoreMemberRequest;
use Carbon\Carbon;

class MembersController extends Controller
{

    public function index()
    {
        return view('library/members');
    }

    public function getMembers()
    {
        $members = Member::all();
        return $members;
    }

    public function store(StoreMemberRequest $request)
    {
        try {
            $member =  new Member;
            $member->name = $request->name;
            $member->phone = $request->phone;
            $member->address = $request->address;
            $member->card_number = random_int(0, 100000);
            $member->save();
            return response()->json(['message' => 'Member added successfully']);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
        return response()->json(['message' => 'Member removed successfully']);
    }

    public function getMember($id)
    {
        $member = Member::findOrFail($id);
        return $member;
    }

    public function updateMember(StoreMemberRequest $request, $id)
    {
        $member = Member::findOrFail($id);
        $member->name = $request->name;
        $member->phone = $request->phone;
        $member->address = $request->address;
        $member->update();
        return response()->json(['message' => 'Member updated successfully']);
    }

    public function searchMember($search)
    {
        $members = Member::when($search, function ($query) use ($search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('card_number', 'like', '%' . $search . '%');
            });
        })->get();

        return $members;
    }

    public function allBorrowMembers()
    {
        $members = Member::where('borrowed_books', '>', 0)->get();

        if ($members) {
            return $members;
        }
    }

    public function getLateMembers()
    {
        $date = Carbon::now();

        $members = DB::table('members')
            ->join('member_book_borrow', 'members.id', '=', 'member_book_borrow.member_id')
            ->where('member_book_borrow.return_date', '<', $date)
            ->get();
        return $members;
    }
}
