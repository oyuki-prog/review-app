<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ReviewRequest;
use Exception;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::with('images')->latest()->paginate(10);
        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reviews.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ReviewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request)
    {
        // dd($request->file('image'));
        $review = new Review($request->all());
        $review->user_id = $request->user()->id;
        DB::beginTransaction();
        try {
            $review->save();

            if ($files = $request->file('image')) {
                foreach ($files as $file) {
                    $fileName = time() . $file->getClientOriginalName();
                    $path = Storage::putFileAs('reviews', $file, $fileName);

                    //新たな画像レコードを作成
                    $image = new Image();
                    $image->review_id = $review->id;
                    $image->name = basename($path);
                    $image->save();
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if($deleteFile = Image::where('review_id', $review->id)) {
                $deleteFile->delete();
            }
            return back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('reviews.show', $review)->with(['flash_message' => '投稿に成功しました']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ReviewRequest  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewRequest $request, Review $review)
    {
        $review->fill($request->all());
        try {
            $review->save();
        } catch (\Exception $e) {
            return back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('reviews.show', $review)->with(['flash_message' => '更新に成功しました']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $images = $review->images;
        $review->delete();

        foreach($images as $image) {
            Storage::delete('reviews/' . $image->name);
        }

        return redirect()
            ->route('reviews.index')
            ->with(['flash_message' => '記事を削除しました']);
    }
}
