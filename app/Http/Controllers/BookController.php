<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\BookDetailResource;


class BookController extends Controller
{
    public function index()
    {
        $books = Book::All();
        return BookDetailResource::collection($books->loadMissing('penulis:id,username', 'reviews'));
    }

    public function show($id)
    {
        $books = Book::with('penulis:id,username')->findOrFail($id);
        return new BookDetailResource($books->loadMissing('penulis:id,username', 'reviews:id,book_id,user_id,reviews_content'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:100',
            'synopsis_content' => 'required',
        ]);

        $image = null;
        if ($request->file){

            //code untuk rename filenya
            $fileName = $this->generateRandomString();

            //code untuk menyimpan extension file yang diupload
            $extension = $request->file->extension();

            //tambahkan kode ini untuk nama file
            $image = $fileName.'.'.$extension;

            //menyimpan file kedalam folder storage/app/image
            Storage::putFileAs('image', $request->file, $image);
        }

        //untuk mengupdate image ke database
        $request['image'] = $image;

        $request['writer'] = Auth::user()->id;

        $book = Book::create($request->all());
        return new BookDetailResource($book->loadMissing('penulis:id,username'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:100',
            'synopsis_content' => 'required',
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->all());

        return new BookDetailResource($book->loadMissing('penulis:id,username'));

    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return new BookDetailResource($book->loadMissing('penulis:id,username'));
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}
