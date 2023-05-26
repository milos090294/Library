<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\IssuingRequest;
use App\Http\Requests\StoreBookRequest;
use App\Services\BookService;

class BookController extends Controller
{
    public function index()
    {
        return view('library/books');
    }

    public function getBooks()
    {
        $books = Book::all();
        return  $books;
    }

    public function store(StoreBookRequest $request)
    {
        try {
            $book = Book::create($request->all());
            return response()->json(['message' => 'Book added successfully']);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public  function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json(['message' => 'Book deleted successfully']);
    }

    public function getBook($id)
    {
        $book = Book::findOrFail($id);
        return $book;
    }

    public function updateBook(StoreBookRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->update($request->all());
        return response()->json(['message' => 'Book updated successfully']);
    }

    public function searchBook($search)
    {
        $books = Book::when($search, function ($query) use ($search) {
            return $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%');
            });
        })->get();

        return $books;
    }

    public function issuingView()
    {
        return view('library/issuing');
    }

    public function returnView()
    {
        return view('library/return');
    }

    public function addIssuing(IssuingRequest $request, BookService $book_service)
    {

        $sql = "INSERT INTO member_book_borrow (member_id, book_id, return_date) VALUES (?, ?, ?)";
        $res = DB::insert($sql, [
            $request->member,
            $request->book,
            Carbon::now()->addDays(10),
        ]);

        if ($res) {
            $book_service->changeMembers($request->member, '+');
            $book_service->changeBooks($request->book, '-');
        }

        return response()->json(['message' => 'Success']);
    }


    public function returnBook(Request $request, BookService $book_service)
    {
        $results = DB::table('member_book_borrow')
            ->where('book_id', '=', $request->book)
            ->where('member_id', '=',  $request->member)
            ->delete();

        $book_service->changeMembers($request->member, '-');
        $book_service->changeBooks($request->book, '+');

        return response()->json(['message' => 'Success']);
    }

    public function membersBooks($id)
    {
        $books = DB::table('books')
            ->join('member_book_borrow', 'books.id', '=', 'member_book_borrow.book_id')
            ->where('member_book_borrow.member_id', '=', $id)
            ->get();

        return $books;
    }
}
