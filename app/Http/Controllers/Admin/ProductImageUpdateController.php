<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductImageUpdateController extends Controller
{
    /**
     * Show the form for updating product image.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        
        return view('admin.product.image-update', compact('product'));
    }

    /**
     * Update the product image.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
        ], [
            'image.required' => 'Please select an image to upload.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            'image.max' => 'The image may not be greater than 10MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Delete old image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            
            // Store new image
            $imagePath = $request->file('image')->store('products', 'public');
            
            // Update product with new image path
            $product->update(['image' => $imagePath]);

            return redirect()->route('admin.products.show', $product->id)
                ->with('success', 'Product image updated successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update product image. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove the product image.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        try {
            // Delete image from storage if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            
            // Update product to remove image reference
            $product->update(['image' => null]);

            return redirect()->route('admin.products.show', $product->id)
                ->with('success', 'Product image removed successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to remove product image. Please try again.');
        }
    }
}
