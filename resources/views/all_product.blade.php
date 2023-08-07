@extends('layout')
@section('title') GadgetZone @endsection
@section('keywords') Home,About,Contact,Car @endsection
@section('description') Write some descripton about the webpage @endsection
@section('content')
<style>

    .checked {
      color: orange;
    }
    </style> 

<!-- Products Starts Here -->
<section id="Products" align="center" class="px-5 py-2 wow animated fadeInUpBig fast" style=" font-family: 'Balsamiq Sans', cursive;">
    <hr class="col-md-12"> 
    <h1 class="black-text" align="center" style="font-weight:bold; ">ALL PRODUCTS</h1> 
    <div align="center">
        <p  class="col-md-3" style=" border-bottom: 2px solid #003399;"></p>
    </div>

    <div class="row">
        <div class="col-md-2 my-4 px-0">
            <div class="card " >
                <div class="card-header py-1">
                    <h1 class="" align="center" style="font-weight:bold; font-size: 25px; color: #038596; ">FILTER</h1> 
                </div>
                <div class="search card-header px-1 py-1">
                    <form id="search-form" class="form-inline" >
                            <div class="" >
                                <select class="form-control" name="search_box" id="search_box" style="width: 170px">
                                    <option value="">All</option>
                                    <option value="phone">Phone</option>
                                    <option value="laptop">Laptop</option>
                                    <option value="desktop">Desktop</option>
                                    <option value="tablet">Tablet</option>
                                    <option value="keyboard">Keyboard</option>
                                    <option value="mouse">Mouse</option>
                                    <option value="cpu">Cpu</option>
                               </select>
                               {{-- <input type="text" class="form-control" name="search_box" id="search_box" placeholder="Search Product" style="width: 83%"> --}}
                                <button type="submit" style="background-color: #038596; color: aliceblue; " ><i class="fa fa-search" aria-hidden="true"></i></button>    
                            </div>     
                    </form>
                </div>
                <div class="card-body py-1 px-1" style="font-size: 15px">
                    <div class="">
                        <div class="card-header py-1">
                            <p class="black-text my-0" align="center" style="font-weight:bold;">Sort by Price</p> 
                        </div>
                        <div class="">
                            <!-- Checkbox for Price Sorting -->
                            <input type="checkbox" name="sort_price_low" id="sort_price_low">
                            <label for="sort_price_low">Low to High</label>
                        </div>
                        <div class="">
                            <!-- Checkbox for Price Sorting -->
                            <input type="checkbox" name="sort_price_high" id="sort_price_high">
                            <label for="sort_price_high">High to Low</label>
                        </div>
                    </div>
                    <div class="">
                        <div class="card-header py-1">
                            <p class="black-text my-0" align="center" style="font-weight:bold;">Sort by Newest</p> 
                        </div>
                        <div class="">
                            <!-- Checkbox for Newest Sorting -->
                            <input type="checkbox" name="sort_newest" id="sort_newest">
                            <label for="sort_newest">Newest</label>
                        </div>
                    </div> 
                    <hr class="my-1">
                </div>
            </div>
    
        </div>
    
        <div class="col-md-10">
            <div id="product-list" class="row my-4 px-4 "  style="width:100%;" >
                @foreach($Products as $item)
                <div class="col-md-3 px-4 " style="padding-bottom: 50px;" >
                    <div style="height: 200px; overflow:hiden;">
                      <a href="{{url('Shop/'.$item->url)}}" >
                        <img style="width: 100%;height: 100%;object-fit: cover;" src=" {{asset('Uploads/Products/'.$item->image1)}}" alt="" class="img-fluid">
                        </a>
                    </div>
                    <div align="center" class="py-2" style="background:white;">
                      <span class="black-text my-3" style="font-weight:bold; font-family: 'Balsamiq Sans', cursive;">{{$item->name}}</span>
                      <br>
                      Price : Rs. {{$item->price}}<br>
                        @if($item->rating==1)
                                      <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star "></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    @elseif($item->rating==2)
                                    <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star "></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                      @elseif($item->rating==3)
                                      <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    
                                      @elseif($item->rating==4)
                                      <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                    
                                      @else
                                      <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                      @endif
                                       
                                      <br>
                     
                         <a href="Shop/{{$item->url}}" class="btn  btn-primary    "> Shop Now</a>
                      
                    </div>
                </div>  
               @endforeach
          
              </div>
        </div>
    </div>

    <hr class="col-md-12"> 
