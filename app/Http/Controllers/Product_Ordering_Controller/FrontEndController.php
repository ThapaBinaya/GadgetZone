<?php
namespace App\Http\Controllers\Product_Ordering_Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Models\Products;

class FrontEndController extends Controller
{
    public function index(Request $request, $purl)
    {
        
        // Get the product details
        $product = Products::where('url', '=', $purl)->first();

        // Get the recommended products based on content-based recommendation
        $recommendedProducts = $this->getRecommendedProducts($product->id);

        return view('Product-Order-Screens.Product_Page')
            ->with('Product', $product)
            ->with('recommendedProducts', $recommendedProducts);

    }

    private function getRecommendedProducts($productId)
    {
        // Get the product details of the current viewed product
        $currentProduct = Products::findOrFail($productId);

        // Concatenate the name and category to create the feature vector
        $currentFeatures = $currentProduct->name . ' ' . $currentProduct->category;

        // Retrieve all products from the database
        $allProducts = Products::where('status', '=', '1')
                               ->where('quantity', '>=', '1')
                               ->get();

        // Initialize an array to store similarity scores
        $similarities = [];

        // Calculate similarity between the current product and all other products
        foreach ($allProducts as $product) {
            // Skip the current product (don't compare it with itself)
            if ($product->id === $productId) {
                continue;
            }

            $features = $product->name . ' ' . $product->category;

            // Calculate cosine similarity
            $similarity = $this->cosineSimilarity($currentFeatures, $features);

            // Store the similarity score along with the product ID
            $similarities[$product->id] = $similarity;
        }

        // Sort the products based on similarity scores in descending order
        arsort($similarities);

        // Get the top 4 most similar product IDs
        $recommendedProductIds = array_slice(array_keys($similarities), 0, 4);

        // Retrieve the recommended products from the database
        $recommendedProducts = Products::whereIn('id', $recommendedProductIds)->orderByRaw("FIELD(id, " . implode(',', $recommendedProductIds) . ")")->get();

        // dd($recommendedProducts);

        return $recommendedProducts;
    }


    // Function to calculate cosine similarity
    private function cosineSimilarity($vec1, $vec2)
    {
        // Convert the vectors to arrays
        $vec1Tokens = explode(' ', $vec1);
        $vec2Tokens = explode(' ', $vec2);

        // Count the occurrences of each term in the vectors
        $vec1TermCounts = array_count_values($vec1Tokens);
        $vec2TermCounts = array_count_values($vec2Tokens);

        // Calculate the dot product
        $dotProduct = 0;
        foreach ($vec1TermCounts as $term => $count) {
            if (isset($vec2TermCounts[$term])) {
                $dotProduct += $count * $vec2TermCounts[$term];
            }
        }

        // Calculate the norms
        $norm1 = 0;
        foreach ($vec1TermCounts as $count) {
            $norm1 += pow($count, 2);
        }

        $norm2 = 0;
        foreach ($vec2TermCounts as $count) {
            $norm2 += pow($count, 2);
        }

        // Calculate the similarity
        if ($norm1 == 0 || $norm2 == 0) {
            return 0; // If any vector has zero length, similarity is zero.
        } else {
            return $dotProduct / (sqrt($norm1) * sqrt($norm2));
        }
    }

}