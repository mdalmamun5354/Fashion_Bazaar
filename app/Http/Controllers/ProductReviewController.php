<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use App\Models\ProductReviewLike;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use function Symfony\Component\HttpFoundation\Session\Storage\save;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'comment' => 'required|max:1000',
            ]);


            $review = new ProductReview();
            $review->fill($request->all());
            $review->save();

            Toastr::success('Successfully created comment.', 'Comment created!', ["positionClass" => "toast-top-center"]);

            $preUrl = $request->input('preUrl');
            if (isset($preUrl))
                return redirect()->to($preUrl)->with('success', 'Comment stored successfully.');
            return redirect()->back()->with('success', 'Comment stored successfully.');
        }  catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductReview  $productReview
     * @return \Illuminate\Http\Response
     */
    public function show(ProductReview $productReview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductReview  $productReview
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductReview $productReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductReview  $productReview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        try {
//            dd($request);
            $this->validate($request, [
                'comment' => 'nullable|string|max:1000',
            ]);

            $review = ProductReview::findOrFail($id);
            $review->comment = $request->input('comment') ?? $review->comment;
            $review->status = $request->input('status') ?? $review->status;
            $review->stars = $request->input('stars') ?? $review->stars;
            $review->save();

            Toastr::success('Successfully updated comment.', 'Comment updated!', ["positionClass" => "toast-top-center"]);

            $preUrl = $request->input('preUrl');
            if (isset($preUrl))
                return redirect()->to($preUrl)->with('success', 'Comment updated successfully.');
            return redirect()->back()->with('success', 'Comment updated successfully.');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function like(Request $request) {
        $reviewId = $request->input('review_id');
        $userId = $request->input('user_id');

        // Check if the like already exists
        $likeExists = ProductReviewLike::where('review_id', $reviewId)
            ->where('user_id', $userId)
            ->first();

        if (!$likeExists) {
            // If the like doesn't exist, create a new like
            $like = new ProductReviewLike();
            $like->fill($request->all());
            $like->save();
        } else {
            // If the like exists, remove it (unlike)
            $likeExists->delete();
        }

        // Get the updated like count
        $likeCount = ProductReviewLike::where('review_id', $reviewId)->count();

        return response()->json(['success' => true, 'likeCount' => $likeCount, 'isLiked' => !$likeExists]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductReview  $productReview
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ProductReview $review)
    {
        $review->delete();
//        Toastr::error('The review has been removed.', 'Review removed!', ["positionClass" => "toast-top-center"]);
        return redirect()->to($request->input('preUrl'))->with('success', 'Review deleted successfully.');
    }
}