</section>
<!-- Products Ends Here --> 

<script>
  // Detect when checkboxes are clicked
  document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
      checkbox.addEventListener('change', function() {

         console.log('Checkbox clicked!');
          // Check if any checkbox is checked
          if (document.querySelector('input[type="checkbox"]:checked')) {
              // Trigger the AJAX request
              fetchSortedProducts();
          } else {
              // If no checkbox is checked, display all products (default view)
              displayAllProducts();
          }
      });
  });

  // Detect when the search form is submitted
  document.getElementById('search-form').addEventListener('submit', function(event) {
        event.preventDefault();
        // Trigger the AJAX request with the search term
        fetchSortedProducts();
    });

  // Function to fetch and display sorted products via AJAX
  function fetchSortedProducts() {
      // Get the selected sorting criteria (checkboxes) values
      const sortByPriceLow = document.getElementById('sort_price_low').checked;
      const sortByPriceHigh = document.getElementById('sort_price_high').checked;
      const sortByNewest = document.getElementById('sort_newest').checked;

       // Get the search term from the search box
      const searchTerm = document.getElementById('search_box').value;

      // Prepare the sorting criteria to be sent in the request body
      const formData = new URLSearchParams();
      if (searchTerm) {
          formData.append('search_term', searchTerm);
      } 
      if (sortByPriceLow) {
          formData.append('sort_by', 'price_low');
      } else if (sortByPriceHigh) {
          formData.append('sort_by', 'price_high');
      } else if (sortByNewest) {
          formData.append('sort_by', 'newest');
      } 

      // Perform the AJAX request using Fetch API
      fetch('/fetch-sorted-products', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: formData.toString()
      })
      .then(response => response.json())
      .then(data => {

        console.log(data); // Add this line to check the response

          // Call a function to update the UI with the sorted products data
          updateProductList(data);
      })
      .catch(error => console.error('Error:', error));
  }

  // Function to display all products (default view)
  function displayAllProducts() {
      // You can simply reload the page to display all products or implement custom logic here
      // For example, you can call fetchSortedProducts() again without passing any sorting criteria to show all products.
      fetchSortedProducts();
  }

  // Function to update the UI with the sorted products data
function updateProductList(products) {
  // Check if the response contains a valid array of products
  if (Array.isArray(products) && products.length > 0) {
    // Get the product list container element
    const productListContainer = document.getElementById('product-list');

    // Clear the existing content
    productListContainer.innerHTML = '';

    // Loop through the products and create the HTML for each product
    products.forEach(product => {
      const productHTML = `
        <div class="col-md-3 px-4" style="padding-bottom: 50px;">
          <div style="height: 200px; overflow:hidden;">
            <a href="/Shop/${product.url}">
              <img style="width: 100%; height: 100%; object-fit: cover;" src="{{ asset('Uploads/Products/${product.image1}') }}" alt="" class="img-fluid">
            </a>
          </div>
          <div align="center" class="py-2" style="background: white;">
            <span class="black-text my-3" style="font-weight: bold; font-family: 'Balsamiq Sans', cursive;">${product.name}</span>
            <br>
            Price: Rs. ${product.price}<br>
            ${getStarRatingHTML(product.rating)}
            <br>
            <a href="/Shop/${product.url}" class="btn btn-primary">Shop Now</a>
          </div>
        </div>
      `;
      // Append the product HTML to the container
      productListContainer.innerHTML += productHTML;
    });
  } else {
        // If no products found, display a message or handle it as you wish
        const productListContainer = document.getElementById('product-list');
        productListContainer.innerHTML = `
        <div style= "justify-items: center;">
            <h3 style="font-weight: bold;width: 100%;">No products found.</h3>
        </div>
        `;
    }
}

// Helper function to get the HTML for star rating
function getStarRatingHTML(rating) {
  let starsHTML = '';
  for (let i = 1; i <= 5; i++) {
    const starClass = i <= rating ? 'fa-star checked' : 'fa-star';
    starsHTML += `<span class="fa ${starClass}"></span>`;
  }
  return starsHTML;
}
</script>
    
 
@endsection
  