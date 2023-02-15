@extends('layouts.app')
@section('content')
<div class="row" style="--bs-gutter-x: 0em;">
    <div class="row bg-body" style="background-image: url('{{ asset('img/img3.jpg')}}');height: 90vh">
        <div class="col-lg-4 mx-auto my-auto">
            <h1 class="p-3 text-center" style="color:#fff;background-color:rgba(0,0,0,.9);">FASHION</h1>
            <h1 class="p-3 text-center " style="color:#fff;background-color:rgba(0,0,0,.9);">HAS</h1>
            <h1 class="p-3 text-center " style="color:#fff;background-color:rgba(0,0,0,.9);">NO</h1>
            <h1 class="p-3 text-center " style="color:#fff;background-color:rgba(0,0,0,.9);">RULES</h1>
            <div class="row text-center">
                <div class="col">
                    <a href="/products">
                        <button type="button" class="btn btn-primary btn-lg m-5" style="background-color:rgba(0,0,0,.9);border-color:rgba(0,0,0,.9);">
                            Shop Now
                        </button>
                    </a>
                </div>
            </div>
        </div>
        
    </div>
    
</div>
<div class="row mt-5 mb-5" style="--bs-gutter-x: 0em;">
    <h3 class="p-3 text-center " style="color:rgba(0,0,0,.9);">Best Reviewed</h3>
    <div id="carousel" class="carousel slide carousel-dark " data-bs-ride="true">
            <div class="carousel-inner" id="carousel-inner">
            
            </div>
            
            
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        <div class="carousel-indicators mt-5">
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
    </div>
    
</div>
<script>
        
        attachEvents()

        async function attachEvents() {
            url = '/api/products'
            const response = await fetch(url)
            let products = await response.json()
            products.sort((a, b) => parseFloat(a.avg_classification) - parseFloat(b.avg_classification));
            products.reverse()
    
            carouselInner = document.getElementById('carousel-inner')
            let newBody = drawCarouselInner(products)
            console.log(newBody)
            carouselInner.innerHTML = newBody
        }
        function drawCarouselInner(products) {
            let out =""
            let j=0
            for (let i = 0; i < 3; i++) {
                if (i== 0) {
                    out += `<div class="carousel-item text-center active mb-5 ">
                    <div class="row text-center"  style="align-items: center; justify-content: center;">
                    <div class="col-md-3 col-sm-6 mx-4 mt-2 mb-2 d-inline-block" >
                        <div class="product-grid">
                            <div class="product-image shadow">
                                <a href="/products/${products[j].id}" class="image">
                                    <img src="${products[j].images[0]}">
                                </a>
                                <span class="product-discount-label">${havePromo(products[j].promotion.discount)}</span>
                                
                            </div>
                            <div class="product-content shadow" style="height:97px;">
                                <h3 class="title"><a href="/products/${products[j].id}">${products[j].name}</a></h3>
                                <div class="price">${havePromo1(products[j].price,products[j].promotion.discount)} <span>${havePromo2(products[j].price,products[j].promotion.discount)}</span></div>
                            </div>
                        </div>
                    </div>`;
                    j= j+1;

                    out += `<div class="col-md-3 col-sm-6 mx-4 mt-2 mb-2 d-inline-block">
                        <div class="product-grid">
                            <div class="product-image shadow">
                                <a href="/products/${products[j].id}" class="image">
                                    <img src="${products[j].images[0]}">
                                </a>
                                <span class="product-discount-label">${havePromo(products[j].promotion.discount)}</span>
                                
                            </div>
                            <div class="product-content shadow " style="height:97px;">
                                <h3 class="title"><a href="/products/${products[j].id}">${products[j].name}</a></h3>
                                <div class="price">${havePromo1(products[j].price,products[j].promotion.discount)} <span>${havePromo2(products[j].price,products[j].promotion.discount)}</span></div>
                            </div>
                        </div>
                    </div>`;
                    j= j+1;

                    out += `<div class="col-md-3 col-sm-6 mx-4 mt-2 mb-2 d-inline-block">
                        <div class="product-grid">
                            <div class="product-image shadow">
                                <a href="/products/${products[j].id}" class="image">
                                    <img src="${products[j].images[0]}">
                                </a>
                                <span class="product-discount-label">${havePromo(products[j].promotion.discount)}</span>
                                
                            </div>
                            <div class="product-content shadow" style="height:97px;">
                                <h3 class="title"><a href="/products/${products[j].id}">${products[j].name}</a></h3>
                                <div class="price">${havePromo1(products[j].price,products[j].promotion.discount)} <span>${havePromo2(products[j].price,products[j].promotion.discount)}</span></div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>`;
                    j= j+1;


                } else{
                    out += `<div class="carousel-item text-center mb-5">
                    <div class="row text-center"  style="align-items: center; justify-content: center;">
                    <div class="col-md-3 col-sm-6 mx-4 mt-2 mb-2 d-inline-block">
                        <div class="product-grid">
                            <div class="product-image shadow">
                                <a href="/products/${products[j].id}" class="image">
                                    <img src="${products[j].images[0]}">
                                </a>
                                <span class="product-discount-label">${havePromo(products[j].promotion.discount)}</span>
                                
                            </div>
                            <div class="product-content shadow">
                                <h3 class="title"><a href="/products/${products[j].id}">${products[j].name}</a></h3>
                                <div class="price">${havePromo1(products[j].price,products[j].promotion.discount)} <span>${havePromo2(products[j].price,products[j].promotion.discount)}</span></div>
                            </div>
                        </div>
                    </div>`;
                    j = j+1;
                    out += `<div class="col-md-3 col-sm-6 mx-4 mt-2 mb-2 d-inline-block">
                        <div class="product-grid">
                            <div class="product-image shadow">
                                <a href="/products/${products[j].id}" class="image">
                                    <img src="${products[j].images[0]}">
                                </a>
                                <span class="product-discount-label">${havePromo(products[j].promotion.discount)}</span>
                                
                            </div>
                            <div class="product-content shadow">
                                <h3 class="title"><a href="/products/${products[j].id}">${products[j].name}</a></h3>
                                <div class="price">${havePromo1(products[j].price,products[j].promotion.discount)} <span>${havePromo2(products[j].price,products[j].promotion.discount)}</span></div>
                            </div>
                        </div>
                    </div>`;
                    j =j+1;
                    out+=`<div class="col-md-3 col-sm-6 mx-4 mt-2 mb-2 d-inline-block">
                        <div class="product-grid">
                            <div class="product-image shadow">
                                <a href="/products/${products[j].id}" class="image">
                                    <img src="${products[j].images[0]}">
                                </a>
                                <span class="product-discount-label">${havePromo(products[j].promotion.discount)}</span>
                                
                            </div>
                            <div class="product-content shadow">
                                <h3 class="title"><a href="/products/${products[j].id}">${products[j].name}</a></h3>
                                <div class="price">${havePromo1(products[j].price,products[j].promotion.discount)} <span>${havePromo2(products[j].price,products[j].promotion.discount)}</span></div>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>`;
                    j=j+1;


                }
            }

            return out;
        }
       

        function havePromo2(value, promo) {
            let result;
            if (promo == undefined) {
                result = "";
            } else {
                result = value + '€';
            }
            return result;
        }

        function havePromo1(value, promo) {
            let result;
            if (promo == undefined) {
                result = value + '€';
            } else {
                result = Math.round(value - (value * (promo / 100))) + '€';
            }
            return result;
        }

        function havePromo(promo) {
            let result;
            if (promo == undefined) {
                result = "";
            } else {
                result = '-' + promo + '%';
            }
            return result;
        }
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
@endsection
