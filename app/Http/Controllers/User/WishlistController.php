<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Course;
use App\Models\DigitalProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



class WishlistController extends Controller
{
    /**
     * Display a listing of the user's wishlist.
     */
public function index()
{
    // Simplify to isolate the issue
    $user = Auth::user();
    $wishlistItems = Wishlist::where('user_id', $user->id)->get();
    return view('user.wishlist.index', compact('wishlistItems'));
}

    /**
     * Toggle an item in the wishlist.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'item_type' => 'required|in:course,digital_product',
            'item_id' => 'required|integer',
        ]);
        
        $userId = Auth::id();
        $itemType = $request->item_type;
        $itemId = $request->item_id;
        
        // Check if item exists
        if ($itemType === 'course') {
            $item = Course::find($itemId);
        } else {
            $item = DigitalProduct::find($itemId);
        }
        
        if (!$item) {
            return redirect()->back()->with('error', 'Item not found.');
        }
        
        // Check if item is already in wishlist
        $wishlistItem = Wishlist::where('user_id', $userId)
            ->where('wishlist_type', $itemType)
            ->where('item_id', $itemId)
            ->first();
        
        if ($wishlistItem) {
            // Remove from wishlist
            $wishlistItem->delete();
            $message = 'Item removed from wishlist.';
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => $userId,
                'wishlist_type' => $itemType,
                'item_id' => $itemId,
            ]);
            $message = 'Item added to wishlist.';
        }
        
        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove an item from the wishlist.
     */
    public function destroy(Wishlist $wishlist)
    {
        // Check if wishlist item belongs to the current user
        if ($wishlist->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $wishlist->delete();
        return redirect()->route('user.wishlist.index')->with('success', 'Item removed from wishlist.');
    }
}