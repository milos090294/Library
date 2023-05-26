<?php


namespace App\Services;

use App\Models\Book;
use App\Models\Member;


class BookService

{

    public function changeMembers($id, $action)
    {
        $member = Member::findOrFail($id);

        if ($action === '-') {

            $member->borrowed_books -= 1;
        } else {
            $member->borrowed_books += 1;
        }

        $member->save();
    }

    public function changeBooks($id, $action)
    {
        $book =  Book::findOrFail($id);

        if ($action === '-') {
            $book->num_off_copies -= 1;
        } else {
            $book->num_off_copies += 1;
        }

        $book->save();
    }
}
